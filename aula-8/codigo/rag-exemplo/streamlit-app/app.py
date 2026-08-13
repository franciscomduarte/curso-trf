import streamlit as st
import PyPDF2
import os
from openai import OpenAI
from dotenv import load_dotenv  # Para carregar variáveis do .env

# Carregar variáveis do .env
load_dotenv()

# Obter a chave da API do ambiente
api_key = os.getenv("OPENAI_API_KEY")

# Verificar se a API Key está definida
if not api_key:
    st.error("⚠️ A chave da API OpenAI não foi encontrada. Verifique o arquivo .env (local) ou os Secrets (Streamlit Cloud).")
    st.stop()

client = OpenAI(api_key=api_key)

# Diretório onde os PDFs estão armazenados
PDF_FOLDER = "pdfs/"

# Função para extrair texto do PDF
def extrair_texto_pdf(pdf_path):
    texto = ""
    with open(pdf_path, "rb") as arquivo:
        leitor = PyPDF2.PdfReader(arquivo)
        for pagina in range(len(leitor.pages)):
            texto_pagina = leitor.pages[pagina].extract_text() or ""  # páginas sem texto extraível não quebram a extração
            texto += texto_pagina + "\n"
    return texto

# Configuração da página
st.set_page_config(page_title="RAG com IA e PDFs", page_icon="📄", layout="wide")

# Inicializar sessão para manter histórico e pergunta
if "historico" not in st.session_state:
    st.session_state.historico = []
if "pergunta" not in st.session_state:
    st.session_state.pergunta = ""


# Incluir Bootstrap
st.markdown(
    """
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk1k4e3p09H9XWhFq6u6qD8S/g5T7f6Wg7d5z5O4M"
        crossorigin="anonymous"
    >
    """,
    unsafe_allow_html=True
)

# Layout principal
st.markdown(
    """
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="text-primary">Trabalho de RAG com IA</h1>
                <p class="lead"><b>Professor:</b> Hélio Bomfim de Macêdo Filho </p>
                <p class="lead"><b>Disciplina:</b> Inteligência Artificial Generativa no contexto da Administração Pública</p>
                <p class="lead"><b>Aluno:</b> Francisco Carlos Molina Duarte Júnior</p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title">Relatórios de Gestão da Enap (2023 e 2024)</h5>
                        <p class="card-text">Os Relatórios de Gestão da Enap consolidam os principais resultados e avanços da Escola Nacional de Administração Pública em cada exercício: governança institucional, planejamento estratégico, execução orçamentária, capacitação, inovação e cooperação federativa. O relatório de 2024 destaca, entre outros pontos, a realização do XXIX Congresso Internacional do CLAD; o de 2023 detalha o processo de reconexão com escolas de governo parceiras. Documentos de prestação de contas — informação pública, publicada pela própria Enap.</p>
                        <a href="https://repositorio.enap.gov.br/handle/1/8854" target="_blank" class="btn btn-success">Relatório 2024</a>
                        <a href="https://repositorio.enap.gov.br/handle/1/9959" target="_blank" class="btn btn-outline-success">Relatório 2023</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title">Objetivo do projeto</h5>
                        <p class="card-text">Possibilitar a pesquisa e resposta de perguntas sobre os Relatórios de Gestão da Enap de 2023 e 2024, escolhendo o documento na lista abaixo.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    """,
    unsafe_allow_html=True
)

# Carregar PDFs da pasta
pdf_files = [f for f in os.listdir(PDF_FOLDER) if f.endswith(".pdf")]

if not pdf_files:
    st.error("Nenhum PDF encontrado na pasta 'pdfs/'. Adicione arquivos e reinicie o app.")
else:
    col1, col2 = st.columns([2, 3])

    with col1:
        selected_pdf = st.selectbox("PDFs disponíveis:", pdf_files)

    if selected_pdf:
        pdf_path = os.path.join(PDF_FOLDER, selected_pdf)

        with col2:
            pergunta = st.text_input("Digite sua pergunta:", value=st.session_state.pergunta, key="input_pergunta")

        if st.button("🔎 Pesquisar", key="pesquisar"):
            if pergunta:
                with st.spinner("Aguarde... Buscando resposta..."):
                    texto_pdf = extrair_texto_pdf(pdf_path)
                    contexto = "\n".join([f"Pergunta: {h['pergunta']}\nResposta: {h['resposta']}" for h in st.session_state.historico])

                    prompt = f"Baseado no seguinte documento:\n\n{texto_pdf}\n\nHistórico da conversa:\n{contexto}\n\nPergunta: {pergunta}\nResposta:"

                    try:
                        completion = client.chat.completions.create(
                            model="gpt-4o-mini",
                            messages=[{"role": "user", "content": prompt}],
                            max_tokens=200
                        )
                        resposta = completion.choices[0].message.content

                        # Adicionar ao histórico
                        st.session_state.historico.append({"pergunta": pergunta, "resposta": resposta})

                        st.success("Resposta gerada com sucesso!")
                        st.markdown(f'<div class="historico-box"><strong>Pergunta:</strong> {pergunta}<br><strong>💡 Resposta:</strong> {resposta}</div>', unsafe_allow_html=True)

                        # Limpar o campo de pergunta
                        st.session_state.pergunta = ""
                        st.rerun()

                    except Exception as e:
                        st.error(f"Erro ao consultar IA: {e}")
            else:
                st.warning("Digite uma pergunta antes de pesquisar.")

        # Exibir histórico de perguntas e respostas
        if st.session_state.historico:
            st.subheader("Histórico de Perguntas")
            for h in reversed(st.session_state.historico):
                st.markdown(f'<div class="historico-box"><strong> {h["pergunta"]}</strong><br> {h["resposta"]}</div>', unsafe_allow_html=True)
