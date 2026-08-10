# Aula 6 · Soluções de referência (Mão na massa)

> Mesmo formato das aulas anteriores: sem instalação, auditando o `protocolos-mock.html` com IA gratuita. Mostrar somente depois que o tempo de execução do exercício terminar.

---

## Exercício 1 — Diagnóstico de qualidade + correção de 1 item

### O que costuma aparecer no diagnóstico

- **Lógica de mudança de status repetida** em `iniciarAnalise`, `deferir` e `indeferir` (o mesmo padrão "empurra no histórico + troca status"). É o achado principal, alvo da correção abaixo.
- **Strings mágicas de status** ("Aberto", "Em Análise", "Jurídico"...) repetidas como texto literal em várias funções, sem uma constante central — um erro de digitação numa delas quebraria a comparação silenciosamente. Vale a IA sugerir algo como `const STATUS = { ABERTO: "Aberto", EM_ANALISE: "Em Análise", ... }`.
- Nomes de variável genéricos em algum trecho (`p`, `i`) sem problema real de leitura, mas às vezes apontado mesmo assim — vale discutir com a turma se isso é um problema de verdade ou só estilo.
- Função `renderTabela()` fazendo duas coisas: montar o HTML de cada linha e lidar com os botões de ação — um candidato razoável a separar em duas funções menores.

### Correção de referência (consolidar mudança de status)

```js
function mudarStatus(protocolos, index, novoStatus) {
  const p = protocolos[index];
  p.historico.push({ de: p.status, para: novoStatus, data: new Date().toISOString().slice(0, 10), setor: p.setorAtual });
  p.status = novoStatus;
  renderTabela();
}

function iniciarAnalise(index) {
  if (protocolos[index].status !== "Aberto") return;
  mudarStatus(protocolos, index, "Em Análise");
}

function deferir(index) {
  const p = protocolos[index];
  if (p.status !== "Em Análise" || p.setorAtual !== "Jurídico") return;
  mudarStatus(protocolos, index, "Deferido");
}

function indeferir(index) {
  const p = protocolos[index];
  if (p.status !== "Em Análise" || p.setorAtual !== "Jurídico") return;
  mudarStatus(protocolos, index, "Indeferido");
}
```

**O que discutir com a turma:** a validação (`if` de cada função) ficou de fora da função comum de propósito — cada transição tem uma regra diferente de quem pode fazer o quê, então só a parte realmente repetida (gravar histórico + trocar status) virou função única. Consolidar demais (incluindo a validação) tornaria a função genérica difícil de entender.

---

## Etapa 2 — Achar e corrigir o gargalo de performance

> Este não é um dos dois exercícios da Mão na massa (que seguem sendo qualidade e segurança) — é o exemplo de trabalho da Etapa 2, caso a turma peça para ver o resultado antes de tentar sozinha.

### Prompt de referência (achar o gargalo)

```
[CONTEXTO] renderTabela(), no protocolos-mock.html, é chamada toda vez que o
status de um protocolo muda.

[TAREFA] Avalie renderTabela() quanto a performance. Ela reconstrói a tabela
inteira a cada chamada, mesmo quando só um protocolo mudou? Se sim, explique o
impacto conforme a lista cresce.

[FORMATO] Explicação do problema encontrado, sem corrigir ainda.
```

### O achado esperado

`renderTabela()` começa com `tbody.innerHTML = ""` e reconstrói todas as linhas do zero a cada chamada — inclusive as que não mudaram. Com 5 protocolos isso é imperceptível; numa listagem real de milhares, seria um re-render completo a cada clique.

### Correção de referência (atualizar só a linha que mudou)

```js
function renderLinha(index) {
  const p = protocolos[index];
  const tr = document.getElementById(`tr-${index}`);

  const historicoResumo = p.historico.length
    ? p.historico.map(h => `${h.de} → ${h.para} (${h.data})`).join("<br>")
    : "—";

  let acoes = "";
  if (p.status === "Aberto") {
    acoes += `<button onclick="iniciarAnalise(${index})">Iniciar análise</button>`;
  }
  if (p.status === "Em Análise" && p.setorAtual === "Jurídico") {
    acoes += `<button onclick="deferir(${index})">Deferir</button>`;
    acoes += `<button onclick="indeferir(${index})">Indeferir</button>`;
  }

  tr.innerHTML = `
    <td>${p.numero}</td>
    <td>${p.assunto}</td>
    <td>${p.requerente}</td>
    <td>${p.dataAbertura}</td>
    <td>${p.status}</td>
    <td>${p.prioridade}</td>
    <td>${p.setorOrigem}</td>
    <td>${p.setorAtual}</td>
    <td>${historicoResumo}</td>
    <td>${acoes}</td>
  `;
}

function renderTabela() {
  const tbody = document.querySelector("#tabela-protocolos tbody");
  tbody.innerHTML = "";
  protocolos.forEach((p, index) => {
    const tr = document.createElement("tr");
    tr.id = `tr-${index}`;
    tbody.appendChild(tr);
  });
  protocolos.forEach((p, index) => renderLinha(index));
}
```

Cada função de transição (`iniciarAnalise`, `deferir`, `indeferir` — ou `mudarStatus`, se o Exercício 1 já foi aplicado) passa a chamar `renderLinha(index)` no lugar de `renderTabela()`.

**O que discutir com a turma:** essa correção só vale a pena porque o comportamento observável continua idêntico — é refatoração de performance, não uma feature nova. Se a IA propuser uma solução que muda o que aparece na tela, ela não resolveu o problema pedido.

