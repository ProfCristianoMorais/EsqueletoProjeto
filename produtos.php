<?php
include './config/config.php';
require_once 'auth.php';


// Cadastro de novo produto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = (float) str_replace(',', '.', $_POST['preco']);
    $estoque = (int)$_POST['estoque'];

    try {
        $sql = "INSERT INTO produtos (nome, descricao, preco, estoque) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $descricao, $preco, $estoque]);
        header("Location: produtos.php?sucesso=1");
    } catch (PDOException $e) {
        die("Erro ao cadastrar: " . $e->getMessage());
    }
}

// Busca todos os produtos
$produtos = $pdo->query("SELECT * FROM produtos ORDER BY data_cadastro DESC")->fetchAll(PDO::FETCH_ASSOC);



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
                <h1>Produtos</h1>
            </div>
        </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Novo Produto</h3>
                        </div>
                        <form method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="nome" required>
                                </div>
                                <div class="form-group">
                                    <label>Descrição</label>
                                    <textarea class="form-control" name="descricao" rows="3"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Preço</label>
                                            <input type="text" class="form-control" name="preco" pattern="^\d+([\,\.]\d{1,2})?$" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Estoque</label>
                                            <input type="number" class="form-control" name="estoque" min="0" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
                            </div>
                        </form>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Produtos Cadastrados</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Descrição</th>
                                        <th>Preço</th>
                                        <th>Estoque</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produtos as $produto): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($produto['nome']) ?></td>
                                        <td><?= htmlspecialchars($produto['descricao']) ?></td>
                                        <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                                        <td><?= $produto['estoque'] ?></td>
                                        <td>
                                            <a href="editar_produto.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="excluir_produto.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja excluir?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</div>

<?php include './includes/footer.php'; ?>
<!-- JS do AdminLTE 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

<!-- jQuery (necessário para o AdminLTE) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
// Inicializa o menu responsivo
$(function() {
    // Inicializa o PushMenu
    $('[data-widget="pushmenu"]').PushMenu('init');
    
    // Fecha o sidebar ao clicar em um link (mobile)
    $(document).on('click', '.sidebar a', function() {
        if ($(window).width() < 768) {
            $('body').removeClass('sidebar-open');
            $('.sidebar-overlay').hide();
        }
    });
    
    // Fecha o sidebar ao clicar no overlay
    $('.sidebar-overlay').click(function() {
        $('body').removeClass('sidebar-open');
        $(this).hide();
    });
});
</script>
</body>

