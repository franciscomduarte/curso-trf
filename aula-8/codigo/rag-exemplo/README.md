# RAG com PDFs — material para a Aula 8

Dois exemplos, mesma ideia: responder perguntas sobre os Relatórios de Gestão da Enap (2023 e 2024), extraindo o texto inteiro do PDF e colando no prompt (junto com histórico da conversa), sem chunking nem embeddings — a abordagem mais simples de RAG, adaptada de um app Streamlit real construído por um servidor público neste curso.

- `rag_enap_colab.ipynb` — versão para rodar no Google Colab, sem instalar nada.
- `streamlit-app/` — versão como app web completo (Streamlit), com passo a passo de publicação em `streamlit-app/PUBLICAR.md`. Exemplo publicado: [franciscomolina.streamlit.app](https://franciscomolina.streamlit.app/).

## Como abrir o notebook no Google Colab

1. Baixe os dois PDFs primeiro — pelos botões "Baixar Relatório de Gestão 2023/2024" na própria aula (Aula 8, bloco "RAG por dentro"), ou pelos arquivos já salvos em `documentos/` nesta pasta.
2. Acesse [colab.research.google.com](https://colab.research.google.com/).
3. Arquivo → Fazer upload de notebook → selecione `rag_enap_colab.ipynb`.
4. Ambiente de execução → Executar tudo. A célula do Passo 1 abre uma caixa de upload — selecione os dois PDFs baixados de uma vez.

Só a etapa de geração (chamar a API da OpenAI) tem custo — o resto (upload, extração de texto) é de graça.

## Por que upload, e não busca automática

O servidor do repositório da Enap bloqueia pedidos automáticos vindos de faixas de IP de datacenter do Google — um `requests.get()` direto do Colab recebe `HTTPError: 403 Forbidden`, mesmo o link funcionando normalmente em qualquer navegador (testado fora do Colab, funciona). Pedir upload evita esse problema por completo.

O Passo 1 identifica automaticamente qual PDF é qual pelo nome do arquivo (procura "2023" ou "2024" no nome) — por isso é importante manter os nomes originais dos arquivos baixados (`relatorio_gestao_enap_2023.pdf` / `relatorio_gestao_enap_2024.pdf`), sem renomear.

## Testado

A extração de texto foi validada localmente antes de publicar: o relatório de 2023 rende ~99.600 caracteres (~25.000 tokens); o de 2024, ~174.300 caracteres (~43.600 tokens) — juntos, ~68.500 tokens, dentro da janela de contexto do `gpt-4o-mini` (128.000 tokens).

Os dois PDFs em `documentos/` desta pasta (e em `streamlit-app/pdfs/`) são cópias locais dos mesmos arquivos que os botões de download da aula oferecem — mantenha-os à mão (no computador de quem for apresentar) antes da aula, para não depender da rede da sala no momento da demonstração.

## Sobre a versão anterior (com embeddings)

Uma versão anterior deste material usava chunking + embeddings locais (`sentence-transformers`) + retrieval por similaridade de cosseno — a técnica "completa" ensinada nas Etapas 1 e 2 da aula. Essa versão foi substituída pela mais simples (documento inteiro no prompt) para acompanhar o exemplo real que motivou esta seção, mas a diferença entre as duas abordagens continua sendo um ponto de discussão em aula: a versão com embeddings escala melhor e custa menos por pergunta; a versão com documento inteiro é mais simples de programar e entender.
