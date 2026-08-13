# RAG com PDFs — material para a Aula 8

Duas implementações reais, lado a lado, respondendo à mesma pergunta sobre os Relatórios de Gestão da Enap (2023 e 2024) de dois jeitos diferentes:

| | `rag_enap_colab.ipynb` | `rag_enap_colab_embeddings.ipynb` |
|---|---|---|
| **Abordagem** | Extrai o texto inteiro do PDF e cola no prompt, junto com o histórico da conversa. | Faz chunking, gera embeddings (`sentence-transformers`, local e gratuito), busca por similaridade de cosseno e manda só os `TOP_K` trechos mais relevantes ao prompt. |
| **Chunking / embeddings / retrieval** | Não tem — é a abordagem mais simples possível de "buscar antes de responder". | Tem os três — é o fluxo completo ensinado nas Etapas 1 e 2 da aula. |
| **Origem** | Adaptado de um app Streamlit real ("Trabalho de RAG com IA"), construído por um servidor público neste curso. | Implementação de referência desta aula, sobre o mesmo par de documentos. |
| **Custo por pergunta** | Maior — reenvia sempre os ~69 mil tokens dos dois relatórios. | Menor — top-5 chunks somam ~1.000 tokens (medido; ambos os números variam com o corpus). |
| **App Streamlit equivalente** | `streamlit-app/app.py` — publicado em [franciscomolina.streamlit.app](https://franciscomolina.streamlit.app/). | `streamlit-app/app_retrieval.py` — não publicado, roda local com `streamlit run app_retrieval.py`. |

Nenhuma das duas é "a errada": a primeira é mais simples de programar e funciona bem quando o documento cabe na janela de contexto do modelo; a segunda é o padrão que de fato se chama RAG com retrieval, e o que escala para acervos muito maiores que dois relatórios.

## Como abrir um notebook no Google Colab

1. Baixe os dois PDFs primeiro — pelos botões "Baixar Relatório de Gestão 2023/2024" na própria aula (Aula 8, bloco "RAG por dentro"), ou pelos arquivos já salvos em `documentos/` nesta pasta. Os dois notebooks usam os mesmos PDFs.
2. Acesse [colab.research.google.com](https://colab.research.google.com/).
3. Arquivo → Fazer upload de notebook → selecione `rag_enap_colab.ipynb` (sem retrieval) ou `rag_enap_colab_embeddings.ipynb` (com retrieval).
4. Ambiente de execução → Executar tudo. A célula de upload pede os dois PDFs — selecione os dois de uma vez.

Em `rag_enap_colab.ipynb`, só a etapa de geração (chamar a API da OpenAI) tem custo. Em `rag_enap_colab_embeddings.ipynb`, chunking/embeddings/busca também são de graça (rodam localmente) — só a geração final, já com os trechos recuperados, paga.

## Por que upload, e não busca automática

O servidor do repositório da Enap bloqueia pedidos automáticos vindos de faixas de IP de datacenter do Google — um `requests.get()` direto do Colab recebe `HTTPError: 403 Forbidden`, mesmo o link funcionando normalmente em qualquer navegador (testado fora do Colab, funciona). Pedir upload evita esse problema por completo.

O Passo 1 identifica automaticamente qual PDF é qual pelo nome do arquivo (procura "2023" ou "2024" no nome) — por isso é importante manter os nomes originais dos arquivos baixados (`relatorio_gestao_enap_2023.pdf` / `relatorio_gestao_enap_2024.pdf`), sem renomear.

## Testado

**`rag_enap_colab.ipynb` (sem retrieval):** a extração de texto foi validada localmente: o relatório de 2023 rende ~99.600 caracteres (~25.000 tokens); o de 2024, ~174.300 caracteres (~43.600 tokens) — juntos, ~68.500 tokens, dentro da janela de contexto do `gpt-4o-mini` (128.000 tokens).

**`rag_enap_colab_embeddings.ipynb` (com retrieval):** testado de ponta a ponta contra os PDFs reais, exceto a chamada final à API da OpenAI (exige chave paga). Extração, chunking (800 caracteres, 100 de sobreposição), geração de embeddings e busca por similaridade rodaram com sucesso: 395 chunks nos dois relatórios (142 + 253), e a pergunta de teste ("Quantos participantes o Congresso do CLAD reuniu, e em qual ano isso aconteceu?") recuperou corretamente o chunk que menciona o Congresso do CLAD em primeiro lugar (score 0.612), com margem sobre os demais resultados.

Os dois PDFs em `documentos/` desta pasta (e em `streamlit-app/pdfs/`) são cópias locais dos mesmos arquivos que os botões de download da aula oferecem — mantenha-os à mão (no computador de quem for apresentar) antes da aula, para não depender da rede da sala no momento da demonstração.

## Sobre a história deste material

Uma versão anterior deste material só existia com chunking + embeddings + retrieval — a técnica "completa" ensinada nas Etapas 1 e 2 da aula. Ela foi substituída, por um tempo, pela versão mais simples (documento inteiro no prompt), para acompanhar o exemplo real de um app Streamlit construído por um servidor público neste curso. As duas abordagens agora convivem lado a lado (`rag_enap_colab.ipynb` e `rag_enap_colab_embeddings.ipynb`) — a diferença entre elas continua sendo um ponto de discussão em aula: a versão com embeddings escala melhor e custa menos por pergunta; a versão com documento inteiro é mais simples de programar e entender.
