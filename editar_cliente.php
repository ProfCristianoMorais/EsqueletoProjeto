<?php
include './config/config.php';

// Verifica se o ID existe e é numérico
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: clientes.php");
    exit();
}

$id = (int)$_GET['id'];

// Busca o cliente
$cliente = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
$cliente->execute([$id]);
$cliente = $cliente->fetch(PDO::FETCH_ASSOC);

// Se não encontrar o cliente
if (!$cliente) {
    header("Location: clientes.php");
    exit();
}

// Processamento do POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    try {
        $sql = "UPDATE clientes SET nome=?, email=?, telefone=?, endereco=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $email, $telefone, $endereco, $id]);
        
        header("Location: clientes.php");
        exit();
    } catch (PDOException $e) {
        die("Erro ao atualizar: " . $e->getMessage());
    }
}

include './includes/head.php';
include './includes/navbar.php';
include './includes/sidebar.php';
?>

<!-- Conteúdo Principal -->
<div class="content-wrapper">
    <!-- Cabeçalho do Conteúdo -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Editar Usuário</h1>
        </div>
    </section>

    <!-- Conteúdo Principal -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Dados do Usuário</h3>
                        </div>
                        <form method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="nome" value="<?= htmlspecialchars($cliente['nome'] ?? '') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($cliente['email'] ?? '') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Telefone</label>
                                    <input type="text" class="form-control" name="telefone" value="<?= htmlspecialchars($cliente['telefone'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Endereço</label>
                                    <textarea class="form-control" name="endereco" rows="3"><?=htmlspecialchars($cliente['endereco'] ?? '') ?></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

