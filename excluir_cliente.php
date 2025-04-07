<?php
include './config/config.php';

$id = $_GET['id'];

$pdo->prepare("DELETE FROM clientes WHERE id = ?")->execute([$id]);

header("Location: clientes.php");
exit();
?>
