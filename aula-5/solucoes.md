# Aula 1 · Soluções de referência (Mão na massa)

> Formato igual ao da Aula 0: um único arquivo `protocolos-mock.html` (HTML + CSS + JavaScript puro, sem PHP/MySQL), evoluído a partir do que a turma já tem. Mostrar somente depois que o tempo de execução do exercício terminar.

---

## Ponto de partida

### Prompt usado

```
[PAPEL] Você é um desenvolvedor front-end especializado em HTML, CSS e JavaScript puro.

[CONTEXTO] Tenho a página protocolos-mock.html da aula anterior, com protocolos num
array de objetos JavaScript, renderizados numa tabela.

[TAREFA] Adicione dois campos a cada protocolo: "setorAtual" (texto, valor inicial
"Recepção") e "historico" (array de objetos { de, para, data, setor }, começando
vazio). Não precisa exibir nada novo na tela ainda — só preparar os dados.

[RESTRIÇÕES] Não altere as colunas já existentes nem a estrutura da tabela. Não use
frameworks nem bibliotecas externas.

[FORMATO] O arquivo protocolos-mock.html completo e atualizado.
```

### Resultado esperado (trecho alterado)

```js
{
  numero: "2026/000101", assunto: "Solicitação de certidão", requerente: "Ana Souza",
  dataAbertura: "2026-01-12", status: "Aberto", prioridade: "Média",
  setorOrigem: "Protocolo Geral",
  setorAtual: "Recepção",
  historico: []
},
```

---

## Exercício 1 — Aberto → Em Análise

### Spec de referência

> **Como** servidor do setor responsável,
> **quero** mudar o status de um protocolo que está sob minha análise,
> **para que** o andamento fique visível para quem consulta o protocolo depois.

Critérios de aceitação:

- [ ] Só é possível mudar para "Em Análise" um protocolo que esteja "Aberto".
- [ ] A mudança grava no histórico: status anterior, novo status, data, setor.
- [ ] O histórico aparece na tabela (ou numa célula expandida), do mais recente para o mais antigo.
- [ ] Um protocolo "Arquivado" não aceita mudança de status.

### Prompt estruturado de referência

```
[PAPEL] Você é um desenvolvedor front-end especializado em HTML, CSS e JavaScript
puro.

[CONTEXTO] Tenho protocolos-mock.html, com cada protocolo tendo os campos status,
setorAtual e historico (array, hoje vazio).

[TAREFA] Adicione um botão "Iniciar análise" que aparece só para protocolos com
status "Aberto". Ao clicar, muda o status para "Em Análise", grava uma entrada no
historico (de: "Aberto", para: "Em Análise", data: hoje, setor: setorAtual) e
mostra o histórico na tabela, do mais recente para o mais antigo.

[RESTRIÇÕES] Não altere as colunas já existentes. Protocolos "Arquivado" não podem
receber nenhuma mudança de status. Não use frameworks nem bibliotecas externas.

[FORMATO] O arquivo protocolos-mock.html completo e atualizado.
```

### Resultado esperado (trechos alterados)

```js
function iniciarAnalise(index) {
  const p = protocolos[index];
  if (p.status !== "Aberto") return;

  p.historico.push({ de: p.status, para: "Em Análise", data: new Date().toISOString().slice(0, 10), setor: p.setorAtual });
  p.status = "Em Análise";
  renderTabela();
}
```

```js
// dentro da renderização de cada linha
const botaoAcao = p.status === "Aberto"
  ? `<button type="button" onclick="iniciarAnalise(${index})">Iniciar análise</button>`
  : "";

const historicoHtml = p.historico
  .slice()
  .reverse()
  .map(h => `<li>${h.de} → ${h.para} (${h.data}, ${h.setor})</li>`)
  .join("");
```

**O que discutir com a turma:** quem escreveu a spec de verdade antes do prompt normalmente já incluiu "protocolo Arquivado não aceita mudança" na restrição — quem pulou a spec e foi direto ao prompt tende a esquecer esse caso, porque não é óbvio ao ler só o pedido "iniciar análise".

---

## Exercício 2 — Template para novas transições

### Template de referência

```md
## Papel
Desenvolvedor front-end especializado em HTML, CSS e JavaScript puro.

## Contexto
Tenho protocolos-mock.html, com cada protocolo tendo status, setorAtual e
historico. As transições válidas até agora: Aberto → Em Análise.

## Tarefa
Adicione a transição "{{STATUS_ORIGEM}} → {{STATUS_DESTINO}}", disponível só
para protocolos com status "{{STATUS_ORIGEM}}" e restrita ao setor
"{{SETOR_RESPONSAVEL}}". Grava historico e atualiza o status.

## Restrições
- Não altere as transições já existentes.
- Protocolos "Arquivado" não podem receber nenhuma mudança de status.
- Não use frameworks nem bibliotecas externas.

## Formato
O arquivo protocolos-mock.html completo e atualizado.
```

### Chamada real na IA — Em Análise → Deferido

```md
Aqui está meu template de prompt. Substitua os placeholders pelos valores
abaixo e execute a tarefa resultante.

## Papel
Desenvolvedor front-end especializado em HTML, CSS e JavaScript puro.

## Contexto
Tenho protocolos-mock.html, com cada protocolo tendo status, setorAtual e
historico. As transições válidas até agora: Aberto → Em Análise.

## Tarefa
Adicione a transição "{{STATUS_ORIGEM}} → {{STATUS_DESTINO}}", disponível só
para protocolos com status "{{STATUS_ORIGEM}}" e restrita ao setor
"{{SETOR_RESPONSAVEL}}". Grava historico e atualiza o status.

## Restrições
- Não altere as transições já existentes.
- Protocolos "Arquivado" não podem receber nenhuma mudança de status.
- Não use frameworks nem bibliotecas externas.

## Formato
O arquivo protocolos-mock.html completo e atualizado.

---
Valores para esta chamada:
{{STATUS_ORIGEM}} = Em Análise
{{STATUS_DESTINO}} = Deferido
{{SETOR_RESPONSAVEL}} = Jurídico
```

A segunda chamada (Em Análise → Indeferido) é idêntica, só trocando `{{STATUS_DESTINO}} = Indeferido`.

### Resultado esperado (trecho alterado)

```js
function deferir(index) {
  const p = protocolos[index];
  if (p.status !== "Em Análise" || p.setorAtual !== "Jurídico") return;
  p.historico.push({ de: p.status, para: "Deferido", data: new Date().toISOString().slice(0, 10), setor: p.setorAtual });
  p.status = "Deferido";
  renderTabela();
}

function indeferir(index) {
  const p = protocolos[index];
  if (p.status !== "Em Análise" || p.setorAtual !== "Jurídico") return;
  p.historico.push({ de: p.status, para: "Indeferido", data: new Date().toISOString().slice(0, 10), setor: p.setorAtual });
  p.status = "Indeferido";
  renderTabela();
}
```

**O que discutir com a turma:** o template só é útil se continuar funcionando para uma terceira transição hipotética (ex.: Deferido → Arquivado). Peça que cada aluno teste isso mentalmente antes de considerar o exercício concluído — é a mesma dica da Aula 0, agora aplicada a regras de negócio, não só a campos novos.
