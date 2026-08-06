# Aula 0 · Desafio final — material do instrutor (demonstração com Claude Code)

> Mostrar somente na demonstração final, depois do tempo de execução do desafio. Este arquivo é o material de apoio para você rodar ao vivo — não é para distribuir à turma antes disso.
>
> Tudo aqui roda no frontend — um único arquivo HTML, sem servidor, sem banco de dados. Mesma base usada na Mão na massa (`protocolos-mock.html`).

## Antes da aula

1. Crie uma pasta vazia para a demonstração (ex.: `protocolos-mock-desafio/`) — a ideia é reconstruir o arquivo do zero, ao vivo, com os 4 prompts usados hoje, em sequência.
2. Abra um terminal dentro dessa pasta e rode `claude` para iniciar o Claude Code.
3. Alternativa mais rápida: se preferir não repetir os 3 primeiros prompts, copie o `protocolos-mock.html` que a turma já gerou na Mão na massa (com `prioridade` e `setor_origem`) para dentro da pasta e pule direto para o Prompt 4.

## Os 4 prompts, em sequência (os mesmos que estão na aula)

### Prompt 1 · Ponto de partida (base do mock)

```
[PAPEL] Você é um desenvolvedor front-end especializado em HTML, CSS e JavaScript
puro.

[CONTEXTO] Estou simulando o SISPROT sem banco de dados, só para praticar
prompts — os dados ficam num array de objetos em JavaScript, direto no HTML.

[TAREFA] Crie uma página que lista protocolos fictícios numa tabela, com as
colunas: número, assunto, requerente, data de abertura e status (Aberto, Em
Análise, Deferido, Indeferido, Arquivado). Inclua uns 5 protocolos de exemplo
no array.

[RESTRIÇÕES] Não use frameworks nem bibliotecas externas (React, jQuery,
Bootstrap etc.) — só HTML, CSS e JavaScript puro, tudo em um único arquivo.

[FORMATO] Um único arquivo HTML autocontido, chamado protocolos-mock.html,
pronto para abrir no navegador.
```

Resultado esperado: ver `solucoes.md` → "Ponto de partida".

### Prompt 2 · Exercício 1 (campo "prioridade")

```
[PAPEL] Você é um desenvolvedor front-end especializado em HTML, CSS e JavaScript
puro.

[CONTEXTO] Tenho a página protocolos-mock.html, que lista protocolos fictícios
numa tabela, com os dados num array de objetos JavaScript (sem banco de dados).
Colunas atuais: número, assunto, requerente, data de abertura, status.

[TAREFA] Adicione um campo "prioridade" a cada protocolo, com três valores
possíveis: Baixa, Média, Alta. Todo protocolo novo deve nascer com prioridade
"Média". O campo deve aparecer como uma nova coluna na tabela, depois de
"Status".

[RESTRIÇÕES] Não altere as colunas já existentes nem a estrutura da tabela. Não
use frameworks nem bibliotecas externas — continue em HTML, CSS e JavaScript
puro, num único arquivo.

[FORMATO] O arquivo protocolos-mock.html completo e atualizado.
```

Resultado esperado: ver `solucoes.md` → "Exercício 1".

### Prompt 3 · Exercício 2 (campo "setor_origem", via template)

Este é o padrão de "chamada" ensinado na Etapa 4: o template inteiro, colado de novo, com os valores desta vez no final — não existe um passo de "carregar template" separado.

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

Resultado esperado: ver `solucoes.md` → "Exercício 2".

### Prompt 4 · Desafio final (anexos, como array por protocolo)

```
[PAPEL] Você é um desenvolvedor front-end especializado em HTML, CSS e JavaScript
puro.

[CONTEXTO] Este é o protocolos-mock.html: uma página HTML autocontida, sem banco
de dados, que lista protocolos fictícios a partir de um array de objetos
JavaScript, renderizados numa tabela.

[TAREFA] Adicione uma funcionalidade de anexos: cada protocolo pode ter um ou
mais anexos, cada um sendo apenas uma referência textual (nome do arquivo), sem
upload real. Modele como um array "anexos" dentro de cada protocolo (pode
iniciar vazio) — não como um campo de texto único. Na tabela, mostre a
quantidade de anexos de cada protocolo. Permita adicionar e remover um anexo
diretamente na página, sem recarregar.

[RESTRIÇÕES] Não altere as colunas já existentes nem a estrutura da tabela. Não
use frameworks nem bibliotecas externas — HTML, CSS e JavaScript puro, num único
arquivo. Sem upload real de arquivo — só o nome como texto. Os dados não
precisam persistir depois de recarregar a página.

[FORMATO] O arquivo protocolos-mock.html completo e atualizado.
```

