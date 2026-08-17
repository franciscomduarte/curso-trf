# Aula 9 · Soluções de referência (Mão na massa)

> Exercícios de medição, otimização e configuração — mostrar só depois que o tempo de execução terminar.

---

## Exercício 1 — Medir antes de otimizar, num cenário novo

### Cenário sugerido, se a turma travar na escolha

Estender `relatorio.php` para também mostrar o status mais recente de cada requerente — implementado, de propósito, com uma consulta a mais dentro do mesmo loop que já existe (mais um N+1, empilhado sobre o primeiro).

### O que um bom ciclo de medição deveria mostrar

1. **Instrumentação primeiro**: um contador de consultas e um cronômetro (`hrtime(true)` ou `microtime(true)`) adicionados ao código, sem mudar a lógica ainda.
2. **Números reais anotados antes de otimizar** — mesmo que sejam poucos milissegundos com dado de teste pequeno, o hábito de anotar é o que importa, não o valor absoluto.
3. **Versão otimizada**: uma única consulta (`GROUP BY` combinado, ou uma segunda consulta agregada, mas nunca dentro do loop original).
4. **Confirmação de resultado idêntico** — comparar as duas saídas campo a campo, não só "rodou mais rápido".

**O que discutir com a turma:**
- O ganho relativo (quantas consultas viraram quantas) importa mais, nesse momento de aprendizado, que o tempo absoluto — o dado de teste da sala é pequeno demais para os milissegundos serem impressionantes por si só.
- Vale perguntar: "e se essa tabela tivesse 50 mil linhas, em vez das poucas dezenas daqui?" — a resposta (a diferença fica proporcionalmente maior) é o gancho para a Etapa 5, sobre medir no ambiente certo.

---

## Exercício 2 — Conectar e testar um servidor MCP

### O que esperar

1. Instalação bem-sucedida: `claude mcp add sisprot-arquivos -- npx -y @modelcontextprotocol/server-filesystem "./aula-9/codigo"` seguido de `claude mcp list` mostrando o servidor conectado.
2. Uma pergunta que dependa de olhar vários arquivos (ex.: "qual arquivo não usa `htmlspecialchars()` em nenhuma saída?") — resposta correta esperada: **`protocolo_form.php`, linha 62**, tem uma saída real sem escape: `<input type="hidden" name="id" value="<?= $id ?>">`. `$id` vem direto de `$_GET['id'] ?? $_POST['id']` (linha 4), sem passar por `htmlspecialchars()` nem ser convertido para inteiro — um XSS refletido de verdade (ex.: `protocolo_form.php?id=1"><script>...` quebraria o atributo). Achado real, não hipotético — confirmado lendo o código antes de preparar este material.
3. Depois de `claude mcp remove sisprot-arquivos`, a mesma pergunta ainda deve funcionar — o Claude Code já lê arquivos locais nativamente. A diferença a observar não é "funciona vs. não funciona", é *como* a ferramenta descreve o que está fazendo (cita explicitamente o servidor MCP, ou não).

**O que discutir com a turma:**
- Este exercício mostra o mecanismo, não uma vantagem decisiva — nomear isso é mais honesto do que fingir uma diferença dramática que não existe neste caso específico.
- Perguntar "que ferramentas você ganhou com esse servidor?" logo após conectar é uma boa forma de literalmente ver a descoberta automática de tools acontecendo (Etapa 3).
- Vale amarrar com a Aula 6: mesmo um projeto que já passou por uma auditoria de segurança pode ter um ponto esquecido — `$id` só é usado dentro de uma prepared statement (seguro contra SQL injection), mas ninguém tinha revisado o output HTML dele até agora. Boa deixa para, se sobrar tempo, pedir à IA para corrigir (`htmlspecialchars((int)$id)` ou só `(int)$id`, já que é sempre numérico).
