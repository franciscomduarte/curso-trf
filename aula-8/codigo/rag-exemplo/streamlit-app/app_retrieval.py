"""
RAG com retrieval de verdade (chunking + embeddings + similaridade de cosseno).

Companheiro de app.py (que manda o documento inteiro no prompt, sem retrieval).
Aqui, cada pergunta busca só os trechos mais relevantes antes de gerar a resposta —
o mesmo fluxo ensinado nas Etapas 1 e 2 da Aula 8 e implementado em
rag_enap_colab_embeddings.ipynb.
"""

import io
import os

import numpy as np
import streamlit as st
from dotenv import load_dotenv
from openai import OpenAI
from pypdf import PdfReader
from sentence_transformers import SentenceTransformer

load_dotenv()
api_key = os.getenv("OPENAI_API_KEY")

st.set_page_config(page_title="RAG com retrieval — IA e PDFs", page_icon="🔎", layout="wide")

PDF_FOLDER = "pdfs/"
TAMANHO_CHUNK = 800
SOBREPOSICAO = 100
TOP_K = 5


def extrair_texto_pdf(caminho):
    leitor = PdfReader(caminho)
    texto = ""
    for pagina in leitor.pages:
        texto_pagina = pagina.extract_text() or ""  # páginas sem texto extraível não quebram a extração
        texto += texto_pagina + "\n"
    return texto


def dividir_em_chunks(texto, tamanho=TAMANHO_CHUNK, sobreposicao=SOBREPOSICAO):
    chunks = []
    inicio = 0
    n = len(texto)
    while inicio < n:
        fim = min(inicio + tamanho, n)
        chunk = texto[inicio:fim].strip()
        if chunk:
            chunks.append(chunk)
        if fim == n:
            break
        inicio = fim - sobreposicao
    return chunks


def similaridade_cosseno(a, b):
    a = np.asarray(a, dtype=np.float32)
    b = np.asarray(b, dtype=np.float32)
    return float(np.dot(a, b) / (np.linalg.norm(a) * np.linalg.norm(b) + 1e-10))


@st.cache_resource(show_spinner="Carregando modelo de embeddings (uma vez só)...")
def carregar_modelo():
    return SentenceTransformer("paraphrase-multilingual-MiniLM-L12-v2")


@st.cache_data(show_spinner="Extraindo, dividindo em chunks e gerando embeddings dos PDFs...")
def montar_indice(pdf_files, pasta):
    _modelo = carregar_modelo()
    chunks = []
    for nome_arquivo in pdf_files:
        texto = extrair_texto_pdf(os.path.join(pasta, nome_arquivo))
        for i, texto_chunk in enumerate(dividir_em_chunks(texto)):
            chunks.append({"id": f"{nome_arquivo}-{i}", "fonte": nome_arquivo, "texto": texto_chunk})
    if not chunks:
        return chunks
    textos = [c["texto"] for c in chunks]
    vetores = _modelo.encode(textos, show_progress_bar=False, batch_size=32)
    for chunk, vetor in zip(chunks, vetores):
        chunk["embedding"] = vetor
    return chunks


def buscar(pergunta, indice, top_k=TOP_K):
    modelo = carregar_modelo()
    embedding_pergunta = modelo.encode([pergunta])[0]
    resultados = [(c, similaridade_cosseno(embedding_pergunta, c["embedding"])) for c in indice]
    resultados.sort(key=lambda par: par[1], reverse=True)
    return resultados[:top_k]


st.title("🔎 RAG com retrieval — IA e PDFs")
st.caption(
    "Diferente de app.py (documento inteiro no prompt), aqui cada pergunta busca só os "
    "trechos mais relevantes antes de gerar a resposta — chunking, embeddings e "
    "similaridade de cosseno rodando localmente, de graça."
)

if not api_key:
    st.error("⚠️ A chave da API OpenAI não foi encontrada. Verifique o arquivo .env (local) ou os Secrets (Streamlit Cloud).")
    st.stop()

if not os.path.isdir(PDF_FOLDER):
    st.error(f"Pasta '{PDF_FOLDER}' não encontrada.")
    st.stop()

pdf_files = sorted(f for f in os.listdir(PDF_FOLDER) if f.endswith(".pdf"))
if not pdf_files:
    st.error(
        f"Nenhum PDF encontrado na pasta '{PDF_FOLDER}'. "
        "Envie os relatórios de 2023 e 2024 para continuar."
    )
    st.stop()

with st.sidebar:
    st.subheader("Documentos indexados")
    for nome in pdf_files:
        st.write(f"- {nome}")
    st.subheader("Parâmetros")
    top_k = st.slider("TOP_K (chunks recuperados por pergunta)", min_value=1, max_value=10, value=TOP_K)

indice = montar_indice(tuple(pdf_files), PDF_FOLDER)
if not indice:
    st.error("Não foi possível extrair texto de nenhum PDF indexado.")
    st.stop()

st.success(f"Índice pronto: {len(indice)} chunks, de {len(pdf_files)} documento(s).")

if "historico_retrieval" not in st.session_state:
    st.session_state.historico_retrieval = []

pergunta = st.text_input("Digite sua pergunta:")

if st.button("🔎 Buscar e responder"):
    if not pergunta:
        st.warning("Digite uma pergunta antes de buscar.")
    else:
        with st.spinner("Buscando trechos relevantes..."):
            resultados = buscar(pergunta, indice, top_k=top_k)

        with st.expander(f"Chunks recuperados ({len(resultados)}) — veja antes de conferir a resposta", expanded=True):
            for chunk, score in resultados:
                st.markdown(f"**[{chunk['fonte']} · {chunk['id']}] score={score:.3f}**")
                st.write(chunk["texto"][:400] + ("..." if len(chunk["texto"]) > 400 else ""))
                st.divider()

        contexto_recuperado = "\n\n".join(
            f"[Fonte: {c['fonte']}, trecho {c['id']}, score {s:.2f}]\n{c['texto']}" for c, s in resultados
        )
        historico_texto = "\n".join(
            f"Pergunta: {h['pergunta']}\nResposta: {h['resposta']}" for h in st.session_state.historico_retrieval
        )
        prompt = (
            "Responda à pergunta usando SOMENTE os trechos recuperados abaixo. "
            "Se a resposta não estiver nos trechos, diga explicitamente que não encontrou "
            "informação suficiente nas fontes recuperadas — não invente.\n\n"
            f"Trechos recuperados:\n{contexto_recuperado}\n\n"
            f"Histórico da conversa:\n{historico_texto}\n\n"
            f"Pergunta: {pergunta}\nResposta:"
        )

        with st.spinner("Gerando resposta com o LLM..."):
            try:
                client = OpenAI(api_key=api_key)
                completion = client.chat.completions.create(
                    model="gpt-4o-mini",
                    messages=[{"role": "user", "content": prompt}],
                    max_tokens=250,
                )
                resposta = completion.choices[0].message.content
                fontes = sorted({c["fonte"] for c, _ in resultados})

                st.session_state.historico_retrieval.append({"pergunta": pergunta, "resposta": resposta})
                st.success("Resposta gerada com sucesso!")
                st.markdown(f"**Resposta:** {resposta}")
                st.caption(f"Fontes citadas na busca: {', '.join(fontes)}")
            except Exception as e:
                st.error(f"Erro ao consultar IA: {e}")

if st.session_state.historico_retrieval:
    st.subheader("Histórico de perguntas")
    for h in reversed(st.session_state.historico_retrieval):
        st.markdown(f"**{h['pergunta']}**")
        st.write(h["resposta"])
        st.divider()
