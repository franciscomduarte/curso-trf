<?php
require 'conexao.php';

$stmt = $pdo->query('SELECT emprestimos.*, equipamentos.nome AS equipamento_nome FROM emprestimos JOIN equipamentos ON equipamentos.id = emprestimos.equipamento_id ORDER BY data_retirada DESC');
$emprestimos = $stmt->fetchAll();

$mensagem = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>EmprestaTI · Empréstimos</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container">
  <h1>EmprestaTI · Empréstimo de Equipamentos</h1>

  <?php if ($mensagem === 'criado'): ?>
    <p class="sucesso">Empréstimo registrado com sucesso.</p>
  <?php elseif ($mensagem === 'editado'): ?>
    <p class="sucesso">Empréstimo atualizado com sucesso.</p>
  <?php elseif ($mensagem === 'devolvido'): ?>
    <p class="sucesso">Devolução registrada com sucesso.</p>
  <?php endif; ?>

  <p><a class="btn" href="emprestimo_form.php">+ Novo empréstimo</a> <a href="relatorio.php">Relatório por equipamento</a></p>

  <table>
    <thead>
      <tr><th>Equipamento</th><th>Servidor</th><th>Retirada</th><th>Devolução prevista</th><th>Status</th><th>Ações</th></tr>
    </thead>
    <tbody>
      <?php foreach ($emprestimos as $e): ?>
      <tr>
        <td><?= htmlspecialchars($e['equipamento_nome']) ?></td>
        <td><?= htmlspecialchars($e['servidor']) ?></td>
        <td><?= htmlspecialchars($e['data_retirada']) ?></td>
        <td><?= htmlspecialchars($e['data_prevista_devolucao']) ?></td>
        <td><span class="status <?= $e['data_devolucao'] ? 'status-devolvido' : 'status-pendente' ?>"><?= $e['data_devolucao'] ? 'Devolvido' : 'Emprestado' ?></span></td>
        <td>
          <a href="emprestimo_form.php?id=<?= $e['id'] ?>">Editar</a>
          <?php if (!$e['data_devolucao']): ?>
          &middot;
          <a href="devolver.php?id=<?= $e['id'] ?>" onclick="return confirm('Registrar devolução deste equipamento?');">Devolver</a>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>
