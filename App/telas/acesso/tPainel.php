<?php
session_start();
echo $_SESSION['credencial']['nome'];

//verifica a opção de menu
isset($_GET['menu']) ? $menu = $_GET['menu'] : $menu = "0";
//verifica se há retorno de notificações
if (isset($_GET['notificacao'])) {
    $notificacao = $_GET['notificacao'];
    $codigo = notificacao($notificacao);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SSPMI</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../../../vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
        <!-- pace-progress -->
        <link rel="stylesheet" href="../../../vendor/almasaeed2010/adminlte/plugins/pace-progress/themes/black/pace-theme-flat-top.css">
        <!-- adminlte-->
        <link rel="stylesheet" href="../../../vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="../../../vendor/almasaeed2010/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="../../../vendor/almasaeed2010/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="../../../vendor/almasaeed2010/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    </head>
    <body class="hold-transition sidebar-mini pace-primary">
        <!-- Site wrapper -->
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>                
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Navbar Search -->
                    <li class="nav-item">                        
                        <div class="navbar-search-block">
                            <form class="form-inline">
                                <div class="input-group input-group-sm">
                                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-navbar" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                    <!-- Notifications Dropdown Menu -->

                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-bell"></i>
                            <span class="badge badge-warning navbar-badge">15</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-item dropdown-header">15 Notificações</span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-receipt mr-2"></i> 4 novos tickets
                                <span class="float-right text-muted text-sm">3 minutos</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-comment mr-2"></i> 8 novas mensagens
                                <span class="float-right text-muted text-sm">12 horas</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-file mr-2"></i> 3 novos relatórios
                                <span class="float-right text-muted text-sm">2 dias</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="tNotificacoes.html" class="dropdown-item dropdown-footer">Ver todas as notificações</a>
                        </div>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="../../sistema/acesso/sSair.php">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="badge badge-warning navbar-badge"></span>
                        </a>                        
                    </li>

                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="../../../vendor/almasaeed2010/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="tPainel.php?menu=0" class="d-block">
                            <?php
                            if($_SESSION['email'] == 'usuario@gmail.com'){
                                echo 'Fictício(a)';
                            }else if($_SESSION['email'] == 'tecnico@gmail.com'){
                                echo 'Técnico(a)';
                            }else if($_SESSION['email'] == 'coordenador@gmail.com'){
                                echo 'Coordenador(a)';
                            }else if($_SESSION['email'] == 'diretor@gmail.com'){
                                echo 'Diretor(a)';
                            }else{
                                echo 'Administrador';
                            }
                            ?>
                            </a>
                        </div>
                    </div>
                    <!-- Sidebar Menu -->

                    <!--MENU-->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                                 with font-awesome or any other icon font library -->
                            <?php
                                $menu == '1_1' || $menu == '1_1_1' || $menu == '1_2' ? $atributo = ' menu-is-opening menu-open' : $atributo = '';
                            
                                //INÍCIO DO CABEÇALHO DO MENU 1
                                echo <<<HTML
                                <li class="nav-item $atributo">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-id-card"></i>
                                    <p>
                                        Perfil
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <!--FINAL DO CABEÇALHO DO MENU 1-->
                                
                                <!--INÍCIO DO SUBMENU 1_1-->
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
HTML;
                                $menu == '1_1' || $menu == '1_1_1' ? $atributo = ' active' : $atributo = '';
                            
                                echo <<<HTML
                                        <a href="tPainel.php?menu=1_1" class="nav-link $atributo">
                                            <p>Meus dados</p>
                                        </a>
                                    </li>
                                </ul>
                                <!--FINAL DO SUBMENU 1_1-->
                                
                                <!--INÍCIO DO SUBMENU 1_2-->                                   
HTML;
                                if ($_SESSION['permissao'] > 1) {
                                    $menu == '1_2' ? $atributo = ' active' : $atributo = '';

                                    echo <<<HTML
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="tPainel.php?menu=1_2" class="nav-link $atributo"> 
                                                <p>Outros Usuários</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!--FINAL DO SUBMENU 1_2-->
                            
                                <!--INÍCIO DO MENU2-->
HTML;
                                }
                                
                                if($_SESSION['permissao']){
                                $menu == '2_1' || $menu == '2_1_1' || $menu == '2_1_2' || $menu == '2_2' || $menu == '2_2_1' || $menu == '2_2_2' ? $atributo = ' menu-is-opening menu-open' : $atributo = '';           
                                
                                echo <<<HTML
                                <li class="nav-item $atributo">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-tools"></i>
                                        <p>
                                            Suporte
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <!--FINAL DO MENU 2-->
                                        
                                    <!--INÍCIO DO SUBMENU 2_1-->
                                    <ul class="nav nav-treeview">
                                <li class="nav-item">
HTML;
                                $menu == '2_1' || $menu == '2_1_1' || $menu == '2_1_2' ? $atributo = ' active' : $atributo = '';
                                
                                echo <<<HTML
                                        <a href="tPainel.php?menu=2_1" class="nav-link $atributo">
                                            <p>Solicitar</p>
                                        </a>
                                    </li>
                                </ul>
                                <!--FINAL DO SUBMENU 2_1-->
                                        
                                <!--INÍCIO DO SUBMENU 2_2-->
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
HTML;
                                $menu == '2_2' || $menu == '2_2_1' || $menu == '2_2_2' ? $atributo = ' active' : $atributo = '';
                                
                                echo <<<HTML
                                        <a href="tPainel.php?menu=2_2" class="nav-link $atributo">
                                            <p>Acompanhar</p>
                                        </a>
                                    </li>
                                </ul>                                
                            </li>
                            <!--FINAL DO SUBMENU 2_2-->
                            <!--FINAL DO MENU 2-->
                                        
                            <!--INÍCIO DO MENU3-->
HTML;
                                            }
                            if($_SESSION['permissao'] > 1){
                                $menu == '3_1' || $menu == '3_1_1' || $menu == '3_2' || $menu == '3_2_1' ? $atributo = ' menu-is-opening menu-open' : $atributo = '';
                                echo <<<HTML
                                <!--INÍCIO DO CABEÇALHO DO MENU 3-->
                                <li class="nav-item $atributo">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-keyboard"></i>
                                    <p>
                                        Equipamento
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <!--FINAL DO CABEÇALHO DO MENU 3-->
                                        
                                <!--INÍCIO DO SUBMENU 3_1-->
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
HTML;
                                $menu == '3_1' || $menu == '3_1_1' ? $atributo = ' active' : $atributo = '';
                                
                                echo <<<HTML
                                        <a href="tPainel.php?menu=3_1" class="nav-link $atributo">
                                            <p>Registrar</p>
                                        </a>
                                    </li>
                                </ul>
                                <!--FINAL DO SUBMENU 3_1-->
                                    
                                <!--INÍCIO DO SUBMENU 3_2-->
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
HTML;
                                $menu == '3_2' || $menu == '3_2_1' ? $atributo = ' active' : $atributo = '';
                                
                                echo <<<HTML
                                        <a href="tPainel.php?menu=3_2" class="nav-link $atributo">
                                            <p>Alterar</p>
                                        </a>
                                    </li>
                                </ul>
                                <!--FINAL DO SUBMENU 3_2-->
                                
                                <!--INÍCIO DO SUBMENU4-->
HTML;
                            }
                                if($_SESSION['permissao'] > 1){
                                $menu == '4_1' || $menu == '4_2' ? $atributo = ' menu-is-opening menu-open' : $atributo = '';
                                
                                echo <<<HTML
                                <li class="nav-item $atributo">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-building"></i>
                                    <p>
                                        Local
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <!--FINAL DO CABEÇALHO DO MENU 4-->
                                        
                                <!--INÍCIO DO SUBMENU 4_1-->
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
HTML;
                                
                                $menu == '4_1' ? $atributo = ' active' : $atributo = '';
                                
                                echo <<<HTML
                                        <a href="tPainel.php?menu=4_1" class="nav-link $atributo">
                                            <p>Registrar</p>
                                        </a>
                                    </li>
                                </ul>
                                <!--FINAL SUBMENU 4_1-->
                                        
                                <!--SUBMENU 4_2-->
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
HTML;
                                $menu == '4_2' ? $atributo = ' active' : $atributo = '';
                                
                                echo <<<HTML
                                        <a href="tPainel.php?menu=4_2" class="nav-link $atributo">
                                            <p>Alterar</p>
                                        </a>
                                    </li>
                                </ul>                                
                            </li>
                            <!--FINAL DO SUBMENU 4_2-->                                        
                            <!--FINAL DO SUBMENU 4-->          
                                
                            <!--INÍCIO DO MENU5-->
HTML;
                                }
                                if($_SESSION['permissao'] > 1){
                                $menu == '5_1' || $menu == '5_2' ? $atributo = ' menu-is-opening menu-open' : $atributo = '';
                            
                                echo <<<HTML
                                <li class="nav-item $atributo">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-briefcase"></i>
                                    <p>
                                        Cargo
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <!--FINAL CABEÇALHO MENU 5-->
                                        
                                <!--SUBMENU 5_1-->
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">                                
HTML;
                                $menu == '5_1' ? $atributo = ' active' : $atributo = '';
                                
                                echo <<<HTML
                                        <a href="tPainel.php?menu=5_1" class="nav-link $atributo">
                                            <p>Registrar</p>
                                        </a>
                                    </li>
                                </ul>
                                <!--FINAL SUBMENU 5_1-->
                                        
                                <!--SUBMENU 5_2-->
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
HTML;
                                $menu == '5_2' ? $atributo = ' active' : $atributo = '';
                                
                                echo <<<HTML
                                        <a href="tPainel.php?menu=5_2" class="nav-link $atributo">
                                            <p>Alterar</p>
                                        </a>
                                    </li>
                                </ul>
                                <!--FINAL SUBMENU 5_2-->
                                <!--FINAL DO MENU 5-->
                                        
                                <!--MENU6-->
                                
HTML;
                                }
                                if($_SESSION['permissao'] > 4){
                                $menu == '6_1' ? $atributo = ' menu-is-opening menu-open' : $atributo = '';
                                
                                echo <<<HTML
                                <li class="nav-item $atributo">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>
                                        Configuração
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <!--FINAL CABEÇALHO MENU 6-->
                                        
                                <!--SUBMENU 6_1-->
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
HTML;
                                $menu == '6_1' ? $atributo = ' active' : $atributo = '';
                                
                                echo <<<HTML
                                        <a href="tPainel.php?menu=6_1" class="nav-link $atributo">
                                            <p>Menu</p>
                                        </a>
                                    </li>
                                </ul>
                                <!--FINAL SUBMENU 6_1-->
                                <!--FINAL DO MENU 6-->
HTML;
                                }
                            ?>            
                            </li>
                        </ul>
                    </nav>
                    <!--FINAL DO MENU-->
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                </section>

                <!-- Main content -->
                <section class="content">
<?php
//configura tela de acesso
switch ($menu) {
    //início
    case "0":
        require_once './tInicio.php';
        break;
    //menu 1
    case "1_1":
        require_once './tMenu1_1.php';
        break;
    case "1_1_1":
        require_once './tMenu1_1_1.php';
        break;
    case "1_2":
        require_once './tMenu1_2.php';
        break;
    //menu 2
    case "2_1":
        require_once '../suporte/tMenu2_1.php';
        break;
    case "2_1_1":
        require_once '../suporte/tMenu2_1_1.php';
        break;
    case "2_1_2":
        require_once '../suporte/tMenu2_1_2.php';
        break;
    case "2_2":
        require_once '../suporte/tMenu2_2.php';
        break;
    case "2_2_1":
        require_once '../suporte/tMenu2_2_1.php';
        break;
    case "2_2_2":
        require_once '../suporte/tMenu2_2_2.php';
        break;
    case "3_1":
        require_once '../suporte/tMenu3_1.php';
        break;
    //menu 3
    case "3_1_1":
        require_once '../suporte/tMenu3_1_1.php';
        break;
    case "3_2":
        require_once '../suporte/tMenu3_2.php';
        break;
    case "3_2_1":
        require_once '../suporte/tMenu3_2_1.php';
        break;
    //menu 4
    case "4_1":
        require_once '../suporte/tMenu4_1.php';
        break;
    case "4_2":
        require_once '../suporte/tMenu4_2.php';
        break;
    case "4_2_1":
        require_once '../suporte/tMenu4_2_1.php';
        break;
    //menu 5
    case "5_1":
        require_once '../suporte/tMenu5_1.php';
        break;
    case "5_2":
        require_once '../suporte/tMenu5_2.php';
        break;
    case "5_2_1":
        require_once '../suporte/tMenu5_2_1.php';
        break;
    //menu 6
    case "6_1":
        require_once './tMenu6_1.php';
        break;
    case "6_2":
        require_once './tMenu6_2.php';
        break;
    //padrão
    default:
        require_once '../acesso/tInicio.php?notificacao=E2';
        break;
}
?>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <footer class="main-footer">
                <div class="float-right d-none d-sm-block">
                    <b>Versão</b> 3.12.0-dev
                </div>
                <strong>Copyright &copy; <a href="https://www.itapoa.sc.gov.br">Prefeitura de Itapoá</a>.</strong> Todos os direitos reservados.
            </footer>

            <!--Control Sidebar-->
            <aside class = "control-sidebar control-sidebar-dark">
                <!--Control sidebar content goes here-->
            </aside>
            <!--/.control-sidebar-->
        </div>
        <!--./wrapper-->
        
        
        
        

        <!--jQuery-->
        <script src = "../../../vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="../../../vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- pace-progress -->
        <script src="../../../vendor/almasaeed2010/adminlte/plugins/pace-progress/pace.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../../../vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
        <!-- DataTables  & Plugins -->
        <script src="../../../vendor/almasaeed2010/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../../../vendor/almasaeed2010/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="../../../vendor/almasaeed2010/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../../../vendor/almasaeed2010/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="../../../vendor/almasaeed2010/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="../../../vendor/almasaeed2010/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="../../../vendor/almasaeed2010/adminlte/plugins/jszip/jszip.min.js"></script>
        <script src="../../../vendor/almasaeed2010/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
        <script src="../../../vendor/almasaeed2010/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
        <script src="../../../vendor/almasaeed2010/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="../../../vendor/almasaeed2010/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="../../../vendor/almasaeed2010/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
        <!-- Page specific script -->
        <script>
            $(function () {
                $("#tabelaMenu1_2").DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#tabelaMenu1_2_wrapper .col-md-6:eq(0)');
                $("#tabelaMenu2_1").DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#tabelaMenu2_1_wrapper .col-md-6:eq(0)');
            });
        </script>
        
    </body>
</html>