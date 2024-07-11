<?php

use App\sistema\acesso\{
    sConfiguracao,
    sNotificacao,
    sSecretaria,
    sDepartamento,
    sCoordenacao,
    sSetor
};

use App\sistema\suporte\{
    sMarca
};

//instancia classes para manipulação dos dados
$sConfiguracao = new sConfiguracao();

$sMarca = new sMarca();
$sMarca->consultar('tMenu3_1.php-f4');

//retorno de campo inválidos para notificação
if (isset($_GET['campo'])) {
    $sNotificacao = new sNotificacao($_GET['codigo']);
    switch ($_GET['campo']) {
        case 'categoriaF2':
            if ($_GET['codigo'] == 'S4') {
                $alertaCategoriaF2 = ' is-valid';
            } else {
                $alertaCategoriaF2 = ' is-warning';
            }
            break;
        case 'marcaF3':
            if ($_GET['codigo'] == 'S4') {
                $alertaMarcaF3 = ' is-valid';
            } else {
                $alertaMarcaF3 = ' is-warning';
            }
            break;
        case 'modeloF4':
            if ($_GET['codigo'] == 'S4') {
                $alertaModeloF4 = ' is-valid';
            } else {
                $alertaModeloF4 = ' is-warning';
            }
            break;
        case 'tensaoF5':
            if ($_GET['codigo'] == 'S4') {
                $alertaTensaoF5 = ' is-valid';
            } else {
                $alertaTensaoF5 = ' is-warning';
            }
            break;
        case 'correnteF6':
            if ($_GET['codigo'] == 'S4') {
                $alertaCorrenteF6 = ' is-valid';
            } else {
                $alertaCorrenteF6 = ' is-warning';
            }
            break;
        case 'sistemaOperacionalF7':
            if ($_GET['codigo'] == 'S4') {
                $alertaSistemaOperacionalF7 = ' is-valid';
            } else {
                $alertaSistemaOperacionalF7 = ' is-warning';
            }
            break;
        default:
            break;
    }

    //cria as variáveis da notificação
    $tipo = $sNotificacao->getTipo();
    $titulo = $sNotificacao->getTitulo();
    $mensagem = $sNotificacao->getMensagem();
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
                <form action="<?php echo $sConfiguracao->getDiretorioControleSuporte(); ?>sRegistrarCategoria.php" name="categoriaF2" id="categoriaF2" method="post" enctype="multipart/form-data">
                    <!-- /.card-body-->
                    <div class="card-footer">
                        <input type="hidden" value="f2" name="formulario" form="f2">
                        <input type="hidden" value="inserir" name="acaoF2" form="f2">
                        <input type="hidden" value="menu3_1" name="paginaF2" form="f2">
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
            <div class="card card-outline card-primary <?php echo isset($alertaCategoriaF2) ? '' : 'collapsed-card' ?>">
                <div class="card-header">
                    <h3 class="card-title">Categoria</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas <?php echo isset($alertaCategoriaF2) ? 'fa-minus' : 'fa-plus' ?>"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- form start -->                
                <div class="card-body">
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="categoria">Categoria</label>
                            <input class="form-control<?php echo isset($alertaCategoriaF2) ? $alertaCategoriaF2 : ''; ?>" type="text" name="categoriaF2" id="categoriaF2" placeholder="Ex.: Impressora" form="f2" required="">
                        </div>
                    </div>
                </div>
                <?php
                if (isset($tipo) &&
                    isset($titulo) &&
                    isset($mensagem)) {
                    if (isset($alertaCategoriaF2)) {
                        echo <<<HTML
                    <div class="col-mb-3">
                        <div class="card card-outline card-{$tipo}">
                            <div class="card-header">
                                <h3 class="card-title">{$titulo}</h3>
                            </div>
                            <div class="card-body">
                                {$mensagem}
                            </div>
                        </div>
                    </div>
HTML;
                    }
                }
                ?>
                <form action="<?php echo $sConfiguracao->getDiretorioControleSuporte(); ?>sRegistrarEquipamento.php" method="post" id="f2" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" value="f2" name="formulario" form="f2">
                        <input type="hidden" value="inserir" name="acaoF2" form="f2">
                        <input type="hidden" value="menu3_1" name="paginaF2" form="f2">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-2">
            <!-- general form elements -->
            <div class="card card-outline card-primary <?php echo isset($alertaMarcaF3) ? '' : 'collapsed-card' ?>">
                <div class="card-header">
                    <h3 class="card-title">Marca</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas <?php echo isset($alertaMarcaF3) ? 'fa-minus' : 'fa-plus' ?>"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- form start -->                
                <div class="card-body">
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="marca">Marca</label>
                            <input class="form-control<?php echo isset($alertaMarcaF3) ? $alertaMarcaF3 : ''; ?>" type="text" name="marcaF3" id="marcaF3" placeholder="Ex.: Dell" form="f3" required="">
                        </div>
                    </div>
                </div>
                <?php
                if (isset($tipo) &&
                    isset($titulo) &&
                    isset($mensagem)) {
                    if (isset($alertaMarcaF3)) {
                        echo <<<HTML
                    <div class="col-mb-3">
                        <div class="card card-outline card-{$tipo}">
                            <div class="card-header">
                                <h3 class="card-title">{$titulo}</h3>
                            </div>
                            <div class="card-body">
                                {$mensagem}
                            </div>
                        </div>
                    </div>
HTML;
                    }
                }
                ?>
                <form action="<?php echo $sConfiguracao->getDiretorioControleSuporte(); ?>sRegistrarEquipamento.php" method="post" id="f3" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" value="f3" name="formulario" form="f3">
                        <input type="hidden" value="inserir" name="acaoF3" form="f3">
                        <input type="hidden" value="menu3_1" name="paginaF3" form="f3">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-2">
            <!-- general form elements -->
            <div class="card card-outline card-primary <?php echo isset($alertaModeloF4) ? '' : 'collapsed-card' ?>">
                <div class="card-header">
                    <h3 class="card-title">Modelo</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas <?php echo isset($alertaModeloF4) ? 'fa-minus' : 'fa-plus' ?>"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- form start -->                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Marca</label>
                                <select class="form-control" name="marcaF4" id="marcaF4" form="f4">
                                    <?php
                                    if($sMarca->getValidador()){
                                        foreach ($sMarca->mConexao->getRetorno() as $value) {
                                            echo '<option value="' . $value['idmarca'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                        }
                                    }else{
                                       echo '<option value="0" selected="">--</option>'; 
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="modelo">Modelo</label>
                            <input class="form-control<?php echo isset($alertaModeloF4) ? $alertaModeloF4 : ''; ?>" type="text" name="modeloF4" id="modeloF4" placeholder="Ex.: OptiPlex 3000" form="f4" required="">
                        </div>
                    </div>
                </div>
                <?php
                if (isset($tipo) &&
                    isset($titulo) &&
                    isset($mensagem)) {
                    if (isset($alertaModeloF4)) {
                        echo <<<HTML
                    <div class="col-mb-3">
                        <div class="card card-outline card-{$tipo}">
                            <div class="card-header">
                                <h3 class="card-title">{$titulo}</h3>
                            </div>
                            <div class="card-body">
                                {$mensagem}
                            </div>
                        </div>
                    </div>
HTML;
                    }
                }
                ?>
                <form action="<?php echo $sConfiguracao->getDiretorioControleSuporte(); ?>sRegistrarEquipamento.php" method="post" id="f4" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" value="f4" name="formulario" form="f4">
                        <input type="hidden" value="inserir" name="acaoF4" form="f4">
                        <input type="hidden" value="menu3_1" name="paginaF4" form="f4">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-2">
            <!-- general form elements -->
            <div class="card card-outline card-primary <?php echo isset($alertaTensaoF5) ? '' : 'collapsed-card' ?>">
                <div class="card-header">
                    <h3 class="card-title">Tensão</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas <?php echo isset($alertaTensaoF5) ? 'fa-minus' : 'fa-plus' ?>"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- form start -->                
                <div class="card-body">
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="tensao">Tensão</label>
                            <input class="form-control<?php echo isset($alertaTensaoF5) ? $alertaTensaoF5 : ''; ?>" type="text" name="tensaoF5" id="tensaoF5" placeholder="Ex.: 19.5v" form="f5" required="">
                        </div>
                    </div>
                </div>
                <?php
                if (isset($tipo) &&
                    isset($titulo) &&
                    isset($mensagem)) {
                    if (isset($alertaTensaoF5)) {
                        echo <<<HTML
                    <div class="col-mb-3">
                        <div class="card card-outline card-{$tipo}">
                            <div class="card-header">
                                <h3 class="card-title">{$titulo}</h3>
                            </div>
                            <div class="card-body">
                                {$mensagem}
                            </div>
                        </div>
                    </div>
HTML;
                    }
                }
                ?>
                <form action="<?php echo $sConfiguracao->getDiretorioControleSuporte(); ?>sRegistrarEquipamento.php" method="post" id="f5" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" value="f5" name="formulario" form="f5">
                        <input type="hidden" value="inserir" name="acaoF5" form="f5">
                        <input type="hidden" value="menu3_1" name="paginaF5" form="f5">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-2">
            <!-- general form elements -->
            <div class="card card-outline card-primary <?php echo isset($alertaCorrenteF6) ? '' : 'collapsed-card' ?>">
                <div class="card-header">
                    <h3 class="card-title">Corrente</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas <?php echo isset($alertaCorrenteF6) ? 'fa-minus' : 'fa-plus' ?>"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- form start -->                
                <div class="card-body">
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="corrente">Corrente</label>
                            <input class="form-control<?php echo isset($alertaCorrenteF6) ? $alertaCorrenteF6 : ''; ?>" type="text" name="correnteF6" id="correnteF6" placeholder="Ex.: 3.42a" form="f6" required="">
                        </div>
                    </div>
                </div>
                <?php
                if (isset($tipo) &&
                    isset($titulo) &&
                    isset($mensagem)) {
                    if (isset($alertaCorrenteF6)) {
                        echo <<<HTML
                    <div class="col-mb-3">
                        <div class="card card-outline card-{$tipo}">
                            <div class="card-header">
                                <h3 class="card-title">{$titulo}</h3>
                            </div>
                            <div class="card-body">
                                {$mensagem}
                            </div>
                        </div>
                    </div>
HTML;
                    }
                }
                ?>
                <form action="<?php echo $sConfiguracao->getDiretorioControleSuporte(); ?>sRegistrarEquipamento.php" method="post" id="f6" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" value="f6" name="formulario" form="f6">
                        <input type="hidden" value="inserir" name="acaoF6" form="f6">
                        <input type="hidden" value="menu3_1" name="paginaF6" form="f6">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-2">
            <!-- general form elements -->
            <div class="card card-outline card-primary <?php echo isset($alertaSistemaOperacionalF7) ? '' : 'collapsed-card' ?>">
                <div class="card-header">
                    <h3 class="card-title">Sistema Operacional</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas <?php echo isset($alertaSistemaOperacionalF7) ? 'fa-minus' : 'fa-plus' ?>"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- form start -->                
                <div class="card-body">
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="sistemaOperacional">Sistema Operacional</label>
                            <input class="form-control<?php echo isset($alertaSistemaOperacionalF7) ? $alertaSistemaOperacionalF7 : ''; ?>" type="text" name="sistemaOperacionalF7" id="sistemaOperacionalF7" placeholder="Ex.: Windows 11 Professional Edition" form="f6" required="">
                        </div>
                    </div>
                </div>
                <?php
                if (isset($tipo) &&
                    isset($titulo) &&
                    isset($mensagem)) {
                    if (isset($alertaSistemaOperacionalF7)) {
                        echo <<<HTML
                    <div class="col-mb-3">
                        <div class="card card-outline card-{$tipo}">
                            <div class="card-header">
                                <h3 class="card-title">{$titulo}</h3>
                            </div>
                            <div class="card-body">
                                {$mensagem}
                            </div>
                        </div>
                    </div>
HTML;
                    }
                }
                ?>
                <form action="<?php echo $sConfiguracao->getDiretorioControleSuporte(); ?>sRegistrarEquipamento.php" method="post" id="f6" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" value="f6" name="formulario" form="f6">
                        <input type="hidden" value="inserir" name="acaoF7" form="f6">
                        <input type="hidden" value="menu3_1" name="paginaF7" form="f6">
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
