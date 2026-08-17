<?php
require 'conexao.php';

$stmt = $pdo->query('SELECT * FROM protocolos ORDER BY data_abertura DESC');
$protocolos = $stmt->fetchAll();

$mensagem = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>SISPROT · Protocolos</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container">
  <h1>SISPROT · Protocolos Administrativos</h1>

  <?php if ($mensagem === 'criado'): ?>
    <p class="sucesso">Protocolo registrado com sucesso.</p>
  <?php elseif ($mensagem === 'editado'): ?>
    <p class="sucesso">Protocolo atualizado com sucesso.</p>
  <?php elseif ($mensagem === 'encerrado'): ?>
    <p class="sucesso">Protocolo arquivado com sucesso.</p>
  <?php endif; ?>

  <p><a class="btn" href="protocolo_form.php">+ Novo protocolo</a> <a href="relatorio.php">Relatório por requerente</a></p>

  <table>
    <thead>
      <tr><th>Número</th><th>Assunto</th><th>Requerente</th><th>Abertura</th><th>Status</th><th>Ações</th></tr>
    </thead>
    <tbody>
      <?php foreach ($protocolos as $p): ?>
      <tr>
        <td><?= htmlspecialchars($p['numero']) ?></td>
        <td><?= htmlspecialchars($p['assunto']) ?></td>
        <td><?= htmlspecialchars($p['requerente']) ?></td>
        <td><?= htmlspecialchars($p['data_abertura']) ?></td>
        <td><span class="status status-<?= strtolower($p['status']) ?>"><?= htmlspecialchars($p['status']) ?></span></td>
        <td>
          <a href="protocolo_form.php?id=<?= $p['id'] ?>">Editar</a>
          <?php if ($p['status'] !== 'Arquivado'): ?>
          &middot;
          <a href="encerrar.php?id=<?= $p['id'] ?>" onclick="return confirm('Arquivar este protocolo?');">Arquivar</a>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>
