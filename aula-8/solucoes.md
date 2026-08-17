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

### Fontes (já indicadas na própria aula, com link)

Três páginas do manual oficial do PHP, em português — a mesma tecnologia usada em todo o SISPROT desde a Aula 0:

- [php.net/manual/pt_BR/book.pdo.php](https://www.php.net/manual/pt_BR/book.pdo.php) — visão geral do PDO
- [php.net/manual/pt_BR/pdo.error-handling.php](https://www.php.net/manual/pt_BR/pdo.error-handling.php) — tratamento de erros
- [php.net/manual/pt_BR/class.pdoexception.php](https://www.php.net/manual/pt_BR/class.pdoexception.php) — a classe `PDOException`

### Perguntas de referência (as mesmas sugeridas na aula)

1. "Quais são os três modos de tratamento de erro do PDO, e qual é o padrão a partir do PHP 8.0?" — resposta esperada: `PDO::ERRMODE_SILENT`, `PDO::ERRMODE_WARNING` e `PDO::ERRMODE_EXCEPTION`; o padrão era `ERRMODE_SILENT` antes do PHP 8.0, e passou a ser `ERRMODE_EXCEPTION` a partir do PHP 8.0.
2. **A mais reveladora do trio:** "Que classe de exceção o PDO lança quando o modo é `PDO::ERRMODE_EXCEPTION` — e existe algum caso em que essa mesma exceção é lançada mesmo sem esse modo estar ativo?" — resposta esperada: `PDOException`; o construtor do `PDO` sempre lança `PDOException` numa falha de conexão, **independente** do `PDO::ATTR_ERRMODE` configurado. A resposta completa só existe cruzando a página de tratamento de erros com a da própria classe — se a ferramenta responder só com a primeira metade (a classe), sem mencionar o caso do construtor, é sinal de que ela não buscou nas duas fontes.
3. **Pergunta fora do escopo, se colar só a página de tratamento de erros:** "Como faço para preparar e executar uma consulta parametrizada com PDO?" — essa resposta está na página de visão geral (`book.pdo.php`), não na de tratamento de erros; sem essa página indexada, a ferramenta deve admitir que não encontrou.

**O que discutir com a turma:** o ganho de tempo fica mais claro quando a pergunta exige cruzar mais de uma página — a pergunta 2 é o exemplo mais nítido disso neste exercício. Se alguém indexou só uma das três páginas, vale comparar a experiência com quem indexou as três.
