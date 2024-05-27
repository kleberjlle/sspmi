<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-orange card-outline">
                <div class="card-header">
                    <h3 class="card-title">Etapa 1 - Protocolo n.º: 20230001</h3>
                </div>
                <!-- form start -->
                <form action="../../sistema/suporte/sAlterarSuporte.php" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Prioridade</label>
                                    <select class="form-control" id="prioridade" name="prioridade" required="">
                                    <?php
                                    if($_SESSION['permissao'] == 4 || $_SESSION['permissao'] == 5){
                                        echo <<<HTML
                                        <option value="emergencia">Emergência</option>
                                        <option value="muitoUrgente" selected="">Muito Urgente</option>
                                        <option value="urgente">Urgente</option>
                                        <option value="alta">Alta</option>
                                        <option value="normal">Normal</option>
HTML;
                                        }
                                    if($_SESSION['permissao'] == 3){
                                        echo <<<HTML
                                        <option value="muitoUrgente" selected="">Muito Urgente</option>
                                        <option value="urgente">Urgente</option>
                                        <option value="alta">Alta</option>
                                        <option value="normal">Normal</option>
HTML;
                                        }
                                    if($_SESSION['permissao'] == 2){
                                        echo <<<HTML
                                        <option value="urgente">Urgente</option>
                                        <option value="alta">Alta</option>
                                        <option value="normal">Normal</option>
HTML;
                                        }
                                    if($_SESSION['permissao'] == 1){
                                        echo <<<HTML
                                        <option value="alta">Alta</option>
                                        <option value="normal">Normal</option>
HTML;
                                        }
                                        ?>                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Data e Hora - Solicitação</label>
                                <a class="float-left">22/12/2023 9:03</a>                                
                            </div>
                            <div class="form-group col-md-2">
                                <label>Data e Hora - Etapa 1</label>
                                <a class="float-left">23/12/2023 10:15</a>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="acessoRemoto">Acesso Remoto</label>
                                <input type="text" class="form-control" id="acessoRemoto" name="acessoRemoto" value="1 509 325">
                            </div>
                            <div class="form-group col-md-4">
                                <i class="far fa-images mr-1"></i><b> Print</b>
                                <a class="float-right">
                                    <img src="http://localhost/SSPMI/App/telas/suporte/img/2023000101.png" width="150px" height="100px" alt="..." data-toggle="modal" data-target="#modal-xl">
                                    <img src="https://placehold.it/150x100" alt="...">
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label>Descrição</label>
                                    <textarea class="form-control" rows="3" required="">Computador não liga</textarea>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Local</label>
                                    <select class="form-control" id="local" name="local" required="" <?php echo $_SESSION['permissao'] > 1 ? '' : 'disabled=\"\"' ?>>
                                        <option value="origem">Origem</option>
                                        <option value="prateleira" selected="">Prateleira</option>
                                        <option value="bancada1">Bancada 1</option>
                                        <option value="bancada2">Bancada 2</option>
                                        <option value="bancada3">Bancada 3</option>
                                        <option value="bancada4">Bancada 4</option>
                                        <option value="especializada">Especializada</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Ambiente</label>
                                    <select class="form-control" id="ambiente" name="ambiente" required="" <?php echo $_SESSION['permissao'] > 1 ? '' : 'disabled=\"\"' ?>>
                                        <option value="interno" selected="">Interno</option>
                                        <option value="externo">Externo</option>
                                    </select>
                                </div>
                            </div>
                            <!--se o perfil for de nível técnico mostrar na lista-->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Responsável</label>
                                    <select class="form-control" id="responsavel" name="responsavel" required="" <?php echo $_SESSION['permissao'] > 1 ? '' : 'disabled=\"\"' ?>>
                                        <option value="origem">Fernanda</option>
                                        <option value="prateleira" selected="">Kevin</option>
                                        <option value="bancada1">Lucas</option>
                                        <option value="bancada2">Sulmária</option>
                                        <option value="bancada3">Rafael</option>
                                        <option value="bancada4">Kleber</option>
                                        <option value="solicitante">Solicitante</option>
                                        <option value="selbetti">Selbetti</option>
                                        <option value="wonit">Wonit</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" value="2_2_2" name="pagina">
                        <button type="submit" class="btn btn-primary">Alterar</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>