<?php
use App\sistema\acesso\{
    sConfiguracao,
};

$sConfiguracao = new sConfiguracao();
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
                        <div class="form-group col-md-2">
                            <label for="cargo">Cargo/ Função</label>
                            <input type="text" class="form-control" id="nomenclatura" name="nomenclatura" placeholder="Ex.: Diretor" required="" form="cargo">
                        </div>
                        
                    </div>
                </div>
                <?php
                    if(isset($tipo) && isset($titulo) && isset($email)){
                    echo <<<HTML
                    <div class="col-mb-3">
                        <div class="card card-outline card-{$tipo}">
                            <div class="card-header">
                                <h3 class="card-title">{$titulo}</h3>
                            </div>
                            <div class="card-body">
                                {$email}
                            </div>
                        </div>
                    </div>
HTML;
                    }       
                    ?>
                <form id="cargo" name="cargo" action="<?php echo $sConfiguracao->getDiretorioControleSuporte(); ?>sRegistrarCargo.php" method="post" enctype="multipart/form-data">
                    <!-- /.card-body-->
                    <div class="card-footer">
                        <input name="pagina" type="hidden" value="menu5_1">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>