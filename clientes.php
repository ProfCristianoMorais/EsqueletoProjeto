<?php
include './config/config.php';
require_once 'auth.php';

// Processar cadastro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    $sql = "INSERT INTO clientes (nome, email, telefone, endereco) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $telefone, $endereco]);

    header("Location: clientes.php");
    exit();
}

// Buscar clientes cadastrados no nosso banco de dados projetoetc_v02
$clientes = $pdo->query("SELECT * FROM clientes")->fetchAll(PDO::FETCH_ASSOC);
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
                <!-- Formulário de Cadastro -->
                <div class="card">
                    <div class="card-header">Novo Cliente</div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="text" name="telefone" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Endereço</label>
                                <textarea name="endereco" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </form>
                    </div>
                </div>

                <!-- Listagem de Clientes -->
                <div class="card">
                    <div class="card-header">Clientes Cadastrados</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Endereço</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clientes as $cliente): ?>
                                    <tr>
                                        <td><?= $cliente['id'] ?></td>
                                        <td><?= $cliente['nome'] ?></td>
                                        <td><?= $cliente['email'] ?></td>
                                        <td><?= $cliente['telefone'] ?></td>
                                        <td><?= $cliente['endereco'] ?></td>
                                        <td>
                                            <a href="editar_cliente.php?id=<?= $cliente['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                            <a href="excluir_cliente.php?id=<?= $cliente['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</a>
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
