# Aula 9 · Soluções de referência (Mão na massa)

> Exercícios de medição, otimização e conexão via MCP — mostrar só depois que o tempo de execução terminar.

---

## Exercício 1 — Medir antes de otimizar, num cenário novo

### Cenário sugerido, se a turma travar na escolha

Estender `relatorio.php` para também mostrar quantos empréstimos de cada equipamento estão em atraso (data prevista de devolução já passou, sem `data_devolucao` registrada) — implementado, de propósito, com uma consulta a mais dentro do mesmo loop que já existe (mais um N+1, empilhado sobre o primeiro).

### O que um bom ciclo de medição deveria mostrar

1. **Instrumentação primeiro**: um contador de consultas e um cronômetro (`hrtime(true)` ou `microtime(true)`) adicionados ao código, sem mudar a lógica ainda.
2. **Números reais anotados antes de otimizar** — mesmo que sejam poucos milissegundos com dado de teste pequeno, o hábito de anotar é o que importa, não o valor absoluto.
3. **Versão otimizada**: uma única consulta (`GROUP BY`/`LEFT JOIN` combinado, ou uma segunda consulta agregada, mas nunca dentro do loop original).
4. **Confirmação de resultado idêntico** — comparar as duas saídas campo a campo, não só "rodou mais rápido".

**O que discutir com a turma:**
- O ganho relativo (quantas consultas viraram quantas) importa mais, nesse momento de aprendizado, que o tempo absoluto — o dado de teste da sala é pequeno demais para os milissegundos serem impressionantes por si só.
- Vale perguntar: "e se essa tabela tivesse 50 mil linhas, em vez das poucas dezenas daqui?" — a resposta (a diferença fica proporcionalmente maior) é o gancho para a Etapa 5, sobre medir no ambiente certo.

---

## Exercício 2 — Conectar e testar um servidor MCP

### O que esperar

1. Instalação bem-sucedida: `claude mcp add emprestati-arquivos -- npx -y @modelcontextprotocol/server-filesystem "./aula-9/codigo"` seguido de `claude mcp list` mostrando o servidor conectado.
2. Uma pergunta que dependa de olhar vários arquivos (ex.: "qual arquivo não usa `htmlspecialchars()` em nenhuma saída?") — resposta correta esperada: **`emprestimo_form.php`, linha 65**, tem uma saída real sem escape: `<input type="hidden" name="id" value="<?= $id ?>">`. `$id` vem direto de `$_GET['id'] ?? $_POST['id']` (linha 4), sem passar por `htmlspecialchars()` nem ser convertido para inteiro — um XSS refletido de verdade (ex.: `emprestimo_form.php?id=1"><script>...` quebraria o atributo). Achado real, não hipotético — confirmado lendo o código antes de preparar este material.
3. Depois de `claude mcp remove emprestati-arquivos`, a mesma pergunta ainda deve funcionar — o Claude Code já lê arquivos locais nativamente. A diferença a observar não é "funciona vs. não funciona", é *como* a ferramenta descreve o que está fazendo (cita explicitamente o servidor MCP, ou não).

**O que discutir com a turma:**
- Este exercício mostra o mecanismo, não uma vantagem decisiva — nomear isso é mais honesto do que fingir uma diferença dramática que não existe neste caso específico.
- Perguntar "que ferramentas você ganhou com esse servidor?" logo após conectar é uma boa forma de literalmente ver a descoberta automática de tools acontecendo (Etapa 3).
- Vale amarrar com a Aula 6: mesmo um projeto novo pode ter um ponto esquecido — `$id` só é usado dentro de uma prepared statement (seguro contra SQL injection), mas ninguém tinha revisado o output HTML dele até agora. Boa deixa para, se sobrar tempo, pedir à IA para corrigir (`htmlspecialchars((int)$id)` ou só `(int)$id`, já que é sempre numérico).

---

## Exercício 3 — Notion (MCP #1)

### O que esperar

A especificação (impedir empréstimo duplicado do mesmo equipamento) implementada em `emprestimo_form.php`: antes de inserir um novo empréstimo, uma consulta checando se já existe uma linha com o mesmo `equipamento_id` e `data_devolucao IS NULL`; se existir, recusar com mensagem citando o `servidor` que está com o equipamento.

**O que discutir com a turma:**
- Repare que a especificação pede uma consulta *antes* do insert — é uma checagem de regra de negócio, não uma validação de formato como as que já existiam. Vale perguntar se alguém sugeriu fazer isso só no lado do banco (uma constraint) em vez do PHP — as duas abordagens são defensáveis, o importante é a decisão ser consciente.
- Quem esqueceu de marcar a página certa na tela de autorização do Notion geralmente recebe uma resposta da IA dizendo que não encontrou nenhuma página — bom sinal de erro, não falha silenciosa.

---

## Exercício 4 — GitHub Issues (MCP #2)

### O que esperar

A correção em `emprestimo_form.php`: adicionar, junto às validações já existentes (`if (!DateTime::createFromFormat(...))`), uma comparação entre as duas datas já convertidas — algo como `if ($data_prevista_devolucao <= $data_retirada) { $erros[] = 'A devolução prevista precisa ser depois da data de retirada.'; }` (comparação de strings no formato `Y-m-d` já funciona lexicograficamente, mas vale conferir se a IA usou `DateTime` para comparar, mais robusto).

**O que discutir com a turma:**
- Esse bug é real (confirmado ao preparar este material) — o formulário valida presença e formato das datas, mas nunca a relação entre elas. É o tipo de lacuna que passa despercebida numa revisão rápida.
- Comparar com o Exercício 3: a "fonte" muda de formato (texto livre no Notion vs. issue estruturada no GitHub), mas o prompt final pedido à IA é quase idêntico — "busque X, implemente o que descreve". Vale nomear isso: o formato da fonte muda, o padrão de uso do MCP não.

---

## Exercício 5 — Google Sheets (MCP #3)

### O que esperar

A IA gera 3 comandos `INSERT INTO equipamentos (nome, patrimonio, tipo) VALUES (...)`, um por linha da planilha, sem executar nada (o prompt pede explicitamente só para gerar, não rodar).

**O que discutir com a turma:**
- Este é o exercício com mais atrito de configuração dos três (projeto Google Cloud, service account, compartilhar a planilha) — vale nomear isso abertamente: nem toda ferramenta com MCP é tão simples quanto colar um token. Faz parte da decisão real de adotar um servidor MCP, não só da configuração técnica.
- Se ninguém conseguir terminar a configuração a tempo, vale mostrar a planilha e o prompt, e discutir o resultado esperado sem executar — o valor pedagógico está em entender o padrão, não necessariamente em rodar até o fim.
