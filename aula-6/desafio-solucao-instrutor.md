# Aula 6 · Demonstração final — material do instrutor (Claude Code no SISPROT real)

> Mostrar somente na demonstração final, depois do tempo de execução do desafio. Material de apoio para você rodar ao vivo — não distribuir à turma antes disso.

## Organização do projeto (antes da Etapa 1)

> Os três comandos e as explicações já estão na aula, na seção "Organizando o projeto antes de começar" — aqui só ficam notas de preparo que não fazem sentido no material do aluno.

### Antes da aula

1. Instale as skills `ui-ux-designer` e `tdd-orchestrator` com antecedência — não vêm por padrão em nenhuma das duas ferramentas. Ambas vêm do catálogo comunitário [`agentic-awesome-skills`](https://github.com/sickn33/agentic-awesome-skills) (MIT, ~2.000 skills):
   ```bash
   # Claude Code
   npx agentic-awesome-skills --claude --skills ui-ux-designer,tdd-orchestrator

   # GitHub Copilot (requer GitHub CLI instalado e autenticado; gh skill é preview)
   gh skill install sickn33/agentic-awesome-skills skills/ui-ux-designer/SKILL.md --agent github-copilot --scope user --pin v14.2.0
   gh skill install sickn33/agentic-awesome-skills skills/tdd-orchestrator/SKILL.md --agent github-copilot --scope user --pin v14.2.0
   ```
   Teste antes da aula — se a instalação falhar silenciosamente, a IA não reconhece o pedido "use a skill X" e tenta responder sem ela.
2. Confira o resultado do comando de auditoria antes de usar as skills ao vivo: `npx agentic-awesome-skills audit --skills ui-ux-designer,tdd-orchestrator`. O catálogo classifica as duas como risco "crítico" — na prática, o conteúdo é só texto (nenhum script embutido), mas vale ler antes de confiar, e é um bom gancho para comentar isso com a turma na Etapa 5.
3. Crie uma pasta separada, só para esta demonstração, com uma **cópia** de `protocolos-mock.html` — não use a pasta de onde os alunos vão baixar o arquivo. Os Comandos 1-3 escrevem/alteram arquivos nessa pasta (`CLAUDE.md`/`.github/copilot-instructions.md`, `PLANO_DE_TESTES.md`, e o próprio `protocolos-mock.html` fica com CSS ajustado pelo Comando 2), e nada disso deve vazar para o arquivo distribuído à turma.
4. Terminal aberto dentro dessa pasta-cópia, `claude` já rodando (se for demonstrar com Claude Code) — ou a pasta aberta no VS Code com o Copilot conectado (se for demonstrar com Copilot). Não precisa repetir os três comandos nas duas ferramentas ao vivo; escolha uma como principal e mencione que a outra funciona igual.

### O que observar em cada comando

- **`/init`**: mesmo sendo um projeto de um único arquivo HTML, o arquivo gerado (`CLAUDE.md` no Claude Code, `.github/copilot-instructions.md` no Copilot) deve conseguir descrever a estrutura de um protocolo (campos, status possíveis) e as funções de transição (`iniciarAnalise`, `deferir`, `indeferir`). Se sair vago demais, é uma boa deixa para comentar: até um comando automático se beneficia de contexto — o mesmo princípio de prompt engineering da Aula 0.
- **skill `ui-ux-designer`**: espere ajustes de contraste, espaçamento das células e hierarquia dos botões de ação — não espere uma reformulação visual completa; é uma auditoria pontual, não um redesign. Confirme, depois, que a lógica JavaScript (as três funções de transição e `renderTabela()`) continua idêntica — só o `<style>` e o HTML da tabela devem ter mudado.
- **skill `tdd-orchestrator`**: espere um plano listando os testes que faltam para as funções de transição e para `renderTabela()` (ex.: cada transição de status, o caso em que a transição é inválida e não deve acontecer). Não espere que a skill escreva os testes agora — só o plano.

### Pontos para comentar com a turma

- `/init` e as skills resolvem problemas diferentes: `/init` documenta o que já existe; as skills fazem um trabalho específico (design, testes) sob pedido. Nenhum dos dois substitui a auditoria de qualidade/segurança que vem a seguir, nas Etapas 1-4.
- Vale nomear que `ui-ux-designer` e `tdd-orchestrator` são skills da comunidade, instaladas manualmente — não é algo que "vem de fábrica" em nenhuma das duas ferramentas, ao contrário do comando `/init`.
- O comando de auditoria (`npx agentic-awesome-skills audit`) é um gancho real para a Etapa 5: skills de terceiros são instruções que a IA passa a seguir, e vale conferir o que uma skill pode influenciar antes de instalar — mesmo raciocínio de não confiar cegamente em conteúdo de fora. Evite entrar em detalhe sobre a classificação de risco específica dessas duas skills na frente da turma — o ponto é o hábito de auditar, não gerar desconfiança da demonstração.
- Vale reforçar por que a demonstração roda numa cópia à parte: os problemas de qualidade/segurança que a turma vai auditar nas próximas etapas (duplicação de lógica, XSS) continuam intactos no arquivo que eles vão baixar — só a cópia do instrutor ganhou CSS ajustado.

---

## Antes da aula

1. Confirme que o XAMPP (Apache + MySQL) está rodando e que o banco `sisprot` existe.
2. `aula-6/codigo/` já é uma cópia do estado ao final da Aula 3 (CRUD + tramitação + consulta + testes documentados, mas `validacoes.php`/`consultar.php`/`tramitar.php` ainda não foram de fato escritos em disco — só documentados nas demonstrações anteriores).
3. Abra um terminal dentro da pasta e rode `claude`.

## Prompts, código "antes" e resultado esperado

> Isso tudo já está detalhado na própria aula (seção "Demonstração final · Auditoria completa, ao vivo", com o código real de `protocolo_form.php` e `conexao.php`, o resultado esperado de `validacoes.php` e a correção esperada da mensagem de erro). Aqui ficam só os pontos que não fazem sentido no material do aluno.

## Testando ao vivo

Os passos já estão na aula. Um detalhe a mais para você: ao simular a falha de conexão (trocando a senha em `conexao.php`), lembre de desfazer a alteração logo em seguida — é fácil esquecer e travar o resto da demonstração.

## Pontos para comentar com a turma

- O Prompt 1 é uma boa demonstração de como a documentação de uma demonstração passada (Aula 3) vira, literalmente, o prompt de hoje — spec-driven development não é só para features novas, também vale para dívida técnica represada.
- Um relatório de segurança "limpo" não é motivo para pular a auditoria — é a confirmação de que a disciplina das aulas anteriores (prepared statements, escaping) valeu a pena. Vale nomear isso explicitamente para a turma.
- O ponto de `conexao.php` é um bom gancho para a Etapa 4 da aula: "boas práticas" inclui não vazar detalhe interno em mensagem de erro, algo que nenhuma restrição anterior do curso havia pedido explicitamente. Se o Claude Code não apontar o problema sozinho, a aula já sugere a pergunta direcionada para provocar — vale ensaiar essa pergunta antes de ir ao vivo.
