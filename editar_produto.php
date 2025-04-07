<?php
include './config/config.php';

// Verifica ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: produtos.php");
    exit();
}

$id = (int)$_GET['id'];

// Busca produto
$produto = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$produto->execute([$id]);
$produto = $produto->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    header("Location: produtos.php");
    exit();
}

// Atualização
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = (float) str_replace(',', '.', $_POST['preco']);
    $estoque = (int)$_POST['estoque'];

    try {
        $sql = "UPDATE produtos SET nome=?, descricao=?, preco=?, estoque=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $descricao, $preco, $estoque, $id]);
        header("Location: produtos.php?sucesso=1");
    } catch (PDOException $e) {
        die("Erro ao atualizar: " . $e->getMessage());
    }
}

include './includes/head.php';
include './includes/navbar.php';
include './includes/sidebar.php';
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Editar Produto</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Editar Produto</h3>
                        </div>
                        <form method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Descrição</label>
                                    <textarea class="form-control" name="descricao" rows="3"><?= htmlspecialchars($produto['descricao']) ?></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Preço</label>
                                            <input type="text" class="form-control" name="preco" value="<?= number_format($produto['preco'], 2, ',', '') ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Estoque</label>
                                            <input type="number" class="form-control" name="estoque" value="<?= $produto['estoque'] ?>" min="0">
                                        </div>
                                    </div>
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

<?php include './includes/footer.php'; ?>