Resultado esperado detalhado abaixo (é o novo, ainda não documentado em `solucoes.md`).

## Resultado esperado do Prompt 4 (referência, caso queira comparar com o que o Claude Code gerar)

### Array de dados — cada protocolo ganha `anexos: []`

```js
const protocolos = [
  { numero: "2026/000101", assunto: "Solicitação de certidão", requerente: "Ana Souza", dataAbertura: "2026-01-12", status: "Aberto", prioridade: "Média", setorOrigem: "Protocolo Geral", anexos: ["oficio_001.pdf"] },
  { numero: "2026/000102", assunto: "Pedido de vista de processo", requerente: "Carlos Lima", dataAbertura: "2026-01-15", status: "Em Análise", prioridade: "Alta", setorOrigem: "Jurídico", anexos: [] },
  // ...os demais protocolos, cada um com seu próprio array "anexos"
];
```

### Cabeçalho da tabela — nova coluna

```html
<th>Anexos</th>
```

### Renderização — função que desenha a tabela (agora reutilizável, chamada de novo a cada mudança)

```js
function renderTabela() {
  const tbody = document.querySelector("#tabela-protocolos tbody");
  tbody.innerHTML = "";

  protocolos.forEach((p, index) => {
    const tr = document.createElement("tr");

    const listaAnexos = p.anexos
      .map((nome, anexoIndex) => `
        <li>
          ${nome}
          <button type="button" onclick="removerAnexo(${index}, ${anexoIndex})">Remover</button>
        </li>
      `)
      .join("");

    tr.innerHTML = `
      <td>${p.numero}</td>
      <td>${p.assunto}</td>
      <td>${p.requerente}</td>
      <td>${p.dataAbertura}</td>
      <td>${p.status}</td>
      <td>${p.prioridade}</td>
      <td>${p.setorOrigem}</td>
      <td>
        ${p.anexos.length} anexo(s)
        <ul>${listaAnexos}</ul>
        <button type="button" onclick="adicionarAnexo(${index})">+ Anexo</button>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

function adicionarAnexo(index) {
  const nome = prompt("Nome do arquivo (ex.: oficio_001.pdf):");
  if (nome && nome.trim() !== "") {
    protocolos[index].anexos.push(nome.trim());
    renderTabela();
  }
}

function removerAnexo(protocoloIndex, anexoIndex) {
  protocolos[protocoloIndex].anexos.splice(anexoIndex, 1);
  renderTabela();
}

renderTabela();
```

> A diferença em relação à versão anterior (Exercícios 1 e 2): antes, a tabela era desenhada uma vez, no carregamento da página. Agora existe uma função `renderTabela()` chamada de novo a cada `adicionarAnexo`/`removerAnexo`, porque o estado muda em tempo real, sem recarregar.

## Testando ao vivo

1. Abrir `protocolos-mock.html` (dentro da pasta `protocolos-mock-desafio/`) no navegador.
2. Clicar em "+ Anexo" num protocolo, digitar um nome fictício (ex.: `comprovante.jpg`) → a lista e a contagem atualizam na hora.
3. Adicionar 2-3 anexos no mesmo protocolo.
4. Clicar em "Remover" num anexo → confirma que some da lista e a contagem cai.
5. Recarregar a página → os anexos voltam ao estado inicial do array (esperado: sem persistência, é só um mock em memória).

## Pontos para comentar com a turma

- O prompt usado é **literalmente o mesmo formato** das Demonstrações 1 e 2 — só o bloco `[TAREFA]` muda. Reforça que a estrutura importa mais do que "decorar" um prompt novo a cada tarefa.
- Modelar como array por protocolo (em vez de um campo de texto único) é a decisão de design mais avançada possível dentro do desafio, mesmo sem banco de dados — vale conectar com o que a Aula 1 vai formalizar sobre modelagem de fluxos e relacionamentos (lá, isso vira uma tabela relacionada de verdade).
- Claude Code edita o arquivo diretamente (não é preciso colar o conteúdo dele no prompt) — é o primeiro contato da turma com um agente de código, em vez de um chat. Vale nomear essa diferença explicitamente.
