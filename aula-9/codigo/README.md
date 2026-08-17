# Aula 9 · SISPROT (estado ao final da Aula 8 + relatório novo)

Cópia do SISPROT (PHP + MySQL/PDO) no estado da Aula 8, com um arquivo novo desta aula: `relatorio.php`, listando quantos protocolos cada requerente já abriu — implementado de propósito com um problema N+1, para servir de exemplo real na Etapa 1.

## Arquivos desta aula

- `relatorio.php` — o relatório novo, versão inicial (com N+1). Link adicionado em `index.php`.
- `bench_n1.php` — script isolado que gerou os números reais citados na Etapa 1 (81 consultas → 1, 8,1x mais rápido). Roda com `php bench_n1.php`, sem precisar de MySQL — usa SQLite em memória (`pdo_sqlite`, extensão padrão do PHP) só para medir a proporção do problema, não para representar o ambiente de produção do SISPROT (que continua sendo MySQL, como as aulas anteriores).

## Como reproduzir a medição

```
php bench_n1.php
```

Gera 2.000 protocolos fictícios entre 80 requerentes, roda a versão N+1 e a versão com `GROUP BY`, e imprime o número de consultas e o tempo de cada uma, além de conferir se os dois resultados batem.

## Achado real ao preparar este material

`protocolo_form.php`, linha 62, reflete `$id` (vindo de `$_GET`/`$_POST`) na saída HTML sem `htmlspecialchars()` nem conversão para inteiro — um XSS refletido real, não um bug plantado. Deixado como está de propósito, para o Exercício 2 do Mão na massa (Aula 9) poder encontrar isso com a ajuda de um servidor MCP de arquivos. Detalhes em `../desafio-solucao-instrutor.md`.
