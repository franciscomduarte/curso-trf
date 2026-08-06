# Aula 0 · Roteiro do Instrutor

> Este roteiro é apoio para quem conduz a aula com `slides.md` projetado. Ele não substitui os slides — dá o cronograma, o que dizer e o que fazer em cada bloco, incluindo os momentos em que você sai do deck (demonstrações e exercícios).

## Objetivos de aprendizagem

Ao final desta aula, o aluno é capaz de:

1. Explicar o que é engenharia de prompt e por que ela muda o resultado obtido de uma IA.
2. Estruturar um prompt usando os cinco blocos: papel, contexto, tarefa, restrições, formato.
3. Escolher entre zero-shot e few-shot prompting conforme a tarefa.
4. Usar XML Prompting e Markdown Prompting para estruturar prompts complexos sem ambiguidade.
5. Criar e aplicar um prompt template reutilizável.
6. Aplicar técnicas de redução de alucinação e aumento de precisão.
7. Diagnosticar por que um prompt fraco falhou, e corrigi-lo.

## Cronograma minuto a minuto (4h)

| Horário | Bloco | Slides |
|---|---|---|
| 09:00–09:10 | Abertura: o curso, o projeto SISPROT, agenda de hoje | 1–4 |
| 09:10–09:25 | Teoria: o que é engenharia de prompt + prompt fraco vs. estruturado | 5–6 |
| 09:25–09:40 | 🎬 Demonstração ao vivo 1 | 7 |
| 09:40–09:50 | Debrief da demo 1 + visão geral da anatomia do prompt | 8–9 |
| 09:50–10:10 | Teoria: Papel, Contexto, Restrições, Formato | 10–13 |
| 10:10–10:25 | Teoria: Zero-shot, Few-shot, tabela comparativa | 14–16 |
| 10:25–10:40 | **Intervalo** | — |
| 10:40–10:55 | Teoria: XML Prompting, Markdown Prompting, quando usar cada um | 17–19 |
| 10:55–11:15 | 🎬 Demonstração ao vivo 2 | 20 |
| 11:15–11:20 | Debrief da demo 2 | 21 |
| 11:20–11:45 | ✏️ Exercício 1 (individual) | 22 |
| 11:45–12:00 | Teoria: Prompt Templates, redução de alucinação, aumento de precisão | 23–25 |
| 12:00–12:30 | ✏️ Exercício 2 (dupla) | 26 |
| 12:30–12:35 | Recapitulação: erros mais comuns | 27 |
| 12:35–12:45 | 🏆 Desafio final (explicação + início) | 28 |
| 12:45–13:00 | Encerramento, preview da Aula 1, perguntas | 29–30 |

## Conteúdo teórico, na ordem em que aparece

1. O que é engenharia de prompt / por que importa
2. Anatomia de um prompt eficaz (papel, contexto, tarefa, restrições, formato)
3. Zero-shot prompting
4. Few-shot prompting
5. XML Prompting
6. Markdown Prompting
7. Prompt Templates
8. Técnicas para reduzir alucinação
9. Técnicas para aumentar precisão

## Demonstrações ao vivo

### Demonstração 1 — Prompt fraco vs. prompt estruturado (slide 7)

**O que fazer:**
1. Abra a ferramenta de IA (Claude Code) numa pasta vazia `sisprot`.
2. Cole o **prompt fraco** (`prompts.md` §1a). Deixe a turma reagir ao resultado — geralmente algo genérico, às vezes em outra stack, às vezes sem banco de dados.
3. Descarte o resultado. Cole o **prompt estruturado** (`prompts.md` §1b).
4. Mostre o resultado: `schema.sql` + `conexao.php` — compare com o gabarito em `codigo/schema.sql` e `codigo/conexao.php` (uso privado seu, não mostre a pasta `codigo/` aos alunos como "a resposta certa" — ela é referência sua para conferir se o que a IA gerar está no caminho certo).
5. Rode o SQL no phpMyAdmin ao vivo, mostre a tabela criada.

**Pergunta para a turma antes de revelar o prompt estruturado:** "o que faltou dizer no primeiro prompt, que a IA teve que inventar?"

### Demonstração 2 — XML Prompting + Few-shot (slide 20)

**O que fazer:**
1. A partir do estado da Demo 1, cole o prompt XML completo (`prompts.md` §Demonstração 2).
2. Destaque o bloco `<exemplo>` — é o few-shot: um trecho de código mostrando o padrão de validação que o restante do CRUD deve seguir.
3. Mostre o resultado gerado (`index.php`, `protocolo_form.php`, `encerrar.php`) — novamente, compare mentalmente com o gabarito em `codigo/`, sem mostrar o arquivo pronto à turma.
4. Teste ao vivo no navegador: registrar um protocolo, editar, arquivar.
5. **Opcional, se houver tempo:** cole a versão equivalente em Markdown (mesma seção do `prompts.md`) e mostre que o resultado é equivalente — reforça que a marcação não é o que importa, e sim a estrutura.

## Exercícios

Enunciados completos, arquivos utilizados, dificuldades comuns e dicas: ver `exercicios.md`. Soluções de referência: `solucoes.md` (não distribuir antes do tempo).

- **Exercício 1** (individual, 25 min, slide 22): reescrever o prompt fraco `"adiciona um campo de prioridade no protocolo"`.
- **Exercício 2** (dupla, 30 min, slide 26): criar um prompt template reutilizável e aplicá-lo ao campo `setor_origem`.

**Durante os exercícios:** circule pelas bancadas. A dificuldade mais comum não é erro de código — é prompt ainda ambíguo (falta restrição, persona genérica, tarefa mal delimitada). Peça para o aluno reler o próprio prompt em voz alta antes de rodar de novo.

## Desafio final

Ver `desafio.md` — critérios de sucesso e observações para o instrutor sobre variação de abordagens esperada.

## Checklist do instrutor

Ver `checklist-instrutor.md` (antes, durante e depois da aula).

## Materiais de apoio

Ver `materiais-apoio.md`.

## Perguntas frequentes

Ver `faq.md`.
