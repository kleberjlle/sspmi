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
                    <h3 class="card-title">Etapa 1 - Equipamento</h3>
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
                        <div class="form-group col-md-1">
                            <label for="patrimonio">Patrimônio</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                            <input type="text" class="form-control" id="patrimonio" name="patrimonio" placeholder="Ex.: 20580">
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Categoria</label>
                                <select class="form-control" name="categoria">
                                    <option value="" selected="" >--</option>
                                    <option value="computador">Computador</option>
                                    <option value="monitor">Monitor</option>
                                    <option value="impressora">Impressora</option>
                                    <option value="scanner">Scanner</option>
                                </select>
                            </div>
                        </div>                            
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Marca</label>
                                <select class="form-control" name="marca">
                                    <option value="" selected="" >--</option>
                                    <option value="dell">Dell</option>
                                    <option value="positivo">Positivo</option>
                                    <option value="Lenovo">Lenovo</option>
                                    <option value="aoc">AOC</option>
                                    <option value="lg">LG</option>
                                </select>
                            </div>
                        </div>        
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Modelo</label>
                                <select class="form-control" name="modelo">
                                    <option value="" selected="" >--</option>
                                    <option value="optilex3000">OptiLex 3000</option>
                                    <option value="masterd40">Master D40</option>
                                    <option value="ideapad3">IdeaPad 3</option>
                                    <option value="hero27">Hero 27</option>
                                    <option value="24mk430h">24MK430H</option>
                                </select>
                            </div>
                        </div>  
                        <div class="form-group col-md-1">
                            <label for="serviceTag">Service Tag</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                            <input type="text" class="form-control" name="serviceTag" placeholder="Ex.: 5VPMLY3">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="numeroDeSerie">Número de Série</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                            <input type="text" class="form-control" name="numeroDeSerie" placeholder="Ex.: 8498732518">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="tensao">Tensão de Entrada</label>
                            <input type="text" class="form-control" name="tensao" placeholder="Ex.: 19V">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="corrente">Corrente de Entrada</label>
                            <input type="text" class="form-control" name="corrente" placeholder="Ex.: 3.42A">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="corrente">Sistema Operacional</label>
                            <input type="text" class="form-control" name="sistemaOpercaional" placeholder="Ex.: Windows 11">
                            <input type="hidden" value="equipamento" name="opcao" form="equipamento">
                            <input type="hidden" value="menu3_1" name="pagina" form="equipamento">
                        </div>
                    </div>
                </div>
                <form action="../../sistema/suporte/sRegistrarEquipamento.php" id="equipamento" method="post" enctype="multipart/form-data">
                    <!-- /.card-body-->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Próxima</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <div class="row">
        <!-- left column -->
        <div class="col-md-2">
            <!-- general form elements -->
            <div class="card card-outline card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Categoria</h3>
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
                        <div class="form-group col-md-12">
                            <label for="categoria">Nomenclatura</label>
                            <input type="text" class="form-control" name="categoria" placeholder="Ex.: Impressora">
                            <input type="hidden" value="categoria" name="opcao" form="categoria">
                            <input type="hidden" value="menu3_1" name="pagina" form="categoria">
                        </div>
                    </div>
                </div>
                <form action="../../sistema/suporte/sRegistrarEquipamento.php" method="post" id="categoria" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-2">
            <!-- general form elements -->
            <div class="card card-outline card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Marca</h3>
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
                        <div class="form-group col-md-12">
                            <label for="marca">Nomenclatura</label>
                            <input type="text" class="form-control" name="marca" placeholder="Ex.: Dell" form="marca">
                            <input type="hidden" value="marca" name="opcao" form="marca">
                            <input type="hidden" value="menu3_1" name="pagina" form="marca">
                        </div>
                    </div>
                </div>
                <form action="../../sistema/suporte/sRegistrarEquipamento.php" id="marca" method="post" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-2">
            <!-- general form elements -->
            <div class="card card-outline card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Modelo</h3>
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
                        <div class="form-group col-md-12">
                            <label for="modelo">Nomenclatura</label>
                            <input type="text" class="form-control" name="modelo" placeholder="Ex.: OptiLex 3000" form="modelo">
                            <input type="hidden" value="modelo" name="opcao" form="modelo">
                            <input type="hidden" value="menu3_1" name="pagina" form="modelo">
                        </div>
                    </div>
                </div>
                <form action="../../sistema/suporte/sRegistrarEquipamento.php" id="modelo" method="post" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-2">
            <!-- general form elements -->
            <div class="card card-outline card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Tensão de Entrada</h3>
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
                        <div class="form-group col-md-12">
                            <label for="tensao">Nomenclatura</label>
                            <input type="text" class="form-control" name="tensao" placeholder="Ex.: 19V">
                            <input type="hidden" value="tensaoDeEntrada" name="opcao" form="tensaoDeEntrada">
                            <input type="hidden" value="menu3_1" name="pagina" form="tensaoDeEntrada">
                        </div>
                    </div>
                </div>
                <form action="../../sistema/suporte/sRegistrarEquipamento.php" id="tensaoDeEntrada" method="post" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-2">
            <!-- general form elements -->
            <div class="card card-outline card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Corrente de Entrada</h3>
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
                        <div class="form-group col-md-12">
                            <label for="corrente">Nomenclatura</label>
                            <input type="text" class="form-control" name="correnteDeEntrada" placeholder="Ex.: 3,95A" form="correnteDeEntrada">
                            <input type="hidden" value="correnteDeEntrada" name="opcao" form="correnteDeEntrada">
                            <input type="hidden" value="menu3_1" name="pagina" form="correnteDeEntrada">
                        </div>
                    </div>
                </div>
                <form action="../../sistema/suporte/sRegistrarEquipamento.php" id="correnteDeEntrada" method="post" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-2">
            <!-- general form elements -->
            <div class="card card-outline card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Sistema Operacional</h3>
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
                        <div class="form-group col-md-12">
                            <label for="sistemaOperacional">Nomenclatura</label>
                            <input type="text" class="form-control" name="sistemaOperacional" placeholder="Ex.: Windows 11" form="sistemaOperacional">
                            <input type="hidden" value="sistemaOperacional" name="opcao" form="sistemaOperacional">
                            <input type="hidden" value="menu3_1" name="pagina" form="sistemaOperacional">
                        </div>
                    </div>
                </div>
                <form action="../../sistema/suporte/sRegistrarEquipamento.php" id="sistemaOperacional" method="post" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
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