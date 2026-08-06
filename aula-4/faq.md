# Aula 0 · Perguntas frequentes

**Preciso saber PHP avançado para acompanhar a aula?**
Não. O curso assume noções básicas de programação (variáveis, condicionais, funções). O foco é em como conversar com a IA para produzir o código, não em dominar PHP de antemão — mas entender o que o código gerado faz é parte do aprendizado, não um detalhe que se pode ignorar.

**A IA vai substituir o trabalho do desenvolvedor?**
Não é essa a proposta do curso. A IA acelera a produção de código, mas quem decide o que construir, valida se está correto e assume a responsabilidade pelo resultado continua sendo o desenvolvedor. Todo exercício da aula termina com "teste manualmente" por esse motivo.

**Posso usar ChatGPT ou Gemini em vez de Claude Code?**
Sim. As técnicas de engenharia de prompt desta aula (estrutura, XML/Markdown prompting, few-shot, templates) funcionam em qualquer ferramenta de IA baseada em modelos de linguagem. A diferença entre ferramentas gratuitas e pagas é tratada com profundidade na Aula 2 — hoje o foco é a técnica do prompt, não a ferramenta.

**E se a IA gerar um código que parece funcionar, mas está errado?**
Isso é esperado e é exatamente por isso que todo exercício desta aula termina em teste manual. Um prompt bem estruturado reduz a chance de erro, mas não elimina a necessidade de revisão humana — esse princípio atravessa o curso inteiro.

**Posso colar dados reais do meu setor para testar o SISPROT?**
Não. Use sempre dados fictícios nos exercícios e demonstrações — números de protocolo, nomes e assuntos inventados. Ferramentas de IA gratuitas, em especial, não devem receber dados reais ou sensíveis de processos administrativos.

**O que fazer se o prompt não der o resultado esperado na primeira tentativa?**
Isso não é falha do aluno — é o comportamento normal do processo. Releia o prompt e pergunte: falta contexto? A tarefa está ambígua? O formato de saída foi especificado? Refine um bloco por vez, em vez de reescrever tudo do zero.

**Por que usar XML ou Markdown no prompt, se dá para simplesmente explicar em texto corrido?**
Dá, e às vezes funciona bem para tarefas simples. Mas quando o prompt mistura contexto, exemplos de código e restrições no mesmo parágrafo, a IA pode confundir onde uma seção termina e outra começa. Tags e headers eliminam essa ambiguidade — o ganho aparece justamente nas tarefas mais complexas, como a da Demonstração 2.

**Vou usar esses mesmos prompts nas próximas aulas?**
Os prompts específicos, não — mas a técnica de estruturação (papel/contexto/tarefa/restrições/formato) é a base de tudo o que vem depois. Na Aula 1, essa estrutura passa a nascer de uma especificação formal (user story + critérios de aceitação) em vez de ser escrita "na mão" a cada vez.
