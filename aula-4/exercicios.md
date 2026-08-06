# Aula 0 · Exercícios

Dois exercícios, crescentes em dificuldade e autonomia. As soluções de referência estão em `solucoes.md` — não as distribua antes do tempo.

---

## Exercício 1 · Reescrever um prompt fraco (individual · 25 min)

**Objetivo:** praticar a transformação de um prompt vago em um prompt estruturado, usando os blocos papel / contexto / tarefa / restrições / formato apresentados na Demonstração 1.

**Contexto:** o aluno já tem, na própria máquina, o SISPROT criado na Demonstração 1 (tabela `protocolos` + `conexao.php`).

**Enunciado:**
1. Você recebeu o seguinte prompt fraco: `"adiciona um campo de prioridade no protocolo"`.
2. Reescreva-o como um prompt estruturado, decidindo você mesmo: quais valores a prioridade pode ter, se é obrigatória, e onde ela deve aparecer (formulário e/ou listagem).
3. Rode o prompt reescrito na ferramenta de IA disponível.
4. Aplique o resultado (rode o SQL, substitua os arquivos alterados) e confirme que funciona.
5. Compare mentalmente: o que teria acontecido se você tivesse rodado só o prompt fraco original?

**Arquivos utilizados:** `codigo/schema.sql`, `codigo/conexao.php`, `codigo/protocolo_form.php`, `codigo/index.php` (estado da Demonstração 1/2).

**Solução esperada:** ver `solucoes.md#exercício-1`.

**Dificuldades comuns:**
- Esquecer de dizer que o campo é opcional ou que tem valores fixos (a IA pode gerar um campo de texto livre em vez de um conjunto fechado de opções).
- Não incluir a restrição "não altere nada que já funciona" — o resultado pode reescrever arquivos inteiros em vez de só adicionar o campo.
- Prompt estruturado, mas ainda genérico demais no bloco `[TAREFA]` (ex.: "adicione prioridade" sem dizer onde e como).

**Dicas:**
- Releia o prompt 1b da Demonstração 1 como modelo de estrutura.
- Pergunte-se: das cinco partes (papel/contexto/tarefa/restrições/formato), quais estão ausentes no prompt fraco original?
- Se a IA devolver uma pergunta de esclarecimento em vez de código, isso é sinal de que o prompt ainda está ambíguo — refine e tente de novo.

---

## Exercício 2 · Prompt template reutilizável (dupla · 30 min)

**Objetivo:** criar um prompt template parametrizável — com placeholders — que sirva para adicionar qualquer novo campo ao protocolo, sem reescrever a estrutura do prompt do zero a cada vez.

**Contexto:** o SISPROT já tem o CRUD completo (Demonstração 2) e, possivelmente, o campo de prioridade do Exercício 1.

**Enunciado:**
1. Em dupla, criem um template de prompt (em XML ou Markdown, à escolha) com placeholders como `{{NOME_DO_CAMPO}}`, `{{TIPO_E_REGRA}}`, `{{ARQUIVOS_ENVOLVIDOS}}`.
2. O template deve manter fixos os blocos que não mudam entre uma tarefa e outra (papel, restrições, formato) e deixar variável apenas o que de fato varia.
3. Preencham o template para adicionar o campo `setor_origem` (texto, obrigatório) ao protocolo.
4. Rodem o prompt resultante na ferramenta de IA, apliquem o resultado e testem.

**Arquivos utilizados:** `codigo/protocolo_form.php`, `codigo/index.php`, `codigo/schema.sql` (estado atual da dupla).

**Solução esperada:** ver `solucoes.md#exercício-2`.

**Dificuldades comuns:**
- Template genérico demais: perde precisão porque tenta cobrir qualquer tipo de mudança, não só campos novos.
- Template específico demais: só funciona para o caso exato que a dupla tinha em mente, não é reutilizável.
- Esquecer de manter a restrição "não usar frameworks" e "sempre usar prepared statements" fixas no template — são regras do projeto, não da tarefa específica.

**Dicas:**
- Pensem no template como uma receita de bolo: o que é ingrediente fixo (papel, restrições, formato) e o que é "a gosto" (o campo específico)?
- Testem o template mentalmente com um segundo campo hipotético antes de considerar pronto — se não funcionar para outro caso, ainda não é reutilizável.
