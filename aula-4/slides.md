---
marp: true
theme: default
paginate: true
size: 16:9
---

# IA Aplicada ao Desenvolvimento de Software
## Aula 0 · Fundamentos de Engenharia de Prompt

Curso para servidores públicos de TI e desenvolvimento
Projeto único: **SISPROT** — Sistema de Protocolo Administrativo

---

## Sobre este curso

- **4 aulas de 4 horas**, um único projeto evoluindo do início ao fim: o **SISPROT**.
- Metodologia **Problem-Based Learning** — você aprende resolvendo, não assistindo.
- Cada aula: teoria curta → demonstração ao vivo → exercício → desafio.
- Ferramentas de IA cobertas ao longo do curso: **Claude Code, GitHub Copilot, Cursor, Gemini CLI, Continue.dev, Cline**.

---

## Para onde o SISPROT vai

| Aula | O que o projeto ganha |
|---|---|
| **0** (hoje) | Modelo de dados e CRUD de protocolos |
| 1 | Fluxo de tramitação entre setores (Spec-Driven Development) |
| 2 | API de consulta — comparando copilotos de IA |
| 3 | Testes automatizados e documentação completa |

---

## Agenda de hoje

1. O que é engenharia de prompt, e por que importa
2. Anatomia de um prompt eficaz
3. Few-shot, zero-shot, XML e Markdown prompting
4. Prompt templates
5. Reduzindo alucinação, aumentando precisão
6. Desafio final

---

## O que é engenharia de prompt?

**Definição:** a prática de estruturar deliberadamente a instrução que você dá a uma IA, para obter um resultado mais preciso, consistente e revisável.

**Por que importa:** a mesma IA, com o mesmo modelo, produz resultados muito diferentes dependendo de como a tarefa é descrita. A diferença entre um prompt vago e um prompt estruturado é, com frequência, a diferença entre "quase serve" e "pronto para revisar e usar".

**Quando evitar excesso de estrutura:** tarefas triviais e de baixo risco (ex.: "resuma este parágrafo") não precisam de todo o aparato — engenharia de prompt é investimento proporcional à importância e complexidade da tarefa.

---

## Prompt fraco vs. prompt estruturado

Um prompt vago deixa a IA **adivinhar** todas as decisões que você não tomou: linguagem, formato, regras de negócio, nível de detalhe.

Um prompt estruturado **transfere essas decisões para você**, de forma explícita — o que sobra para a IA decidir é só a implementação.

> Vamos ver isso na prática agora.

---

# 🎬 AGORA: Demonstração ao vivo 1

**Prompt fraco → prompt estruturado**, construindo o modelo de dados do SISPROT.

*(Instrutor: siga `roteiro-instrutor.md`, prompts em `prompts.md` §Demonstração 1)*

---

## Debrief da Demonstração 1

- O prompt fraco (`"cria um sistema de protocolo"`) devolveu algo genérico — a IA teve que adivinhar linguagem, campos, formato.
- O prompt estruturado, com os mesmos ~4 blocos, devolveu exatamente o schema e a conexão que o projeto precisa.
- **A IA não "ficou mais inteligente" entre um prompt e outro** — a diferença inteira está na informação que demos a ela.

---

## Anatomia de um prompt eficaz

Cinco blocos que, juntos, eliminam a maior parte da ambiguidade:

1. **Papel** — quem a IA deve "ser" ao responder
2. **Contexto** — o que ela precisa saber antes de agir
3. **Tarefa** — o que fazer, exatamente
4. **Restrições** — o que não fazer, ou os limites da resposta
5. **Formato** — como a resposta deve chegar

*(+ Exemplos, quando útil — vemos em few-shot, a seguir)*

---

## Bloco 1 · Papel (persona)

**O que é:** atribuir à IA uma identidade profissional específica (ex.: "desenvolvedor PHP sênior especialista em sistemas administrativos").

**Por que funciona:** ancora o vocabulário, o nível de detalhe e as convenções esperadas na resposta — um "especialista em sistemas administrativos" tende a lembrar de auditoria e histórico; um "desenvolvedor genérico" pode não pensar nisso.

