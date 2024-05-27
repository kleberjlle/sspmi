<?php
require_once '../../sistema/acesso/sNotificacao.php';

//verifica a opção de menu
isset($_GET['menu']) ? $menu = $_GET['menu'] : $menu = "0";
//verifica qual form está requisitando alteração
isset($_GET['opcao']) ? $opcao = $_GET['opcao'] : $opcao = '';
//verifica qual campo do form está requisitando alteração
isset($_GET['nomenclatura']) ? $nomenclatura = $_GET['nomenclatura'] : $nomenclatura = '';
        
?>
        
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <!--registro secretaria-->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?php echo $opcao; ?></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- form start -->                
                <div class="card-body">
                    <div class="row">                      
                        <div class="form-group col-md-2">
                            <label for="secretaria">Nomenclatura</label>
                            <input type="text" class="form-control" name="alterarLocal" value="<?php echo $nomenclatura; ?>" form="alterarLocal" required="">
                            <input type="hidden" value="<?php echo $opcao ?>" name="opcao" form="alterarLocal">
                        </div>
                    </div>
                </div>
                <form action="../../sistema/suporte/sAlterarLocal.php" method="post" id="alterarLocal" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" name="pagina" value="menu4_2_1">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>   
        <!-- /.card -->
    </div>
</div>