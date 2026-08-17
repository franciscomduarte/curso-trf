<?php
require 'conexao.php';

// Relatório: quantos protocolos cada requerente já abriu.
$stmt = $pdo->query('SELECT DISTINCT requerente FROM protocolos ORDER BY requerente');
$requerentes = $stmt->fetchAll(PDO::FETCH_COLUMN);

$contagem = [];
foreach ($requerentes as $requerente) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM protocolos WHERE requerente = ?');
    $stmt->execute([$requerente]);
    $contagem[$requerente] = $stmt->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Relatório por Requerente · SISPROT</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container">
  <h1>Protocolos por requerente</h1>
  <table>
    <thead><tr><th>Requerente</th><th>Total de protocolos</th></tr></thead>
    <tbody>
      <?php foreach ($contagem as $requerente => $total): ?>
      <tr>
        <td><?= htmlspecialchars($requerente) ?></td>
        <td><?= (int)$total ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <p><a href="index.php">Voltar</a></p>
</div>
</body>
</html>
