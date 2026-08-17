# Aula 9 · Demonstração final — material do instrutor (otimizando o SISPROT ao vivo)

> Mostrar somente na demonstração final, depois do tempo de execução do desafio. Material de apoio para você conduzir ao vivo — não distribuir à turma antes disso.

## Antes da aula

1. `aula-9/codigo/` já é uma cópia do estado do SISPROT ao final da Aula 8, com `relatorio.php` (N+1, de propósito) e o link para ele em `index.php` adicionados nesta aula.
2. Confirme que `php -l` roda limpo nos arquivos antes de começar (já testado ao preparar este material — sem erros de sintaxe).
3. Terminal com `claude` rodando dentro da pasta `aula-9/codigo/`.
4. Se for demonstrar o servidor MCP de arquivos junto, rode `claude mcp add sisprot-arquivos -- npx -y @modelcontextprotocol/server-filesystem "."` com antecedência, dentro da pasta — a primeira execução do `npx` baixa o pacote, o que pode levar um instante numa rede mais lenta.

## O achado real que a preparação deste material revelou

Ao testar o Exercício 2 do Mão na massa (pedir à IA para achar arquivos sem `htmlspecialchars()`), apareceu um problema de verdade, não fabricado para o exercício: em `protocolo_form.php`, linha 62 —

```php
<?php if ($id): ?><input type="hidden" name="id" value="<?= $id ?>"><?php endif; ?>
```

`$id` vem direto de `$_GET['id'] ?? $_POST['id']` (linha 4), sem `htmlspecialchars()` nem conversão para inteiro. É um XSS refletido: `protocolo_form.php?id=1"><script>...` quebra o atributo `value`. `$id` é usado com segurança na consulta ao banco (via prepared statement, no SELECT da linha 10-11), mas nunca foi tratado na saída HTML — mostra que uma parte do código pode estar segura contra um tipo de ataque (SQL injection) e ainda vulnerável a outro (XSS).

**Isso não foi corrigido no código salvo em disco** — fica como está, de propósito, para o Exercício 2 do Mão na massa poder achar isso de verdade, não um bug plantado artificialmente. Se quiser fechar o ciclo ao vivo, a correção é trocar a linha por `value="<?= (int)$id ?>"` (já que `id` é sempre numérico) ou `value="<?= htmlspecialchars($id) ?>"`.

## Roteiro sugerido para a demonstração ao vivo

1. Deixe a turma escolher o alvo (`index.php`, uma extensão do `relatorio.php`, ou o próprio achado do XSS acima, se alguém já tiver encontrado no Exercício 2).
2. Passo 1 do prompt: pedir só a medição (contagem de consultas + tempo), sem otimizar.
3. Rodar, mostrar os números reais na tela.
4. Passo 2 do prompt: pedir a otimização, com o pedido explícito de manter o resultado idêntico.
5. Rodar de novo, comparar números e resultado.

## Pontos para comentar com a turma

- O ganho de tempo importa menos, nesta demonstração, que o hábito: sempre um "antes" registrado antes de qualquer mudança.
- Se a turma escolher discutir o achado do XSS: é o mesmo tipo de lição da Aula 6 (segurança não é "passou uma vez, está resolvido para sempre") — só que descoberto, desta vez, ao usar a própria IA com um servidor MCP conectado, não numa auditoria dedicada.
- Fechamento do curso até aqui: da Aula 0 (gerar) até a Aula 9 (medir, coordenar, conectar com critério), a mesma pergunta se repete em cada camada nova — como confirmar que o que a IA produziu (ou fez) é bom de verdade, não só parece.
