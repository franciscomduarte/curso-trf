# Aula 10 · Soluções de referência (Mão na massa)

> Exercícios de conexão MCP real — mostrar só depois que o tempo de execução terminar.

---

## Exercício 1 — Conectar o Notion MCP

### O que esperar

1. `claude mcp add --transport http notion https://mcp.notion.com/mcp` adiciona o servidor remoto (não instala nada localmente — é HTTP, com OAuth).
2. Dentro do Claude Code, `/mcp` abre o fluxo de autorização no navegador. Depois de aceitar (num workspace de teste, nunca um com dado real do órgão), `claude mcp list` mostra `notion` como conectado.
3. "Liste as páginas que você consegue ver neste workspace" só funciona depois da autorização — antes disso, a IA não tem nenhuma forma de saber o que existe no Notion de quem está usando.
4. Pedir a criação de uma página de teste e depois abrir o Notion manualmente para confirmar que ela existe de verdade é o passo que fecha o ciclo — sem essa conferência manual, o exercício vira "confiar porque a IA disse que funcionou", exatamente o hábito que o curso inteiro tentou evitar.

**O que discutir com a turma:**
- O comando é idêntico em forma ao que a Aula 9 já ensinou para servidores locais (`claude mcp add nome -- comando`) — a diferença aqui é `--transport http` e uma URL, porque o servidor roda do lado da Notion, não da máquina de quem conecta.
- Vale perguntar: "por que a Notion está migrando de um pacote local (`@notionhq/notion-mcp-server`) para um servidor remoto?" — bom gancho para reforçar a Etapa 2 (menos código para manter, mais dependência de um terceiro que você não controla).
- Em **Settings → Connections**, dentro do próprio Notion, dá pra ver (e revogar) quais clientes MCP têm acesso ao workspace — vale mostrar isso como o equivalente Notion do `claude mcp remove`.

---

## Exercício 2 — Conectar o GitHub MCP

### O que esperar

1. `claude mcp add github` conecta ao servidor remoto oficial (`https://api.githubcopilot.com/mcp/`), com o mesmo padrão de OAuth do Exercício 1.
2. "Quais são os últimos 5 commits deste repositório?", num repositório de teste, só responde de forma correta com o servidor conectado e autorizado.
3. A comparação pedida no enunciado (mesmo padrão de comando, serviço totalmente diferente) é o ponto central do exercício — depois de fazer os dois, a mecânica de "conectar uma ferramenta nova" já não deveria parecer nada especial, é sempre a mesma forma.

**O que discutir com a turma:**
- Ler a tela de permissão OAuth antes de aceitar é o hábito que evita conectar um repositório de trabalho com dado sensível sem perceber o alcance do que está sendo autorizado.
- `claude mcp list` com os dois servidores (Notion e GitHub) ativos ao mesmo tempo é uma boa forma de mostrar, de forma concreta, que um mesmo agente pode ter várias conexões MCP simultâneas — cada uma com seu próprio conjunto de tools.

---

## Desafio final — Terceiro servidor, à escolha

### O que esperar

Não há um servidor único "certo" aqui — o exercício testa o hábito, não o resultado de um servidor específico. Alguns caminhos plausíveis, se a turma travar na escolha:

- **O Postgres da Etapa 4** (`crystaldba/postgres-mcp`), contra um banco de teste próprio — reforça o achado de segurança já discutido (servidor antigo arquivado e vulnerável) na prática de escolher o pacote certo antes de conectar.
- **Um servidor de sistema de arquivos local** (`@modelcontextprotocol/server-filesystem`, já usado na Aula 9) — caminho mais simples, sem precisar de conta nova, bom para quem já está sem tempo.
- **Google Drive ou Slack**, se alguém da turma já tiver acesso de teste a algum desses.

O que importa, em qualquer escolha:

1. Verificar o status de manutenção do pacote **antes** de instalar — mesmo cuidado da Etapa 4, aplicado de novo, agora sem ninguém apontando o achado de antemão.
2. Depois de conectado, pedir à IA para listar as tools que aquele servidor específico expôs — a resposta muda de servidor para servidor, e é isso que prova que a conexão funcionou de verdade, não só que o comando rodou sem erro.
3. Uma pergunta real que só fazia sentido perguntar depois da conexão — não uma pergunta genérica que a IA já responderia sem nenhum servidor conectado.

**O que discutir com a turma:**
- Esse exercício não tem gabarito fechado de propósito — é o primeiro, no curso inteiro, em que a turma decide sozinha qual ferramenta conectar. Vale nomear isso: as seis aulas anteriores construíram o critério (o que perguntar antes de confiar); este exercício é a primeira vez que ninguém aponta o caminho.
- Se sobrar tempo, perguntar: "esse servidor que você escolheu — você confiaria nele com um dado real do seu órgão amanhã? O que faltaria verificar antes disso?" — fecha com a mesma pergunta de risco/confiança que atravessou o curso inteiro, uma última vez.
