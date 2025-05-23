<?php
include './config/config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: produtos.php");
    exit();
}

$id = (int)$_GET['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: produtos.php?sucesso=2");
} catch (PDOException $e) {
    die("Erro ao excluir: " . $e->getMessage());
}