# Aula 7 · Soluções de referência (Mão na massa)

> Exercícios de julgamento e reescrita, não de código — mesmo assim, mostrar só depois que o tempo de execução terminar.

---

## Exercício 1 — Reescrever um prompt com dado sensível "escondido"

### Documento de partida

`aula-7/documento-ficticio.txt` — um processo administrativo de licença médica, com a tarefa pedida no final do arquivo ("resumir este processo em um parágrafo... indicando apenas o tipo de licença e o prazo").

### O que deveria ser identificado

- **Nome, CPF, matrícula, endereço, telefone, e-mail**: dados pessoais comuns (Etapa 1) — nenhum é necessário para a tarefa (resumir tipo de licença e prazo).
- **Menção a "tratamento psiquiátrico continuado para transtorno depressivo" e ao "procedimento cirúrgico ortopédico"**: dado pessoal **sensível** (saúde, Art. 5º, II) — a categoria mais fácil de identificar aqui, mas ainda assim frequentemente esquecida se o aluno só procurar CPF/nome.
- **Menção à filiação ao "Sindicato dos Servidores Públicos Federais (SINDSEP-DF)"**: também dado pessoal **sensível** (filiação sindical, mesmo Art. 5º, II) — a categoria que mais passa despercebida; muita gente não associa "sindicato" a dado sensível.
- **Número do processo, setor de origem/atual, datas, status**: seguros para manter, não identificam ninguém sozinhos.

### Versão reescrita (referência)

```
Preciso de ajuda para resumir um processo de licença médica em um
parágrafo para o relatório mensal do setor de Perícia Médica,
indicando apenas o tipo de licença e o prazo.

Processo: 2026/007734
Setor atual: Perícia Médica
Tipo de licença: licença médica
Prazo: 30 dias
```

**O que discutir com a turma:**
- A tarefa (resumir tipo de licença e prazo) continua executável sem nome, CPF, endereço, diagnóstico específico ou filiação sindical — o relatório mensal não precisa de nenhum desses detalhes.
- Este documento tem **duas** categorias de dado sensível, não uma — vale perguntar à turma quantas elas encontraram antes de revelar a resposta. Quem só achou a menção a saúde não errou, mas não terminou o exercício.
- Note que "tipo de licença" (licença médica) foi mantido, mas o **diagnóstico específico** (depressão, cirurgia) não — a tarefa pedia o tipo, não o motivo clínico detalhado. É minimização aplicada dentro do próprio dado sensível, não só decisão de tudo-ou-nada.

---

## Exercício 2 — Local ou nuvem?

### Respostas de referência para os três cenários sugeridos

| Cenário | Decisão | Justificativa |
|---|---|---|
| Revisar um trecho de código genérico, sem dado de negócio | Nuvem | Nenhum dado sensível envolvido; a qualidade de um modelo de nuvem topo de linha compensa. |
| Resumir um processo com nomes reais de servidores | Local (ou nuvem com anonimização completa) | Nomes reais são dado pessoal; se não der para anonimizar sem perder o sentido do resumo, local é a opção mais segura. |
| Gerar 500 respostas por dia para um chatbot interno | Depende do volume e do dado: se o conteúdo for genérico, nuvem com um plano adequado ao volume; se envolver dado de servidores/cidadãos, vale considerar local para não escalar custo por token e risco ao mesmo tempo. | Volume alto muda a equação de custo, não só a de sensibilidade. |

**O que discutir com a turma:** a terceira linha é a mais aberta a debate de propósito — não existe resposta única, e é um bom gatilho para perguntar por que a turma escolheu o que escolheu, não só qual escolheu.