### Sobre a skill `auditoria-refatoracao` (apresentada logo depois, na Etapa 2)

Se algum aluno testar a criação da skill ao vivo: basta criar a pasta `.claude/skills/auditoria-refatoracao/` com o `SKILL.md` do slide (frontmatter `description` + instruções numeradas) e reiniciar/continuar a sessão do Claude Code na pasta do projeto. Vale mostrar as duas formas de disparo — pedir algo como "audite este arquivo" (a IA reconhece pela `description`) ou digitar `/auditoria-refatoracao` direto. Se alguém perguntar a diferença entre isso e simplesmente colar o prompt de novo: a skill fica salva no projeto (ou na pasta pessoal) e é sugerida automaticamente em sessões futuras, sem precisar guardar o prompt em outro lugar.

---

## Exercício 2 — Auditoria e correção da XSS

### Prompt de referência

```
[PAPEL] Você é um desenvolvedor front-end especializado em segurança de
aplicações web.

[CONTEXTO] protocolos-mock.html monta a tabela com tr.innerHTML =
`<td>${p.assunto}</td>...`, interpolando dados do array diretamente.

[TAREFA] Avalie esse trecho contra os riscos do OWASP Top 10, com foco em XSS.
Se houver risco, corrija usando uma abordagem que não interprete o conteúdo
como HTML (ex.: textContent, ou uma função de escape), preservando a aparência
atual da tabela.

[FORMATO] Primeiro a explicação do risco encontrado; depois o trecho de código
corrigido.
```

### Correção de referência — usando uma função de escape

```js
function escaparHtml(texto) {
  const div = document.createElement("div");
  div.textContent = texto;
  return div.innerHTML;
}

function renderTabela() {
  const tbody = document.querySelector("#tabela-protocolos tbody");
  tbody.innerHTML = "";
  protocolos.forEach((p, index) => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${escaparHtml(p.numero)}</td>
      <td>${escaparHtml(p.assunto)}</td>
      <td>${escaparHtml(p.requerente)}</td>
      <td>${p.dataAbertura}</td>
      <td>${p.status}</td>
    `;
    tbody.appendChild(tr);
  });
}
```

### Teste de verificação

1. Adicionar um protocolo fictício com `assunto: "<b>teste</b>"`.
2. Antes da correção: o texto aparece **em negrito** na tabela (a tag foi interpretada).
3. Depois da correção: aparece literalmente `<b>teste</b>` como texto, sem formatação — prova de que a correção funcionou.

**O que discutir com a turma:** só os campos que vêm de digitação livre (`numero`, `assunto`, `requerente`) precisam de escape — `dataAbertura` e `status` são controlados pelo próprio sistema (data vem de um seletor, status vem das funções de transição), então o risco ali é bem menor. Vale discutir se "escapar tudo, sempre" é mais simples de manter do que decidir campo a campo — as duas posições têm argumento.

---

## Exercício 3 — Criar a própria skill no GitHub Copilot

> Diferente dos dois primeiros, este exercício não usa o `protocolos-mock.html` — cada aluno escreve uma skill para uma tarefa da própria rotina, então não há uma "resposta certa" única.

### Pré-requisitos a confirmar antes de começar

- VS Code instalado.
- Extensão **GitHub Copilot** instalada e conectada a uma conta do GitHub (o plano gratuito já inclui chat e modo agente).
- Se algum aluno já tiver a skill `auditoria-refatoracao` da Etapa 2 (feita no Claude Code): vale pedir para ele testá-la direto no Copilot antes de criar uma nova, como prova de que o formato é portável.

### Exemplo de SKILL.md que pode ser mostrado se a turma travar na etapa de escrever a própria

```yaml
---
description: Revisa um despacho administrativo antes de assinar, verificando
  se cita a fundamentação legal, se o pedido foi de fato respondido e se não
  sobrou linguagem informal. Usar quando pedirmos para revisar ou conferir um
  despacho antes de finalizar.
---

## Instruções

1. Verifique se o despacho cita a base legal (lei, decreto ou norma interna)
   que fundamenta a decisão.
2. Confirme que o despacho responde exatamente ao que foi pedido no processo
   — não a um pedido parecido ou mais genérico.
3. Aponte trechos com linguagem informal ou ambígua, sugerindo uma redação
   mais formal.
4. Liste os pontos encontrados; não reescreva o despacho inteiro sem que seja
   pedido.
```

### Onde a IA costuma pedir ajuda

- Frontmatter mal formatado (faltar o `---` de abertura ou fechamento, ou indentação errada na `description` de várias linhas) — o Copilot ignora a skill nesse caso, silenciosamente.
- `description` que descreve o "o quê" mas não o "quando" — sem um gatilho claro, a skill nunca é chamada sozinha.

### Teste de verificação

1. Salvar o arquivo em `.github/skills/<nome>/SKILL.md`.
2. No Copilot Chat (modo agente), pedir algo que combine com a `description` escrita.
3. Confirmar, na resposta, que a skill foi de fato usada (o Copilot costuma indicar quando aplica uma skill).

**O que discutir com a turma:** o valor do exercício não é o Copilot em si — é perceber que a mesma lógica de "empacotar um procedimento repetido" da Etapa 2 se aplica a qualquer tarefa do dia a dia, dentro ou fora do código, e que o formato (`SKILL.md`) não fica preso a uma ferramenta específica.
