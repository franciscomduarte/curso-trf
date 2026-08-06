# Aula 0 · Desafio final

**Duração sugerida:** 10 minutos de explicação + continuação como tarefa de casa, se não houver tempo de concluir em aula.

## Objetivo

Consolidar, sem roteiro pronto, as técnicas de engenharia de prompt vistas hoje: estrutura clara, restrições explícitas, formato de saída definido, e (opcionalmente) exemplo ou template.

## Enunciado

Adicione ao SISPROT um campo de **anexos** — uma referência textual simples (por exemplo, o nome de um arquivo, sem upload real de arquivo) associada a cada protocolo.

Regras:

1. Escreva **você mesmo**, do zero, o prompt que vai usar — sem copiar os prompts das demonstrações.
2. O prompt deve aplicar **pelo menos 4** das técnicas vistas na aula: estrutura em blocos (papel/contexto/tarefa/restrições/formato), restrições explícitas, formato de saída definido, few-shot ou template reutilizável.
3. Decida você mesmo os detalhes de design: um protocolo pode ter mais de um anexo? Como isso aparece na listagem?
4. Depois de gerar o código, **teste manualmente** — crie um protocolo com anexo, edite, confirme que aparece na listagem.

## Critério de sucesso

- [ ] O prompt utilizado foi registrado (cole-o num arquivo de texto ou no chat da turma).
- [ ] O código gerado funciona de ponta a ponta (testado manualmente, não só "parece certo").
- [ ] O aluno consegue explicar, em 1-2 frases, por que estruturou o prompt daquele jeito específico.

## Para o instrutor

Não existe uma única solução esperada aqui — o valor do desafio está na variação de abordagens de design (anexo único vs. múltiplos, campo de texto vs. tabela relacionada) e na qualidade do prompt, não no resultado exato. Reserve 2-3 minutos ao final para 2-3 alunos mostrarem rapidamente o prompt que escreveram — isso costuma gerar a discussão mais rica da aula.

Se algum aluno modelar anexos como uma tabela relacionada (`protocolo_id` + `nome_arquivo`) em vez de um campo de texto simples, é um ótimo sinal de que ele já está pensando alguns passos além do enunciado — vale destacar isso à turma como preview do tipo de decisão que a Aula 1 (modelagem de fluxos) vai formalizar.
