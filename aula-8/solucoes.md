# Aula 8 · Soluções de referência (Mão na massa)

> Exercícios com o NotebookLM (gratuito, só conta Google) — mostrar só depois que o tempo de execução terminar.

---

## Exercício 1 — Perguntar a uma norma de verdade

### Fonte sugerida, se a turma travar na escolha

Um trecho da LGPD (Lei 13.709/2018) — por exemplo, os artigos 5º (definições) e 6º (princípios), já usados na Aula 7. É público, real, e curto o suficiente para caber num notebook do NotebookLM sem esforço.

### Perguntas de referência

1. "O que a lei considera dado pessoal sensível?" — resposta esperada: a lista do Art. 5º, II, citada com o trecho correspondente.
2. "Qual é o princípio da necessidade, segundo a lei?" — resposta esperada: o texto do Art. 6º, III, citado.
3. **Pergunta fora do escopo (a mais importante):** "Qual é a multa máxima prevista para descumprimento da LGPD?" — se a fonte colada não incluir os artigos sobre sanções (Art. 52 em diante), a resposta correta da ferramenta é dizer que essa informação não está na fonte fornecida, não inventar um valor.

### O que discutir com a turma

- Quem testou a pergunta 3 e viu a ferramenta admitir que não sabia (em vez de inventar) presenciou a diferença central entre RAG e um LLM comum sem fonte: a resposta fica limitada ao que foi indexado.
- Vale clicar em pelo menos uma citação e conferir se ela aponta mesmo para o trecho certo — é a prova visível de que a busca aconteceu de verdade, não é só o modelo "parecendo" ter fonte.

---

## Exercício 2 — RAG sobre uma documentação técnica

### Fonte sugerida

A página do PDO (PHP Data Objects) no manual oficial do PHP (<a href="https://www.php.net/manual/pt_BR/book.pdo.php">php.net/manual/pt_BR/book.pdo.php</a>) — já é a tecnologia usada em todo o SISPROT desde a Aula 0, então a pergunta pode ser bem concreta.

### Pergunta de referência

"Como faço para capturar uma exceção de conexão com PDO, e qual classe de exceção devo usar?" — uma pergunta que normalmente exigiria abrir duas ou três páginas diferentes do manual (conexão, tratamento de exceção, a classe `PDOException`) para responder por completo.

**O que discutir com a turma:** o ganho de tempo fica mais claro em documentações longas e bem organizadas — se alguém escolheu uma fonte curta demais, a diferença entre "buscar" e "ler tudo" quase não aparece. Vale perguntar quem escolheu fontes diferentes e comparar a experiência.
