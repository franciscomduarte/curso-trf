# Aula 8 · Demonstração final — material do instrutor (RAG sobre o SISPROT)

> Mostrar somente na demonstração final, depois do tempo de execução do desafio. Material de apoio para você conduzir ao vivo — não distribuir à turma antes disso.

## Antes da aula

1. `aula-8/codigo/` já é uma cópia do estado do SISPROT ao final da Aula 7.
2. Escolha o caminho: um projeto no Claude (claude.ai) com os arquivos de `aula-8/codigo/` anexados como *project knowledge*, ou um terminal com `claude` rodando dentro da pasta. Os dois demonstram RAG sobre o projeto — o project knowledge é mais visual (mostra o que foi buscado), o terminal é mais rápido de preparar.
3. Se for usar o Claude com project knowledge, anexe os arquivos com antecedência — o índice pode levar um instante para ficar pronto.

## O que observar na pergunta ao vivo

> A pergunta já está na própria aula (bloco "Demonstração final · Perguntando ao próprio código, ao vivo"). Aqui só o que esperar da resposta.

O caminho correto que a resposta deveria cobrir:

1. `protocolo_form.php` — o campo `numero`, se vazio, cai no primeiro `if` do bloco de validação (`if ($numero === '') { $erros[] = 'Número do protocolo é obrigatório.'; }`) e entra na lista `$erros`. A validação é inline no próprio arquivo — este projeto ainda não tem um `validacoes.php` separado (essa extração foi só demonstrada, ao vivo, nas Aulas 3 e 6, sem nunca ter sido aplicada de fato ao código salvo em disco que segue de aula em aula).
2. Como `if (empty($erros))` é falso, o bloco que chama `$pdo->prepare(...)` (em `conexao.php`) nunca executa — o banco de dados não chega a ser tocado. Vale a resposta deixar isso explícito, não só "dá erro".
3. O usuário vê a mensagem de erro renderizada na própria tela do formulário (o trecho `<?php foreach ($erros as $erro): ?>` em `protocolo_form.php`), com `htmlspecialchars()` aplicado.

Se a resposta da IA cobrir os dois arquivos citando de onde tirou cada parte, o RAG funcionou como esperado. Se ela responder de forma genérica sem citar arquivo nenhum, é um bom gancho para perguntar diretamente "de qual arquivo você tirou isso?" — e mostrar que uma resposta melhor é uma resposta rastreável.

## Pontos para comentar com a turma

- A pergunta feita junta dois arquivos de propósito — é o tipo de pergunta que mostra a diferença entre "colar tudo no prompt" (o que fizemos em aulas anteriores) e deixar a ferramenta buscar sozinha.
- Vale comparar com o Exercício 1 do Mão na massa: lá, a fonte era um texto jurídico; aqui, é código. O mecanismo por trás — chunking, embedding, busca por similaridade — é o mesmo dos dois lados.
- Se sobrar tempo, vale repetir a pergunta removendo `conexao.php` do project knowledge e observar como a resposta piora ou fica incompleta — prova ao vivo de que a busca realmente depende do que foi indexado.

## Sobre o passo a passo de créditos da OpenAI (mesmo bloco)

O bloco da demonstração final também traz, agora, o passo a passo de comprar créditos da OpenAI (conta → API key → "Add payment method" → "Add credit", mínimo US$ 5) — a mesma API usada no notebook Python do bloco "RAG por dentro", mostrado antes na aula. Não precisa mostrar essa tela ao vivo — é só um ponto de apoio caso alguém pergunte como conseguir uma chave para testar o notebook por conta própria depois da aula.

## Sobre o bloco "RAG por dentro: implementação real em Python" (Mão na massa)

Esse bloco fica no final do Mão na massa, depois do desafio "Perguntas com fontes que se cruzam" (que continua sendo NotebookLM) — não depende de rede elétrica extra nem de nada instalado na máquina de ninguém, roda inteiro no Google Colab (`aula-8/codigo/rag-exemplo/rag_enap_colab.ipynb`).

1. **Baixe os dois PDFs antes da aula** pelos botões "Baixar Relatório de Gestão 2023/2024" no próprio bloco (ou de `aula-8/codigo/rag-exemplo/documentos/`) — o Passo 1 do notebook pede upload, não busca sozinho. Isso é proposital: o servidor do repositório da Enap bloqueia pedidos automáticos vindos de faixas de IP de datacenter do Google (`HTTPError: 403 Forbidden` — confirmado, o mesmo link funciona normalmente num navegador comum), então pedir upload evita esse bloqueio por completo em vez de tentar contornar caso a caso.
2. **Este notebook não usa chunking/embeddings/retrieval** — foi reescrito para uma abordagem mais simples (documento inteiro no prompt), adaptada do app Streamlit real de um servidor público que fez este curso (`aula-8/codigo/rag-exemplo/streamlit-app/app.py`). Vale nomear essa origem para a turma — é um bom gancho para mostrar que RAG "de verdade" nem sempre significa vetor e embeddings; às vezes é só "documento inteiro no prompt", com o trade-off de custo por pergunta explicado no próprio bloco.
3. O Passo 1 identifica automaticamente qual PDF é 2023 e qual é 2024 pelo nome do arquivo — se renomear os arquivos baixados, mantenha "2023"/"2024" em algum lugar do nome, ou o notebook avisa e usa o nome do arquivo como rótulo da fonte.
4. Só a etapa de geração (chamar a API da OpenAI) tem custo — upload e extração de texto são de graça. Toda pergunta, porém, já exige a chamada paga (diferente da versão anterior com embeddings, onde só a geração final era paga) — vale decidir com antecedência quantas perguntas fazer ao vivo. O notebook explica, no Passo 1 (markdown), por que não é Copilot: o Copilot não tem uma API simples pra isso (o GitHub Models, que permitia algo parecido, foi descontinuado em 30/07/2026, e mesmo antes já era um produto separado do Copilot).
5. Os dois PDFs são reais e públicos (Relatórios de Gestão da Enap, 2023 e 2024) — não são fictícios como o resto do curso, porque relatório de gestão é documento de prestação de contas, informação pública por definição. Vale nomear essa distinção para a turma se alguém perguntar "por que agora é dado real?".
6. Se for demonstrar ao vivo, teste a chave de API com antecedência — sem uma chave OpenAI configurada, a célula do Passo 4 (perguntar) falha. Tenha uma pergunta pronta (ex.: sobre o Congresso do CLAD, relatório 2024) e uma pergunta cruzando os dois relatórios, para mostrar que o histórico e o contexto combinado funcionam.
7. **Bônus, se sobrar tempo:** o mesmo código existe como app Streamlit publicado de verdade, em [franciscomolina.streamlit.app](https://franciscomolina.streamlit.app/) — passo a passo completo de publicação (`.env` → git → Streamlit Community Cloud, com capturas de tela reais) em `aula-8/codigo/rag-exemplo/streamlit-app/PUBLICAR.md` e no próprio bloco da aula. Vale mostrar o app publicado ao vivo como fechamento — "isso que vocês viram em Python também vira um serviço de verdade, sem precisar hospedar servidor".
