<?php
require_once '../../sistema/acesso/sNotificacao.php';

//verifica a opção de menu
isset($_GET['menu']) ? $menu = $_GET['menu'] : $menu = "0";
//verifica se há retorno de notificações
if (isset($_GET['notificacao'])) {
    $notificacao = $_GET['notificacao'];
    $codigo = notificacao($notificacao);
}
//armazena os dados há serem alterados
isset($_GET['opcao']) ? $opcao = $_GET['opcao'] : $notificacao='E4'
?>
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Etapa 2 - Cargo/ Função</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- form start -->
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="patrimonio">Cargo</label>
                            <input type="text" class="form-control" id="nomenclatura" name="nomenclatura" value="<?php echo $opcao ?>" required="">
                        </div>
                        
                    </div>
                </div>
                <form action="../../sistema/suporte/sRegistrarCargo.php" id="cargo" method="post" enctype="multipart/form-data">
                    <!-- /.card-body-->
                    <div class="card-footer">
                        <input type="hidden" name="pagina" value="menu5_1">
                        <button type="submit" class="btn btn-primary">Alterar</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </div>    
    <div class="row">
        <div class="col-lg-12 col-12">
            <?php
            require_once '../../sistema/acesso/sNotificacao.php';

            if (isset($codigo)) {
                $mensagem = explode('|', $codigo);
                echo <<<HTML
                <div class="col-mb-3">
                    <div class="card card-outline card-{$mensagem[0]}">
                        <div class="card-header">
                            <h3 class="card-title">{$mensagem[1]}</h3>
                        </div>
                        <div class="card-body">
                            {$mensagem[2]}
                        </div>
                    </div>
                </div>
HTML;
            }
            ?>
        </div>
    </div>
</div>