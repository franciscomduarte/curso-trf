<?php
require 'conexao.php';

$id = $_GET['id'] ?? $_POST['id'] ?? null;
$numero = $assunto = $requerente = '';
$data_abertura = date('Y-m-d');
$erros = [];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM protocolos WHERE id = ?');
    $stmt->execute([$id]);
    $protocolo = $stmt->fetch();
    if ($protocolo) {
        $numero = $protocolo['numero'];
        $assunto = $protocolo['assunto'];
        $requerente = $protocolo['requerente'];
        $data_abertura = $protocolo['data_abertura'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = trim($_POST['numero']);
    $assunto = trim($_POST['assunto']);
    $requerente = trim($_POST['requerente']);
    $data_abertura = trim($_POST['data_abertura']);

    if ($numero === '') { $erros[] = 'Número do protocolo é obrigatório.'; }
    if ($assunto === '') { $erros[] = 'Assunto é obrigatório.'; }
    if ($requerente === '') { $erros[] = 'Requerente é obrigatório.'; }
    if (!DateTime::createFromFormat('Y-m-d', $data_abertura)) { $erros[] = 'Data de abertura inválida.'; }

    if (empty($erros)) {
        if ($id) {
            $stmt = $pdo->prepare('UPDATE protocolos SET numero=?, assunto=?, requerente=?, data_abertura=? WHERE id=?');
            $stmt->execute([$numero, $assunto, $requerente, $data_abertura, $id]);
            header('Location: index.php?msg=editado');
        } else {
            $stmt = $pdo->prepare('INSERT INTO protocolos (numero, assunto, requerente, data_abertura, status) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$numero, $assunto, $requerente, $data_abertura, 'Aberto']);
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
<title><?= $id ? 'Editar' : 'Novo' ?> Protocolo · SISPROT</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container">
  <h1><?= $id ? 'Editar protocolo' : 'Novo protocolo' ?></h1>

  <?php foreach ($erros as $erro): ?>
    <p class="erro"><?= htmlspecialchars($erro) ?></p>
  <?php endforeach; ?>

  <form method="post">
    <?php if ($id): ?><input type="hidden" name="id" value="<?= $id ?>"><?php endif; ?>
    <label>Número do protocolo<br><input type="text" name="numero" value="<?= htmlspecialchars($numero) ?>"></label><br>
    <label>Assunto<br><input type="text" name="assunto" value="<?= htmlspecialchars($assunto) ?>"></label><br>
    <label>Requerente<br><input type="text" name="requerente" value="<?= htmlspecialchars($requerente) ?>"></label><br>
    <label>Data de abertura<br><input type="date" name="data_abertura" value="<?= htmlspecialchars($data_abertura) ?>"></label><br>
    <button type="submit">Salvar</button>
    <a href="index.php">Cancelar</a>
  </form>
</div>
</body>
</html>
