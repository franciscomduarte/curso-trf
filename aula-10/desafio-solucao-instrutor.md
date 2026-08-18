# Aula 10 · Demonstração final — material do instrutor (fechando o curso, ao vivo)

> Mostrar somente na demonstração final, depois do tempo de execução do desafio. Material de apoio para você conduzir ao vivo — não distribuir à turma antes disso. Esta é a última demonstração do curso.

## Antes da aula

1. Confirme, com antecedência (a rede da sala pode ser mais lenta que a sua), que dá para autorizar pelo menos um servidor MCP remoto ao vivo — Notion ou GitHub, os dois já teriam sido conectados nos Exercícios 1 e 2 do Mão na massa, então a demonstração final pode reaproveitar uma dessas duas conexões em vez de abrir uma terceira.
2. Tenha um workspace de teste no Notion (ou um repositório de teste no GitHub) já preparado, com algum conteúdo simples — a demonstração pede para resumir "as últimas mudanças" de um repositório e documentar isso numa página nova, então precisa de algo real para resumir.
3. `claude mcp list` rodado antes de começar, para confirmar em voz alta, no início da demonstração, quais servidores já estão conectados da parte prática.

## Roteiro sugerido para a demonstração ao vivo

1. Rodar o prompt da Demonstração final (Etapa "Demonstração final" da aula): pedir para consultar o repositório de teste conectado, resumir as últimas mudanças, e criar uma página no Notion de teste documentando esse resumo, citando de onde veio cada informação.
2. Enquanto a IA trabalha, nomear em voz alta cada camada que está aparecendo na tela, na ordem em que aparecem:
   - Um **objetivo** dado em linguagem natural, não um roteiro de passos (Aula 9/10).
   - Uma **decisão** de qual ferramenta usar entre duas fontes diferentes — GitHub para o resumo, Notion para o registro (Etapa 2/3 desta aula).
   - **MCP** como o conector real fazendo a ponte com as duas ferramentas externas (Aula 9, Etapa 3-4, retomada nesta aula).
   - A **citação de fonte** que o prompt pediu explicitamente — é o mesmo hábito de verificação ensinado desde as primeiras aulas, agora aplicado a um agente que age sozinho, não só responde.
3. Depois que a IA terminar, abrir o Notion manualmente e mostrar a página criada de verdade — o mesmo princípio de "conferir com os próprios olhos, não confiar porque a IA disse que funcionou" de todos os exercícios anteriores do curso.
4. Se sobrar tempo, perguntar à turma: "como vocês saberiam se esse resumo está bom, sem ler o repositório inteiro de novo?" — gancho direto para a Etapa 6 (avaliação automática), a última peça conceitual da aula.

## Pontos para fechar o curso

- Da Aula 0 (um prompt bem escrito, sem IA agindo sozinha) até aqui (uma IA que decide, age através de ferramentas reais, e — com as seis peças desta aula — pode lembrar, ser observada e ser avaliada sem alguém checando cada resposta), a pergunta central nunca mudou: como confirmar que o que a IA produziu, ou fez, é bom de verdade, não só parece.
- As ferramentas específicas citadas nesta aula (Notion, GitHub, um Postgres específico) vão mudar — algumas já mudaram durante a própria preparação deste material (o pacote local da Notion sendo descontinuado em favor do servidor remoto; o servidor de referência do Postgres arquivado por uma vulnerabilidade real). O que não muda é o hábito: verificar antes de conectar, medir antes de confiar, manter uma pessoa no controle da decisão que importa.
- Se a turma perguntar "e agora, depois do curso?" — os pontos de partida honestos são: `aula-agentes/` (dois agentes Python reais, sem framework, para quem quer entender o mecanismo por dentro antes de usar MCP) e a lista de "próximas evoluções" que virou esta própria Aula 10 — o processo de pegar uma lista de próximos passos e transformá-la em aprendizado real é, em si, um exemplo do que o curso tentou ensinar o tempo todo.
