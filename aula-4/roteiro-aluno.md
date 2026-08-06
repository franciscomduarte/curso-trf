# Aula 0 · Roteiro do Aluno

## O que vamos construir

Ao longo de 4 aulas, vamos evoluir um único projeto: o **SISPROT**, um sistema de protocolo administrativo. Hoje construímos a primeira versão — cadastro e listagem de protocolos.

## O que você vai aprender hoje

- Estruturar um prompt em cinco blocos: **papel, contexto, tarefa, restrições, formato**.
- A diferença entre **zero-shot** (pedir direto) e **few-shot** (pedir com exemplo).
- Duas formas de estruturar prompts complexos sem ambiguidade: **XML Prompting** e **Markdown Prompting**.
- Como montar um **template de prompt** reutilizável.
- Técnicas simples para reduzir respostas "inventadas" (alucinação) e aumentar a precisão do que a IA entrega.

## O que você precisa antes de começar

- XAMPP instalado e rodando (Apache + MySQL).
- Uma ferramenta de IA disponível — Claude Code, ChatGPT ou Gemini.
- Uma pasta vazia `htdocs/sisprot`.

## Regra de ouro do curso

**Nunca cole dados reais ou sensíveis** — de processos, pessoas ou setores reais — em nenhuma ferramenta de IA, especialmente as gratuitas. Use sempre números de protocolo, nomes e assuntos fictícios nos exercícios.

## Como a aula está organizada

1. Vemos juntos, na tela, dois prompts (um fraco, um estruturado) pedindo a mesma coisa — e comparamos os resultados.
2. Você pratica a mesma técnica, sozinho, no **Exercício 1**.
3. Vemos uma segunda demonstração, agora com um prompt mais completo (XML + exemplo).
4. Você pratica de novo, em dupla, no **Exercício 2** — criando algo reutilizável.
5. Ao final, um **desafio** sem roteiro: você escreve o próprio prompt, aplicando o que aprendeu.

## Durante os exercícios

- Enunciados completos: `exercicios.md`.
- Não existe "o único jeito certo" de escrever o prompt — existem prompts mais e menos ambíguos. Se o resultado vier estranho, releia seu prompt antes de tudo: falta contexto? A tarefa está clara? Você disse o que a IA **não** deve fazer?
- Guarde os prompts que você escrever hoje — vamos reaproveitá-los como ponto de partida na Aula 1.

## Se tiver dúvida

Confira `faq.md` — várias perguntas comuns já estão respondidas ali.
