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

---

## Exercícios A–H (quizzes de sequência, Etapas 1 e 2)

> Estes já revelam o gabarito na própria página (`aula-7/Aula_7_Dados_LLMs_Locais_e_Governanca.html`) quando o aluno digita a sequência correta. Reproduzidos aqui só para consulta rápida do instrutor, sem precisar abrir a página e testar cada um.

### Exercício A — Correlacionar oito campos (Etapa 1)

Legenda: **C** = comum · **S** = sensível · **N** = não é dado pessoal

**Sequência: `CSSNSNCS`**

| # | Item | Classificação |
|---|---|---|
| 1 | Telefone celular | C |
| 2 | Participação em culto religioso | S (religião) |
| 3 | Filiação sindical | S (sindicato) |
| 4 | Setor de tramitação | N |
| 5 | Impressão digital | S (biométrico) |
| 6 | Prioridade do protocolo | N |
| 7 | Nome da mãe | C |
| 8 | Exame de HIV | S (saúde) |

### Exercício B — Correlacionar um trecho curto (Etapa 1)

**Sequência: `CSSN`** — (a) nome/matrícula/CPF = C · (b) saúde mental = S · (c) testemunha de Jeová = S (religião) · (d) protocolo/setor isolados = N.

### Exercício C — Correlacionar a base legal (Etapa 1)

Legenda: **P** = política pública (Art. 7º, III) · **J** = exercício de direito em processo (Art. 7º, VI) · **S** = base para dado sensível (Art. 11)

**Sequência: `JPSJSP`** — (1) dados da parte no processo = J · (2) férias do servidor = P · (3) perícia médica = S · (4) dados da testemunha = J · (5) filiação sindical com consentimento = S · (6) pedido de certidão = P.

### Exercício D — Escolher a técnica certa (Etapa 2)

Legenda: **M** = minimizar · **A** = anonimizar · **F** = fica bem, nenhuma técnica necessária

**Sequência: `FMAFAM`** — (1) resumir norma pública = F · (2) formatação com CPF/endereço = M · (3) comparar grafia de nomes = A · (4) contar protocolos por status = F · (5) distinguir requerentes sem nomes reais = A · (6) e-mail com endereço desnecessário = M.

### Exercício E — Achar o erro em prompts prontos (Etapa 2)

Legenda: **O** = ok, sem problema · **E** = tem erro, precisa ajustar

**Sequência: `EOOEOE`** — (1) nome+CPF desnecessários = E · (2) só número do protocolo = O · (3) nome necessário para comparar grafia = O · (4) nome/CPF/endereço numa tabela de formatação = E · (5) só datas e status = O · (6) endereço/telefone completos desnecessários = E.

### Exercício F — Foi longe demais? (Etapa 2)

Legenda: **V** = viável, a tarefa ainda funciona · **Q** = quebrou, foi longe demais

**Sequência: `VQQVVQ`** — (1) remoção de nome/CPF numa formatação = V · (2) remoção do número do protocolo que o e-mail precisava citar = Q · (3) nome removido sem rótulo no lugar, quebrando a comparação = Q · (4) manteve só status para contar por status = V · (5) rótulos consistentes (Requerente 1/2) = V · (6) removeu o próprio campo "assunto" que a pergunta avaliava = Q.

### Exercício G — Reescrever anonimizando (Etapa 2)

Prompt de referência: mesma comparação de requerentes, mas com CPF removido (minimização) e números de protocolo trocados por rótulos A/B/C (anonimização) — nome e telefone permanecem porque são o que a tarefa precisa comparar. Texto completo já está no `<details>` "Ver versão de referência" da própria página.

### Exercício H — Reescrever anonimizando (2) (Etapa 2)

Mesma lógica do Exercício G, mas desta vez o **horário** de cada pedido precisa ser mantido (a tarefa depende de "curto espaço de tempo") — só CPF sai e os protocolos viram "Registro 1/2/3". Texto completo também já está no `<details>` da própria página.

---

## Desafio final — Checklist de governança para o SISPROT

> Também já disponível num `<details>` na própria página, ao final da seção "Desafio final".

Checklist de referência (8 itens, cada um rastreável à LGPD ou à Portaria MGI):

1. O campo identifica ou pode identificar uma pessoa? *(LGPD, Art. 5º, I)*
2. Se é dado pessoal, cai numa categoria sensível? *(LGPD, Art. 5º, II)*
3. A tarefa muda se eu tirar esse campo do prompt? *(LGPD, Art. 6º, III — necessidade)*
4. Dá para substituir por um rótulo/versão parcial sem quebrar a tarefa? *(Etapa 2 — anonimização)*
5. A ferramenta é nuvem de terceiro, ou local/homologada? *(Portaria MGI, Art. 16)*
6. Existe base legal específica para esse uso do dado? *(LGPD, Art. 7º/11)*
7. A resposta gera ação/decisão automática sem revisão humana? *(Portaria MGI, Art. 5º, III / 6º / 15, V)*
8. Dá para registrar depois que uma IA participou da tarefa? *(Portaria MGI, Art. 15, IV)*

Aplicação aos 3 campos pedidos no enunciado:

| Campo do SISPROT | Decisão | Por quê |
|---|---|---|
| Número do protocolo | Pode enviar | Não é dado pessoal (item 1) |
| Nome do requerente | Anonimizar antes | Dado pessoal comum; a maioria das tarefas não precisa do nome completo (item 3), mas quando precisa comparar pessoas, um rótulo resolve (item 4) |
| Histórico de tramitação (setor, data, status) | Pode enviar | Não identifica ninguém sozinho (item 1) |

**Critério de sucesso:** não existe um checklist "correto" único — o que importa é cada item ser verificável (sim/não) e rastreável até a LGPD ou a Portaria MGI, não bater exatamente com o modelo acima.
