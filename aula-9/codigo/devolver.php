<?php
require 'conexao.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare('UPDATE emprestimos SET data_devolucao = ? WHERE id = ?');
    $stmt->execute([date('Y-m-d'), $id]);
}
header('Location: index.php?msg=devolvido');
exit;
