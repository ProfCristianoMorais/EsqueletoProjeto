<?php
session_start();
include './config/config.php';


//Vamos iniciar as variaveis abaixo zeradas
$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $perfil = $_POST['perfil'];

    /**
     * Não podem ter dois emais iguais no sistema
     * Dessa forma tratamos com try catch os erros
    */
    try {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([strtolower($email)]);
        if ($stmt->rowCount() > 0) {
            $erro = "Este e-mail já está cadastrado!";
        }
    } catch (PDOException $e) {
        $erro = "Erro na verificação de e-mail: " . $e->getMessage();
    }

    // Aqui para cadastrar um usuário tem que seguir as regras de senha
    if (empty($erro)) {
        $requisitosSenha = [
            'mínimo 8 caracteres' => strlen($senha) >= 8,
            'pelo menos 1 letra maiúscula' => preg_match('/[A-Z]/', $senha),
            'pelo menos 1 letra minúscula' => preg_match('/[a-z]/', $senha),
            'pelo menos 1 número' => preg_match('/\d/', $senha),
            'pelo menos 1 caractere especial' => preg_match('/[\W_]/', $senha)
        ];

        if (in_array(false, $requisitosSenha, true)) {
            $erro = "Senha não atende aos requisitos:<br>";
            foreach ($requisitosSenha as $key => $value) {
                if (!$value) $erro .= "• " . $key . "<br>";
            }
        }
    }

    // Cadastra o usuário se não houver erros
    if (empty($erro)) {
        try {
            $sql = "INSERT INTO usuarios (nome, email, senha, perfil) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $nome,
                strtolower($email),
                /**Vamos usar a função password_hash para 
                 * criptografar a senha*/
                password_hash($senha, PASSWORD_BCRYPT),
                $perfil
            ]);
            $sucesso = "Usuário cadastrado com sucesso!";
        } catch (PDOException $e) {
            $erro = "Erro ao cadastrar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php include './includes/head.php';?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include './includes/navbar.php';?>
    <?php include './includes/sidebar.php'; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Clientes</h1>
            </div>
        </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-plus mr-2"></i>Novo Usuário</h3>
                        </div>
                        <form method="POST" id="formUsuario">
                            <div class="card-body">
                                <?php if($sucesso): ?>
                                    <div class="alert alert-success"><?= $sucesso ?></div>
                                <?php endif; ?>
                                
                                <?php if($erro): ?>
                                    <div class="alert alert-danger"><?= $erro ?></div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label>Nome Completo</label>
                                    <input type="text" class="form-control" name="nome" 
                                           value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" 
                                           required>
                                </div>

                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" name="email" 
                                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" 
                                           required>
                                </div>

                                <div class="form-group">
                                    <label>Senha</label>
                                    <input type="password" class="form-control" name="senha" 
                                           id="senha" required
                                           onkeyup="validarForcaSenha()">
                                    <small class="form-text text-muted">
                                        Requisitos:
                                        <ul id="requisitosSenha" class="list-unstyled">
                                            <li id="reqTamanho"><span class="text-danger">✗</span> Mínimo 8 caracteres</li>
                                            <li id="reqMaiuscula"><span class="text-danger">✗</span> 1 letra maiúscula</li>
                                            <li id="reqMinuscula"><span class="text-danger">✗</span> 1 letra minúscula</li>
                                            <li id="reqNumero"><span class="text-danger">✗</span> 1 número</li>
                                            <li id="reqEspecial"><span class="text-danger">✗</span> 1 caractere especial</li>
                                        </ul>
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label>Perfil de Acesso</label>
                                    <select class="form-control" name="perfil" required>
                                        <option value="">Selecione um perfil</option>
                                        <option value="admin" <?= ($_POST['perfil'] ?? '') == 'admin' ? 'selected' : '' ?>>Administrador</option>
                                        <option value="vendedor" <?= ($_POST['perfil'] ?? '') == 'vendedor' ? 'selected' : '' ?>>Vendedor</option>
                                        <option value="cliente" <?= ($_POST['perfil'] ?? '') == 'cliente' ? 'selected' : '' ?>>Cliente</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i>Cadastrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- AdminLTE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

<script>
function validarForcaSenha() {
    const senha = document.getElementById('senha').value;
    
    const requisitos = {
        reqTamanho: senha.length >= 8,
        reqMaiuscula: /[A-Z]/.test(senha),
        reqMinuscula: /[a-z]/.test(senha),
        reqNumero: /\d/.test(senha),
        reqEspecial: /[\W_]/.test(senha)
    };

    Object.keys(requisitos).forEach(id => {
        const elemento = document.getElementById(id);
        const icon = elemento.querySelector('span');
        if (requisitos[id]) {
            icon.className = 'text-success';
            icon.textContent = '✓';
        } else {
            icon.className = 'text-danger';
            icon.textContent = '✗';
        }
    });
}
// Fecha o sidebar automaticamente em telas pequenas após submit
$(document).ready(function() {
    // Inicializa o PushMenu do AdminLTE
    $('[data-widget="pushmenu"]').PushMenu('init');
    
    // Fecha o sidebar ao submeter o formulário (mobile)
    $('#formUsuario').on('submit', function() {
        if ($(window).width() < 768) {
            $('body').removeClass('sidebar-open');
            $('.main-sidebar').css('transform', 'translateX(-100%)');
            $('.sidebar-overlay').hide();
        }
    });
    
    // Fecha o sidebar ao clicar em links (mobile)
    $(document).on('click', '.sidebar a', function() {
        if ($(window).width() < 768) {
            $('body').removeClass('sidebar-open');
            $('.main-sidebar').css('transform', 'translateX(-100%)');
            $('.sidebar-overlay').hide();
        }
    });
});
</script>
</body>


