<?php
require_once '../../sistema/acesso/sNotificacao.php';

//verifica a opção de menu
isset($_GET['menu']) ? $menu = $_GET['menu'] : $menu = "0";
//verifica se há retorno de notificações
if (isset($_GET['notificacao'])) {
    $notificacao = $_GET['notificacao'];
    $codigo = notificacao($notificacao);
}
?>
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Etapa 1 - Cargo/ Função</h3>
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Cargo/ Função</label>
                                <select class="form-control" required="" name="nomenclatura" form="cargo">
                                    <option selected="" disabled="">--</option>
                                    <option>Diretor</option>
                                    <option>Coordenador</option>
                                    <option>Agente Administrativo</option>
                                    <option>Técnico de Informática</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="../../sistema/suporte/sAlterarCargo.php" id="cargo" method="post" enctype="multipart/form-data">
                    <!-- /.card-body-->
                    <div class="card-footer">
                        <input type="hidden" name="pagina" value="menu5_2" form="cargo">
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