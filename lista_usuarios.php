<?php
include './config/config.php';


// Processar cadastro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $perfil = $_POST['perfil'];
    

    $sql = "INSERT INTO usuarios (nome, email, perfil) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $perfil]);

    header("Location: lista_usuarios.php");
    exit();
}

// Buscar clientes cadastrados no nosso banco de dados projetoetc_v02
$usuarios = $pdo->query("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php include './includes/head.php';?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include './includes/navbar.php';?>
    <?php include './includes/sidebar.php'; ?>

    <div class="content-wrapper">
        
                <!-- Listagem de Clientes -->
                <div class="card">
                    <div class="card-header"><h2>Usuários Cadastrados</h2></div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Perfil</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <tr>
                                        <td><?= $usuario['id'] ?></td>
                                        <td><?= $usuario['nome'] ?></td>
                                        <td><?= $usuario['email'] ?></td>
                                        <td><?= $usuario['perfil'] ?></td>                                        
                                        <td>
                                            <!-- Preciso ajustar para modificar e excluir os usuarios -->
                                            <a href="editar_cliente.php?id=<?= $usuario['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                            <a href="excluir_cliente.php?id=<?= $usuario['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>
    </div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
</body>
</html>
