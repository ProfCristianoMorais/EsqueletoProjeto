<?php
//Inicia nossa sessão e mostra o nome do usuário no canto direito
session_start();
include './config/config.php';


//Crio variável para Contagem de clientes e produtos e usuários
$totalClientes = $pdo->query("SELECT COUNT(*) FROM clientes")->fetchColumn();
$totalProdutos = $pdo->query("SELECT COUNT(*) FROM produtos")->fetchColumn();
$usuarios = $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <!-- include para incluir o Head -->
    <?php include './includes/head.php';?>
    <body class="hold-transition layout-fixed">
    <div class="wrapper">

    <!-- Navbar -->
    <?php include './includes/navbar.php';?>

    <!-- Sidebar -->
    <?php include './includes/sidebar.php';?>

    <!-- Conteúdo Principal -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
        </section>

        
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Card para Clientes -->
                    <div class="col-lg-6 col-12">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo $totalClientes; ?></h3>
                                <p>Clientes Cadastrados</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <a href="clientes.php" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- Card para mostra nossos Usuários cadastrados -->
                    <div class="col-lg-6 col-12">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo $usuarios; ?></h3>
                                <p>Usuários Cadastrados</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users-gear"></i>
                            </div>
                            
                        </div>
                    </div>

                    <!-- Card para mostra os produtos que temos cadastrados -->
                    <div class="col-lg-6 col-12">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?php echo $totalProdutos; ?></h3>
                                <p>Produtos Cadastrados</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-industry"></i>
                            </div>
                            <a href="produtos.php" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</div>

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
</html>
