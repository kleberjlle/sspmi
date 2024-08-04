
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-orange card-outline">
                <div class="card-header">
                    <h3 class="card-title">Protocolo n.º: <?php echo $protocolo; ?></h3>
                </div>
                <!-- form start -->
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>Data e Hora - Abertura</label>
                            <a class="float-left"><?php echo $dataAberturaTratada; ?></a>                                
                        </div>
                        <div class="form-group col-md-2">
                            <label>Data e Hora - Encerramento</label>
                            <a class="float-left"><?php echo $dataEncerramentoTratada; ?></a>
                        </div>
                        <!--
                        <div class="form-group col-md-4">
                            <i class="far fa-images mr-1"></i><b> Print</b>
                            <a class="float-right">
                                <img src="http://localhost/SSPMI/App/telas/suporte/img/2023000101.png" width="150px" height="100px" alt="..." data-toggle="modal" data-target="#modal-xl">
                                <img src="https://placehold.it/150x100" alt="...">
                            </a>
                        </div>
                        -->
                    </div>

                </div>
                <!-- /.card-body -->
                <form action="<?php echo $sConfiguracao->getDiretorioVisualizacaoAcesso(); ?>tPainel.php?menu=2_1_1" method="post" enctype="multipart/form-data" name="f1" id="f1">
                    <input type="hidden" value="f1" name="formulario" id="formulario" form="f1">
                    <input type="hidden" value="inserir" name="acao" id="inserir" form="f1">
                    <input type="hidden" value="menu2_1" name="pagina" id="menu2_1" form="f1">

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Próximo</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>