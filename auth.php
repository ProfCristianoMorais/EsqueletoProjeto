<!-- O auth ainda não está funcionando ainda estou ajustando -->
<?php
session_start();


// Níveis de acesso do nosso sistema
$niveis = [
    'admin' => ['admin.php', 'clientes.php', 'produtos.php'],
    'vendedor' => ['vendedor.php', 'clientes.php'],
    'cliente' => ['cliente.php']
];

// Verifica se está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Verifica acesso à página atual
$pagina = basename($_SERVER['PHP_SELF']);
$perfil = $_SESSION['usuario']['perfil'];

if (!in_array($pagina, $niveis[$perfil])) {
    header("Location: acesso_negado.php");
    exit();
}
?>