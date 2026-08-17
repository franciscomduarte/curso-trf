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

---

## Desafio final — Perguntas com fontes que se cruzam

### Fontes (já prontas na própria aula, para colar direto)

Duas fontes fictícias, com um conflito de propósito sobre o mesmo prazo:

- **Fonte A — Regimento Interno**, Art. 42: prazo de recurso de **10 dias úteis**.
- **Fonte B — Nota Técnica nº 08/2026**: atualiza o mesmo prazo para **15 dias úteis**, a partir da publicação da nota.

É um conflito realista de propósito — um artigo antigo do Regimento e uma nota técnica mais recente atualizando só aquele ponto, sem reescrever o documento base. Reflete um cenário comum em órgãos de verdade (a mesma ideia de "índice desatualizado" da Etapa 5, agora do lado do documento-fonte, não do índice).

### Perguntas de referência

1. "Qual é o prazo de recurso contra indeferimento de protocolo administrativo?" — pergunta feita **sem mencionar** que há duas fontes. Resultado esperado: a ferramenta tende a responder com uma das duas versões (frequentemente a mais recente, mas não é garantido) — vale observar qual ela escolhe e se sinaliza a existência de outra fonte, mesmo sem ser perguntada sobre isso.
2. **A pergunta-chave do desafio:** "As duas fontes concordam sobre esse prazo? Se não, qual deveria prevalecer, e por quê?" — resposta esperada: a ferramenta identifica os 10 dias (Regimento) e os 15 dias (Nota Técnica) como divergentes, e — idealmente — nota que a Nota Técnica é mais recente e complementa o Regimento, então deveria prevalecer. Uma resposta "boa, mas incompleta" identifica o conflito sem indicar qual prevalece; uma resposta "ruim" responde só com uma das fontes, como se a outra não existisse.

### O que discutir com a turma

- A diferença entre as perguntas 1 e 2 é o ponto central: a mesma ferramenta, com as mesmas fontes indexadas, pode "esconder" um conflito quando não é perguntada diretamente sobre ele — retrieval encontrar as duas fontes não garante que a resposta as cruze sem ser cobrada para isso.
- Vale comparar quem, na pergunta 1, recebeu 10 dias, 15 dias, ou uma resposta que já mencionava as duas — não existe um único resultado "correto" aqui, o interessante é a variação entre alunos.
- Gancho para a Etapa 5: um sistema de RAG que devolve uma resposta baseada só na fonte desatualizada (o Regimento, sem citar a Nota Técnica) está sofrendo exatamente o risco de "índice desatualizado" — só que aqui o problema está nos documentos-fonte, não em quando o índice foi atualizado pela última vez.
