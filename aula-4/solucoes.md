# Aula 0 · Soluções de referência (Mão na massa)

> Atualizado para o formato atual do "Mão na massa": um único arquivo `protocolos-mock.html` (HTML + CSS + JavaScript puro, sem PHP/MySQL, sem instalação), para que qualquer aluno consiga rodar com IA gratuita. Mostrar somente depois que o tempo de execução do exercício terminar.

---

## Ponto de partida

### Prompt usado

```
[PAPEL] Você é um desenvolvedor front-end especializado em HTML, CSS e JavaScript puro.

[CONTEXTO] Estou simulando o SISPROT sem banco de dados, só para praticar prompts —
os dados ficam num array de objetos em JavaScript, direto no HTML.

[TAREFA] Crie uma página que lista protocolos fictícios numa tabela, com as colunas:
número, assunto, requerente, data de abertura e status (Aberto, Em Análise, Deferido,
Indeferido, Arquivado). Inclua uns 5 protocolos de exemplo no array.

[RESTRIÇÕES] Não use frameworks nem bibliotecas externas (React, jQuery, Bootstrap
etc.) — só HTML, CSS e JavaScript puro, tudo em um único arquivo.

[FORMATO] Um único arquivo HTML autocontido, chamado protocolos-mock.html, pronto
para abrir no navegador.
```

### Resultado esperado — `protocolos-mock.html`

```html
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>SISPROT · Mock de protocolos</title>
<style>
  body { font-family: Arial, sans-serif; margin: 40px; color: #1A2233; }
  h1 { margin-bottom: 20px; }
  table { border-collapse: collapse; width: 100%; }
  th, td { border: 1px solid #DEE2EA; padding: 10px 14px; text-align: left; }
  th { background: #0F1C36; color: #fff; font-size: 0.85rem; text-transform: uppercase; }
  tr:nth-child(even) { background: #F3F5F9; }
</style>
</head>
<body>

<h1>Protocolos</h1>
<table id="tabela-protocolos">
  <thead>
    <tr>
      <th>Número</th>
      <th>Assunto</th>
      <th>Requerente</th>
      <th>Data de abertura</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<script>
  const protocolos = [
    { numero: "2026/000101", assunto: "Solicitação de certidão",        requerente: "Ana Souza",     dataAbertura: "2026-01-12", status: "Aberto" },
    { numero: "2026/000102", assunto: "Pedido de vista de processo",    requerente: "Carlos Lima",    dataAbertura: "2026-01-15", status: "Em Análise" },
    { numero: "2026/000103", assunto: "Recurso administrativo",         requerente: "Beatriz Melo",   dataAbertura: "2026-01-20", status: "Deferido" },
    { numero: "2026/000104", assunto: "Requerimento de baixa cadastral",requerente: "João Pedro",     dataAbertura: "2026-02-01", status: "Indeferido" },
    { numero: "2026/000105", assunto: "Pedido de cópia de documento",   requerente: "Marina Alves",   dataAbertura: "2026-02-05", status: "Arquivado" }
  ];

  const tbody = document.querySelector("#tabela-protocolos tbody");
  protocolos.forEach(p => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${p.numero}</td>
      <td>${p.assunto}</td>
      <td>${p.requerente}</td>
      <td>${p.dataAbertura}</td>
      <td>${p.status}</td>
    `;
    tbody.appendChild(tr);
  });
</script>

</body>
</html>
```

---

## Exercício 1

### Prompt estruturado de referência

```
[PAPEL] Você é um desenvolvedor front-end especializado em HTML, CSS e JavaScript
puro.

[CONTEXTO] Tenho a página protocolos-mock.html, que lista protocolos fictícios numa
tabela, com os dados num array de objetos JavaScript (sem banco de dados). Colunas
atuais: número, assunto, requerente, data de abertura, status.

[TAREFA] Adicione um campo "prioridade" a cada protocolo, com três valores
possíveis: Baixa, Média, Alta. Todo protocolo novo deve nascer com prioridade
"Média". O campo deve aparecer como uma nova coluna na tabela, depois de "Status".

[RESTRIÇÕES] Não altere as colunas já existentes nem a estrutura da tabela. Não use
frameworks nem bibliotecas externas — continue em HTML, CSS e JavaScript puro, num
único arquivo.

[FORMATO] O arquivo protocolos-mock.html completo e atualizado.
```

### Resultado esperado (trechos alterados)

Cada item do array ganha o campo `prioridade`:

```js
{ numero: "2026/000101", assunto: "Solicitação de certidão", requerente: "Ana Souza", dataAbertura: "2026-01-12", status: "Aberto", prioridade: "Média" },
```

Cabeçalho da tabela:

```html
<th>Status</th>
<th>Prioridade</th>
```

Linha renderizada:

```js
tr.innerHTML = `
  <td>${p.numero}</td>
  <td>${p.assunto}</td>
  <td>${p.requerente}</td>
  <td>${p.dataAbertura}</td>
  <td>${p.status}</td>
  <td>${p.prioridade}</td>
`;
```

**O que discutir com a turma:** quem rodou só o prompt fraco original (`"adiciona um campo de prioridade no protocolo"`) muito provavelmente recebeu um campo de texto livre (um `<input>` ou uma string qualquer) em vez de um conjunto fechado de três valores — porque o prompt fraco nunca disse que a prioridade é uma lista fixa, nem qual o valor padrão.

---

## Exercício 2

### Template de referência

```md
## Papel
Desenvolvedor front-end especializado em HTML, CSS e JavaScript puro.

