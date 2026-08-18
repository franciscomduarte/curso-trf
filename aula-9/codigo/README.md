# Aula 9 · EmprestaTI (Empréstimo de Equipamentos)

Sistema fictício novo desta aula (PHP + MySQL/PDO), usado nos exemplos de otimização e MCP — substitui o SISPROT como projeto de exemplo, especificamente para a Aula 9.

## Cenário

Um setor de TI controla o empréstimo de equipamentos (notebooks, projetores etc.) entre servidores: quem pegou, quando, e quando devolveu.

## Arquivos desta aula

- `schema.sql` — modelo de dados: `equipamentos` (o item físico) e `emprestimos` (cada retirada/devolução, ligada por chave estrangeira).
- `conexao.php`, `index.php`, `emprestimo_form.php`, `devolver.php` — CRUD básico, no mesmo padrão das demais aulas do curso.
- `relatorio.php` — quantos empréstimos cada equipamento já teve, implementado de propósito com um problema N+1, para servir de exemplo real na Etapa 1.
- `bench_n1.php` — script isolado que gerou os números reais citados na Etapa 1 (31 consultas → 1, ~2,9x mais rápido). Roda com `php bench_n1.php`, sem precisar de MySQL — usa SQLite em memória (`pdo_sqlite`, extensão padrão do PHP) só para medir a proporção do problema, não para representar o ambiente de produção (que continua sendo MySQL, como as demais aulas).

## Como reproduzir a medição

```
php bench_n1.php
```

Gera 2.000 empréstimos fictícios entre 30 equipamentos, roda a versão N+1 e a versão com `LEFT JOIN` + `GROUP BY`, e imprime o número de consultas e o tempo de cada uma, além de conferir se os dois resultados batem.

## Achados reais ao preparar este material

- `emprestimo_form.php`, no campo oculto `id` do formulário, reflete `$id` (vindo de `$_GET`/`$_POST`) na saída HTML sem `htmlspecialchars()` nem conversão para inteiro — um XSS refletido real, não um bug plantado. Deixado como está de propósito, para o Exercício 2 do Mão na massa (servidor MCP de arquivos) poder encontrar isso com a ajuda de uma IA conectada.
- `emprestimo_form.php` também não valida se a data prevista de devolução vem depois da data de retirada — outro bug real, deixado de propósito para o Exercício 4 do Mão na massa (issue do GitHub, via MCP).

Detalhes de cada um em `../desafio-solucao-instrutor.md` e `../solucoes.md`.
