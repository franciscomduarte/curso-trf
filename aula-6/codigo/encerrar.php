<?php
require 'conexao.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("UPDATE protocolos SET status = 'Arquivado' WHERE id = ?");
    $stmt->execute([$id]);
}
header('Location: index.php?msg=encerrado');
exit;
