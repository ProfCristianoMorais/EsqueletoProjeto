<!-- login.php -->
<?php
session_start();
include './config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE LOWER(email) = LOWER(?)");
    //$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        die("Usuário não encontrado!");}
    
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'email' => $usuario['email'],
                'perfil' => $usuario['perfil']
            ];
            
            // Redirecionamento por perfil
            switch($usuario['perfil']) {
                case 'admin':
                    header("Location: page_admin.php");
                    break;
                case 'vendedor':
                    header("Location: ./pages/page_vendedor.php");
                    break;
                default:
                    header("Location: ./pages/page_clientes.php");
            }
            exit();
        } else {
            $erro = "Credenciais inválidas!";
        }    
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include './includes/head.php'; ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>Projeto ETC</b>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <form method="POST">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="senha" placeholder="Senha" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                <?php if(isset($erro)): ?>
                    <div class="alert alert-danger mt-3"><?= $erro ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
</body>
</html>