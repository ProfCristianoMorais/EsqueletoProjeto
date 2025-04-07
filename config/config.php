<?php
$host = "localhost";
$user = "root"; // Altere se necessário
$pass = ""; // Altere se necessário
$dbname = "projetoetc_V02";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexão feita com sucesso!";
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
