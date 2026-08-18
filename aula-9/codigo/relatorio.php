<?php
require 'conexao.php';

// Relatório: quantos empréstimos cada equipamento já teve.
$stmt = $pdo->query('SELECT id, nome FROM equipamentos ORDER BY nome');
$equipamentos = $stmt->fetchAll();

$contagem = [];
foreach ($equipamentos as $equipamento) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM emprestimos WHERE equipamento_id = ?');
    $stmt->execute([$equipamento['id']]);
    $contagem[$equipamento['nome']] = $stmt->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Relatório por Equipamento · EmprestaTI</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container">
  <h1>Empréstimos por equipamento</h1>
  <table>
    <thead><tr><th>Equipamento</th><th>Total de empréstimos</th></tr></thead>
    <tbody>
      <?php foreach ($contagem as $nome => $total): ?>
      <tr>
        <td><?= htmlspecialchars($nome) ?></td>
        <td><?= (int)$total ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <p><a href="index.php">Voltar</a></p>
</div>
</body>
</html>
