<?php
require 'conexao.php';

$id = $_GET['id'] ?? $_POST['id'] ?? null;
$equipamento_id = $servidor = '';
$data_retirada = date('Y-m-d');
$data_prevista_devolucao = date('Y-m-d', strtotime('+7 days'));
$erros = [];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM emprestimos WHERE id = ?');
    $stmt->execute([$id]);
    $emprestimo = $stmt->fetch();
    if ($emprestimo) {
        $equipamento_id = $emprestimo['equipamento_id'];
        $servidor = $emprestimo['servidor'];
        $data_retirada = $emprestimo['data_retirada'];
        $data_prevista_devolucao = $emprestimo['data_prevista_devolucao'];
    }
}

$equipamentos = $pdo->query('SELECT id, nome, patrimonio FROM equipamentos ORDER BY nome')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipamento_id = trim($_POST['equipamento_id']);
    $servidor = trim($_POST['servidor']);
    $data_retirada = trim($_POST['data_retirada']);
    $data_prevista_devolucao = trim($_POST['data_prevista_devolucao']);

    if ($equipamento_id === '') { $erros[] = 'Equipamento é obrigatório.'; }
    if ($servidor === '') { $erros[] = 'Servidor é obrigatório.'; }
    if (!DateTime::createFromFormat('Y-m-d', $data_retirada)) { $erros[] = 'Data de retirada inválida.'; }
    if (!DateTime::createFromFormat('Y-m-d', $data_prevista_devolucao)) { $erros[] = 'Data prevista de devolução inválida.'; }

    if (empty($erros)) {
        if ($id) {
            $stmt = $pdo->prepare('UPDATE emprestimos SET equipamento_id=?, servidor=?, data_retirada=?, data_prevista_devolucao=? WHERE id=?');
            $stmt->execute([$equipamento_id, $servidor, $data_retirada, $data_prevista_devolucao, $id]);
            header('Location: index.php?msg=editado');
        } else {
            $stmt = $pdo->prepare('INSERT INTO emprestimos (equipamento_id, servidor, data_retirada, data_prevista_devolucao) VALUES (?, ?, ?, ?)');
            $stmt->execute([$equipamento_id, $servidor, $data_retirada, $data_prevista_devolucao]);
            header('Location: index.php?msg=criado');
        }
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title><?= $id ? 'Editar' : 'Novo' ?> Empréstimo · EmprestaTI</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container">
  <h1><?= $id ? 'Editar empréstimo' : 'Novo empréstimo' ?></h1>

  <?php foreach ($erros as $erro): ?>
    <p class="erro"><?= htmlspecialchars($erro) ?></p>
  <?php endforeach; ?>

  <form method="post">
    <?php if ($id): ?><input type="hidden" name="id" value="<?= $id ?>"><?php endif; ?>
    <label>Equipamento<br>
      <select name="equipamento_id">
        <?php foreach ($equipamentos as $eq): ?>
        <option value="<?= $eq['id'] ?>" <?= $eq['id'] == $equipamento_id ? 'selected' : '' ?>><?= htmlspecialchars($eq['nome']) ?> (<?= htmlspecialchars($eq['patrimonio']) ?>)</option>
        <?php endforeach; ?>
      </select>
    </label><br>
    <label>Servidor<br><input type="text" name="servidor" value="<?= htmlspecialchars($servidor) ?>"></label><br>
    <label>Data de retirada<br><input type="date" name="data_retirada" value="<?= htmlspecialchars($data_retirada) ?>"></label><br>
    <label>Devolução prevista<br><input type="date" name="data_prevista_devolucao" value="<?= htmlspecialchars($data_prevista_devolucao) ?>"></label><br>
    <button type="submit">Salvar</button>
    <a href="index.php">Cancelar</a>
  </form>
</div>
</body>
</html>
