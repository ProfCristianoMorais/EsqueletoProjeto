<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Área do Brand com Logout -->
    <div class="brand-link d-flex justify-content-between align-items-center">
        <a href="page_admin.php" class="brand-text font-weight-light" style="color: white !important; margin-left: 15px;">
            Projeto ETC
        </a>
        <!-- Botão de logout visível apenas em desktop -->
        <a href="logout.php" class="btn btn-danger btn-sm mr-2 d-none d-md-inline" title="Sair">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="cadastro.php" class="nav-link">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>Cadastro de usuários</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="clientes.php" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Clientes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="produtos.php" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Produtos</p>
                    </a>
                </li>

                <!-- Menu de relatórios (Ainda esta com problemas para fechar) -->

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-pdf text-danger"></i>
                        <p>
                            Emitir Relatórios
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="gerar_relatorio.php?tipo=usuarios" class="nav-link" target="_blank">
                                <i class="nav-icon fas fa-user text-danger"></i>
                                <p>Usuários</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="gerar_relatorio.php?tipo=produtos" class="nav-link" target="_blank">
                                <i class="nav-icon fas fa-box text-danger"></i>
                                <p>Produtos</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="gerar_relatorio.php?tipo=clientes" class="nav-link" target="_blank">
                                <i class="nav-icon fas fa-users text-danger"></i>
                                <p>Clientes</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Menu de relatórios (Ainda esta com problemas para fechar) -->


                <!-- Botão de logout visível apenas em mobile -->
                <li class="nav-item d-md-none">
                    <a href="logout.php" class="nav-link text-danger">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Sair</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>