## Contexto
Tenho a página protocolos-mock.html, que lista protocolos num array de
objetos JavaScript e os renderiza numa tabela.

## Tarefa
Adicione o campo "{{NOME_DO_CAMPO}}" ({{TIPO_E_REGRA}}) a cada protocolo:
no array de dados e como nova coluna na tabela.

## Restrições
- Não altere as colunas já existentes nem a estrutura da tabela.
- Não use frameworks nem bibliotecas externas — HTML, CSS e JavaScript puro,
  num único arquivo.

## Formato
O arquivo protocolos-mock.html completo e atualizado.
```

### Exemplo de uso (mostrado na aula) — campo hipotético `observacoes`

```md
## Papel
Desenvolvedor front-end especializado em HTML, CSS e JavaScript puro.

## Contexto
Tenho a página protocolos-mock.html, que lista protocolos num array de
objetos JavaScript e os renderiza numa tabela.

## Tarefa
Adicione o campo "observacoes" (texto livre, opcional) a cada protocolo:
no array de dados e como nova coluna na tabela.

## Restrições
- Não altere as colunas já existentes nem a estrutura da tabela.
- Não use frameworks nem bibliotecas externas — HTML, CSS e JavaScript puro,
  num único arquivo.

## Formato
O arquivo protocolos-mock.html completo e atualizado.
```

Esse é o exemplo que já aparece no material do aluno (para mostrar o "formato" do template preenchido) — o campo do exercício em si é outro, `setor_origem`, resolvido abaixo.

### Chamada real na IA (mostrada na aula) — campo hipotético `observacoes`

**Ponto que costuma gerar dúvida:** não existe um passo de "carregar o template" — a IA não guarda nada de uma chamada para a outra além do que está na própria mensagem. A "chamada" é uma única mensagem, colada de uma vez no chat, com o template inteiro (placeholders visíveis) seguido dos valores desta vez. A cada campo novo, cola-se o bloco inteiro de novo — só os dois valores no final mudam.

```md
Aqui está meu template de prompt. Substitua os placeholders pelos valores
abaixo e execute a tarefa resultante.

## Papel
Desenvolvedor front-end especializado em HTML, CSS e JavaScript puro.

## Contexto
Tenho a página protocolos-mock.html, que lista protocolos num array de
objetos JavaScript e os renderiza numa tabela.

## Tarefa
Adicione o campo "{{NOME_DO_CAMPO}}" ({{TIPO_E_REGRA}}) a cada protocolo:
no array de dados e como nova coluna na tabela.

## Restrições
- Não altere as colunas já existentes nem a estrutura da tabela.
- Não use frameworks nem bibliotecas externas — HTML, CSS e JavaScript puro,
  num único arquivo.

## Formato
O arquivo protocolos-mock.html completo e atualizado.

---
Valores para esta chamada:
{{NOME_DO_CAMPO}} = observacoes
{{TIPO_E_REGRA}} = texto livre, opcional
```

### Chamada real na IA — campo do exercício, `setor_origem`

O que o aluno deve enviar de fato para resolver o exercício: o mesmo template, só trocando os dois valores no final.

```md
Aqui está meu template de prompt. Substitua os placeholders pelos valores
abaixo e execute a tarefa resultante.

## Papel
Desenvolvedor front-end especializado em HTML, CSS e JavaScript puro.

## Contexto
Tenho a página protocolos-mock.html, que lista protocolos num array de
objetos JavaScript e os renderiza numa tabela.

## Tarefa
Adicione o campo "{{NOME_DO_CAMPO}}" ({{TIPO_E_REGRA}}) a cada protocolo:
no array de dados e como nova coluna na tabela.

## Restrições
- Não altere as colunas já existentes nem a estrutura da tabela.
- Não use frameworks nem bibliotecas externas — HTML, CSS e JavaScript puro,
  num único arquivo.

## Formato
O arquivo protocolos-mock.html completo e atualizado.

---
Valores para esta chamada:
{{NOME_DO_CAMPO}} = setor_origem
{{TIPO_E_REGRA}} = texto, obrigatório
```

### Template preenchido "à mão" para `setor_origem` (forma alternativa, mais longa)

```md
## Papel
Desenvolvedor front-end especializado em HTML, CSS e JavaScript puro.

## Contexto
Tenho a página protocolos-mock.html, que lista protocolos num array de
objetos JavaScript e os renderiza numa tabela. Campos atuais: número, assunto,
requerente, data de abertura, status, prioridade.

## Tarefa
Adicione o campo "setor_origem" (texto, obrigatório) a cada protocolo: no
array de dados e como nova coluna na tabela.

## Restrições
- Não altere as colunas já existentes nem a estrutura da tabela.
- Não use frameworks nem bibliotecas externas — HTML, CSS e JavaScript puro,
  num único arquivo.

## Formato
O arquivo protocolos-mock.html completo e atualizado.
```

### Resultado esperado (trechos alterados)

```js
{ numero: "2026/000101", assunto: "Solicitação de certidão", requerente: "Ana Souza", dataAbertura: "2026-01-12", status: "Aberto", prioridade: "Média", setorOrigem: "Protocolo Geral" },
```

```html
<th>Prioridade</th>
<th>Setor de origem</th>
```

```js
<td>${p.prioridade}</td>
<td>${p.setorOrigem}</td>
```

**O que discutir com a turma:** o template só é útil se continuar funcionando para um terceiro campo hipotético. Peça que cada aluno teste o próprio template "mentalmente" com outro campo (ex.: "observações") antes de considerar o exercício concluído — se o template não se sustenta para esse novo caso, ainda é específico demais.
