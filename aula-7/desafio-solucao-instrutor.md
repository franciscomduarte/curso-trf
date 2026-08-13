# Aula 7 · Demonstração final — material do instrutor (LLM local vs. nuvem)

> Mostrar somente na demonstração final, depois do tempo de execução do desafio. Material de apoio para você conduzir ao vivo — não distribuir à turma antes disso.

## Antes da aula

1. Se for demonstrar um modelo local: instale o [Ollama](https://ollama.com/) com antecedência (o instalador varia por sistema operacional) e baixe um modelo leve com antecedência, fora do horário de aula — o download pode levar tempo dependendo da conexão:
   ```
   ollama pull llama3
   ```
2. Confirme que `ollama run llama3` funciona e responde antes da aula começar.
3. Tenha à mão o acesso a uma IA em nuvem já usada no curso (Claude, ChatGPT, Gemini) para a comparação lado a lado.
4. Se não for possível instalar o Ollama a tempo (download grande, sem permissão de instalação na máquina do local do curso), pule para a seção "Alternativa sem instalação" abaixo.

## Roteiro da comparação ao vivo

> A tabela de comparação e a alternativa sem instalação já estão na própria aula (bloco "Demonstração final · Rodando um modelo local, ao vivo"). Aqui só o roteiro de comandos, que não faz sentido no material do aluno.

### Passo 1 — rodar local

```
ollama run llama3
```

No prompt interativo, colar:

```
Explique, em poucas frases, o que a função validarProtocolo() do SISPROT
faz e por que ela foi separada num arquivo próprio.
```

(Se `validacoes.php` já foi criado numa demonstração anterior — Aula 3 ou Aula 6 — cole o conteúdo real do arquivo antes da pergunta, para a resposta ser específica. Se não, a pergunta ainda funciona em termos gerais, sobre o padrão de "separar validação num arquivo próprio".)

### Passo 2 — rodar o mesmo prompt na nuvem

Mesma pergunta, na ferramenta de IA em nuvem já usada no curso.

## Pontos para comentar com a turma

- O ganho do modelo local não é "melhor resposta" — é "nenhum dado saiu da máquina". Isso não aparece na qualidade da resposta, só no que aconteceu (ou não) na rede.
- Vale fechar conectando à Portaria MGI nº 3.485/2026: parte do que ela exige é justamente essa avaliação de risco antes de escolher a ferramenta — não é burocracia isolada da prática técnica, é a mesma decisão que acabamos de tomar ao vivo, agora formalizada.
- Se algum aluno perguntar "então eu deveria sempre rodar tudo local?" — a resposta é não: para dado não sensível, a nuvem quase sempre compensa em qualidade e simplicidade. A escolha é por cenário, não uma regra fixa.
