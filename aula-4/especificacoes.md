# Aula 0 · Especificações (prévia leve de Spec-Driven Development)

> Nesta aula, Spec-Driven Development é apenas **introduzido brevemente** — o tratamento completo (requisitos, casos de uso, modelagem de fluxos) é o núcleo da Aula 1. Aqui, o objetivo é só plantar a ideia: **um prompt melhora muito quando nasce de uma descrição clara do que "pronto" significa.**

## User story informal do CRUD de protocolos

> **Como** servidor responsável pela recepção de documentos,
> **quero** registrar um novo protocolo administrativo,
> **para que** ele fique disponível para consulta e, futuramente, tramitação entre setores.

## Critérios de aceitação (versão simples)

- [ ] É possível registrar um protocolo informando número, assunto, requerente e data de abertura.
- [ ] O número do protocolo não pode se repetir (é a identificação única do processo).
- [ ] Todo protocolo novo nasce com status "Aberto".
- [ ] É possível listar todos os protocolos, com status visível.
- [ ] É possível editar os dados de um protocolo existente.
- [ ] É possível arquivar um protocolo (status muda para "Arquivado").
- [ ] Um protocolo já arquivado não deve exibir o link "Arquivar" novamente.

## Por que isso importa mesmo numa aula "só de prompt"

Repare que os **critérios de aceitação acima são, quase palavra por palavra, o bloco `[RESTRIÇÕES]` e `[TAREFA]`** dos prompts usados nas demonstrações. Especificar antes de pedir não é uma etapa extra — é o que torna o prompt possível de escrever bem.

Na Aula 1, esse formato de user story + critérios de aceitação vira o ponto de partida oficial de todo prompt do curso, aplicado ao fluxo de tramitação de protocolos.