**Erro comum:** personas genéricas demais ("você é um bom programador") não mudam nada no resultado — a persona só ajuda quando é específica ao domínio da tarefa.

---

## Bloco 2 · Contexto

**O que é:** a informação de fundo que a IA precisa para não "inventar" premissas — stack técnica, convenções já adotadas no projeto, arquivos existentes.

**Quando é crítico:** sempre que a tarefa evolui algo que já existe (não cria do zero) — sem contexto, a IA não sabe o que já foi decidido.

**Boa prática:** prefira contexto específico e verificável ("a tabela X tem os campos Y, Z") a descrições vagas ("já temos um sistema de protocolo").

---

## Bloco 3 · Restrições

**O que é:** limites explícitos — o que a IA **não** deve fazer.

**Por que é o bloco mais esquecido:** é fácil descrever o que se quer e esquecer de dizer o que não se quer — e o resultado tende a "passar dos limites" (reescrever código que já funcionava, usar uma biblioteca não desejada, criar autenticação que não foi pedida).

**Exemplo recorrente neste curso:** "não use frameworks", "sempre use prepared statements", "não altere nada que já funciona".

---

## Bloco 4 · Formato de saída

**O que é:** especificar exatamente como a resposta deve chegar (SQL antes do PHP, um arquivo por vez, nome do arquivo antes do código, etc.).

**Por que importa:** sem isso, cada execução do mesmo prompt pode vir organizada de um jeito diferente — dificultando revisão e automação.

**Boa prática:** quanto mais a resposta for usada por um processo (copiar e colar em arquivos específicos, por exemplo), mais vale a pena ser explícito sobre formato.

---

## Zero-shot prompting

**O que é:** pedir a tarefa diretamente, sem exemplos de como a resposta deve ficar — apenas a instrução.

**Quando funciona bem:** tarefas comuns, bem documentadas, onde o "estilo padrão" da IA já é aceitável.

**Limitação:** para convenções específicas do seu projeto (nomenclatura, padrão de validação, estilo de código já em uso), zero-shot tende a não replicar o padrão — é aqui que few-shot entra.

---

## Few-shot prompting

**O que é:** incluir no prompt um ou mais **exemplos concretos** do padrão de resposta esperado, antes de pedir o resultado novo.

**Por que funciona:** a IA imita o padrão do exemplo — nomenclatura, nível de comentários, estilo de validação — muito mais do que conseguiria adivinhar só pela descrição.

**Custo:** exemplos ocupam espaço no prompt (mais texto, mais contexto consumido). Vale a pena quando a consistência de estilo importa mais do que a brevidade do prompt.

---

## Zero-shot vs. few-shot — quando usar qual

| | Zero-shot | Few-shot |
|---|---|---|
| Tarefa genérica, sem convenção própria | ✅ | dispensável |
| Precisa seguir um padrão específico do projeto | ⚠️ arriscado | ✅ |
| Prompt precisa ser curto | ✅ | ⚠️ mais texto |
| Primeira vez pedindo algo (sem padrão ainda) | ✅ único caminho | — |

---

## XML Prompting

**O que é:** usar tags (`<papel>`, `<contexto>`, `<tarefa>`...) para delimitar, sem ambiguidade, onde cada seção do prompt começa e termina.

**Quando vale a pena:** prompts longos, ou que misturam texto explicativo com código/listas dentro de uma mesma seção — a tag deixa claro onde a seção acaba, mesmo que o conteúdo dela tenha quebras de linha, código ou marcadores.

**Limitação:** para prompts curtos e simples, é peso desnecessário.

---

## Markdown Prompting

**O que é:** usar a sintaxe Markdown (`##` para seções, listas, blocos de código) para a mesma finalidade — estruturar sem ambiguidade.

**Vantagem sobre XML:** mais familiar e mais rápido de escrever para quem já usa Markdown no dia a dia (READMEs, documentação).

**Quando XML tende a ganhar:** quando o conteúdo de uma seção já contém headers ou código Markdown — aí as tags XML evitam confusão sobre onde uma seção "de fato" termina.

---

## XML vs. Markdown — não é sintaxe mágica

