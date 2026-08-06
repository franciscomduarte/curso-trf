# Aula 0 · Prompts utilizados

Todos os prompts desta aula, na ordem em que aparecem no roteiro do instrutor. Use este arquivo como referência rápida durante a demonstração — copie e cole diretamente na ferramenta de IA.

---

## Demonstração 1 · Prompt "no susto" vs. prompt estruturado

### 1a — Prompt fraco (o que a maioria escreve sem pensar)

```
cria um sistema de protocolo
```

**Por que é fraco:** não diz linguagem, banco de dados, campos, formato de saída. A IA vai preencher todas essas lacunas com suposições genéricas — às vezes um sistema web completo em outra stack, às vezes só um esqueleto sem banco de dados.

### 1b — Prompt estruturado (papel · contexto · tarefa · restrições · formato)

```
[PAPEL] Você é um desenvolvedor PHP sênior, especialista em sistemas administrativos
para o setor público.

[CONTEXTO] Vou construir o SISPROT, um sistema de protocolo administrativo para um
órgão público. Ele vai rodar em PHP puro (sem framework) + MySQL, ambiente XAMPP,
usando PDO com prepared statements.

[TAREFA] Crie o modelo de dados inicial: uma tabela "protocolos" que registre número
do protocolo, assunto, nome do requerente, data de abertura e status atual (valores
possíveis: Aberto, Em Análise, Deferido, Indeferido, Arquivado).

[RESTRIÇÕES] Não use frameworks. Não crie autenticação ainda — isso será tratado em
outra etapa. Gere apenas o SQL de criação da tabela e o arquivo de conexão PDO.

[FORMATO] Primeiro o SQL completo e comentado; depois o arquivo conexao.php.
```

**Resultado esperado:** `schema.sql` com a tabela `protocolos` (id, numero, assunto, requerente, data_abertura, status) e `conexao.php` com PDO — ver `codigo/schema.sql` e `codigo/conexao.php`.

---

## Demonstração 2 · XML Prompting + Markdown Prompting + Few-shot

Prompt estruturado com tags XML para separar seções sem ambiguidade, e um exemplo (few-shot) do estilo de código esperado.

```xml
<prompt>
  <papel>Desenvolvedor PHP sênior, especialista em sistemas administrativos para o setor público.</papel>

  <contexto>
    Projeto SISPROT. Já existem a tabela "protocolos" (id, numero, assunto, requerente,
    data_abertura, status) e o arquivo conexao.php com PDO.
  </contexto>

  <tarefa>
    Gere o CRUD completo de protocolos:
    - index.php: listagem de todos os protocolos, com link "Editar" e, se o status não
      for "Arquivado", link "Arquivar".
    - protocolo_form.php: formulário único para criar e editar (usa GET ?id= para saber
      se é edição). Ao criar, o status inicial é sempre "Aberto".
    - encerrar.php: muda o status para "Arquivado" e redireciona para index.php.
  </tarefa>

  <exemplo>
    <descricao>Estilo de validação já usado no projeto — siga o mesmo padrão:</descricao>
    <codigo>
      if ($campo === '') { $erros[] = 'Campo obrigatório.'; }
    </codigo>
  </exemplo>

  <restricoes>
    - Sempre usar prepared statements (PDO), nunca concatenar SQL.
    - Mensagens de sucesso via querystring (index.php?msg=criado/editado/encerrado).
    - Escapar toda saída de dados do usuário com htmlspecialchars.
    - Não usar frameworks.
  </restricoes>

  <formato>Um arquivo por vez, com o nome do arquivo escrito antes do código correspondente.</formato>
</prompt>
```

**Resultado esperado:** `index.php`, `protocolo_form.php` e `encerrar.php` completos — ver pasta `codigo/`.

**Observação para o instrutor:** mostre à turma que as tags XML (`<papel>`, `<contexto>`, `<tarefa>`...) não têm "poder mágico" — o que importa é a separação inequívoca das seções. O mesmo prompt funcionaria em Markdown, com `##` no lugar das tags. XML tende a ser mais robusto quando o conteúdo de uma seção já contém código ou listas (menos ambiguidade sobre onde uma seção termina).

### Versão equivalente em Markdown Prompting (para comparar)

```markdown
## Papel
Desenvolvedor PHP sênior, especialista em sistemas administrativos para o setor público.

## Contexto
Projeto SISPROT. Já existem a tabela "protocolos" (id, numero, assunto, requerente,
data_abertura, status) e o arquivo conexao.php com PDO.

## Tarefa
Gere o CRUD completo de protocolos: index.php (listagem), protocolo_form.php
(criar/editar), encerrar.php (arquivar).

## Restrições
- Sempre usar prepared statements.
- Mensagens de sucesso via querystring.
- Não usar frameworks.

## Formato
Um arquivo por vez, com o nome antes do código.
```

---

## Exercício 1 · Reescrever um prompt fraco

**Prompt fraco fornecido ao aluno:**

```
adiciona um campo de prioridade no protocolo
```

O aluno deve reescrevê-lo de forma estruturada. Ver `solucoes.md` para uma versão de referência — mas não mostre antes de os alunos tentarem.

---

## Exercício 2 · Prompt template reutilizável

Estrutura de template que o aluno deve criar (com placeholders `{{...}}`), depois aplicar preenchendo os placeholders para adicionar o campo `setor_origem`.

```xml
<prompt>
  <papel>Desenvolvedor PHP sênior, especialista em sistemas administrativos para o setor público.</papel>
  <contexto>Projeto SISPROT. Já existem {{ARQUIVOS_ENVOLVIDOS}}.</contexto>
  <tarefa>Adicione o campo "{{NOME_DO_CAMPO}}" ({{TIPO_E_REGRA}}) ao protocolo: banco, formulário e listagem.</tarefa>
  <restricoes>
    - Sempre usar prepared statements.
    - Não altere nada que já funciona.
    - Não usar frameworks.
  </restricoes>
  <formato>SQL primeiro, depois cada arquivo alterado com o nome antes do código.</formato>
</prompt>
```

Ver `solucoes.md` para o template preenchido com `setor_origem` e o resultado esperado.

---

## Desafio final

Sem prompt fornecido — o aluno escreve o próprio prompt para adicionar um campo de "anexos" (referência textual, sem upload real). Ver `desafio.md` para os critérios de avaliação.