O que resolve o problema é a **separação inequívoca de seções** — XML e Markdown são dois jeitos de conseguir isso, não fórmulas com poder próprio.

**Regra prática:** use o que sua equipe já lê com mais naturalidade. Para este curso, usamos os dois ao longo das aulas — o importante é a disciplina de estruturar, não a marcação escolhida.

---

# 🎬 AGORA: Demonstração ao vivo 2

**XML Prompting + Few-shot**, gerando o CRUD completo de protocolos.

*(Instrutor: prompts em `prompts.md` §Demonstração 2 — inclui a versão equivalente em Markdown, para comparar ao vivo)*

---

## Debrief da Demonstração 2

- O exemplo (few-shot) de estilo de validação foi replicado no código gerado — sem ele, o padrão poderia ter saído diferente.
- As tags XML deixaram claro onde a lista de restrições terminava e o formato começava — mesmo com múltiplos itens em cada bloco.
- Convertendo o mesmo prompt para Markdown, o resultado tende a ser equivalente — a estrutura é o que importa.

---

# ✏️ AGORA: Exercício 1

**Reescrever um prompt fraco** (individual · 25 min)

Prompt fraco fornecido: `"adiciona um campo de prioridade no protocolo"`

*(Enunciado completo em `exercicios.md` — soluções em `solucoes.md`, não mostrar antes)*

---

## Prompt Templates

**O que é:** um prompt reutilizável com **placeholders** (`{{CAMPO}}`) no lugar das partes que variam de uma tarefa para outra — papel, restrições e formato ficam fixos.

**Por que vale a pena:** tarefas repetitivas (adicionar um campo novo, criar um novo endpoint) não exigem reescrever a estrutura do zero a cada vez — só preencher as lacunas.

**Erro comum:** template genérico demais perde precisão; template específico demais deixa de ser reutilizável. O equilíbrio certo só se acha testando com mais de um caso.

---

## Técnicas para reduzir alucinação

- **Fornecer contexto completo** — a maior causa de alucinação é a IA preencher lacunas de informação com suposições.
- **Permitir explicitamente "não sei"** — peça que a IA sinalize incerteza em vez de inventar uma resposta confiante.
- **Pedir para citar a origem** — "baseado em qual parte do contexto você concluiu isso?" expõe raciocínio frágil.
- **Pedir verificação antes de responder** — "antes de responder, confirme se todas as informações necessárias estão no contexto fornecido."

---

## Técnicas para aumentar precisão

- **Exemplos concretos** (few-shot) em vez de descrições abstratas.
- **Formato de saída exato**, não "organize como preferir".
- **Decompor tarefas grandes** em pedidos menores e sequenciais.
- **Critérios de sucesso explícitos** — dizer como saber que a resposta está certa, não só o que fazer.

---

# ✏️ AGORA: Exercício 2

**Prompt template reutilvável** (dupla · 30 min)

Criar um template com placeholders e aplicá-lo para adicionar o campo `setor_origem`.

*(Enunciado completo em `exercicios.md` — soluções em `solucoes.md`)*

---

## Recapitulando: erros mais comuns de quem começa

| Erro | Consequência |
|---|---|
| Prompt sem restrições | IA "corrige" ou reescreve o que já funcionava |
| Persona genérica | Nenhuma mudança real no resultado |
| Sem formato de saída definido | Resultado difícil de aplicar/automatizar |
| Zero-shot quando havia um padrão a seguir | Inconsistência de estilo no projeto |
| Contexto incompleto | Alucinação — a IA "inventa" o que faltou |

---

# 🏆 AGORA: Desafio final

Adicionar **anexos** ao protocolo — prompt escrito do zero pelo aluno, aplicando ao menos 4 técnicas vistas hoje.

*(Critérios de sucesso em `desafio.md`)*

---

## Encerramento

Hoje: prompt vago → prompt estruturado → few-shot/zero-shot → XML/Markdown → templates → redução de alucinação.

**Na Aula 1:** essa estrutura passa a nascer de uma **especificação formal** (user story + critérios de aceitação) — Spec-Driven Development, aplicado ao fluxo de tramitação de protocolos entre setores.

---

# Perguntas?

Dúvidas comuns já respondidas em `faq.md`.
