<?php

use App\sistema\acesso\{
    sConfiguracao,
    sSecretaria,
    sDepartamento,
    sCoordenacao,
    sSetor
};

use App\sistema\suporte\{
    sPrioridade,
    sLocal
};

//instancia classes para manipulação dos dados
$sConfiguracao = new sConfiguracao();

$sSecretaria = new sSecretaria(0);
$sSecretaria->consultar('tMenu2_1.php');

$sDepartamento = new sDepartamento(0);
$sDepartamento->consultar('tMenu2_1.php');

$sCoordenacao = new sCoordenacao(0);
$sCoordenacao->consultar('tMenu2_1.php');

$sSetor = new sSetor(0);
$sSetor->consultar('tMenu2_1.php');

$sLocal = new sLocal();
$sLocal->consultar('tMenu2_1.php');

$sPrioridade = new sPrioridade();        
$sPrioridade->consultar('tMenu2_1_1.php');
?>
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Etapa 1 - Solicitante</h3>
                </div>
                <!-- form start -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" id="meusDados" name="meusDados" checked="checked" value="1" onclick="habilitar();" form="f1">
                                        <label class="custom-control-label" for="meusDados">Utilizar meus dados para a solicitação do suporte</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Secretaria</label>
                                    <select class="form-control" name="secretaria" id="secretaria" disabled="" form="f1">
                                        <option value="0" selected="">--</option>
                                        <?php
                                        foreach ($sSecretaria->mConexao->getRetorno() as $value) {
                                            echo '<option value="' . $value['idsecretaria'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="departamento">Departamento</label>
                                    <select class="form-control" name="departamento" id="departamento" disabled="" form="f1">
                                         <option value="0" selected="">--</option>
                                        <?php
                                        foreach ($sDepartamento->mConexao->getRetorno() as $value) {
                                            echo '<option value="' . $value['iddepartamento'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Coordenação</label>
                                    <select class="form-control" name="coordenacao" id="coordenacao" disabled="" form="f1">
                                         <option value="0" selected="">--</option>
                                        <?php
                                        foreach ($sCoordenacao->mConexao->getRetorno() as $value) {
                                            echo '<option value="' . $value['idcoordenacao'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="setor">Setor</label>
                                    <select class="form-control" name="setor" id="setor" disabled="" form="f1">
                                        <option value="0" selected="">--</option>
                                        <?php
                                        foreach ($sSetor->mConexao->getRetorno() as $value) {
                                            echo '<option value="' . $value['idsetor'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="local">Local</label>
                                    <select class="form-control" name="local" id="local" form="f1">
                                        <?php
                                        foreach ($sLocal->mConexao->getRetorno() as $value) {
                                            echo '<option value="' . $value['idlocal'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required="" disabled="" form="f1">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Sobrenome</label>
                                <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome" required="" disabled="" form="f1">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Telefone</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" required="" disabled="" placeholder="(99) 9 9999-9999" data-inputmask='"mask": "(99) 9 9999-9999"' data-mask inputmode="text" form="f1">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Whatsapp</label>
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" id="whatsApp" name="whatsApp" value="1" onclick="habilitar();" disabled="" form="f1">
                                        <label class="custom-control-label" for="whatsApp">Sim</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label>E-mail</label>
                                <input class="form-control" type="email" id="email" name="email" placeholder="E-mail" disabled="" form="f1">
                            </div>
                        </div>
                        <div class="row">                     
                            <div class="form-group col-md-2">
                                <label for="acessoRemoto">Acesso remoto</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                                <input class="form-control" type="text" id="acessoRemotoF1" name="acessoRemotoF1" placeholder="Ex.: 1505389456" form="f1">
                            </div>   
                            <div class="form-group col-md-2">
                                <label for="patrimonio">Patrimônio</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                                <input class="form-control" type="text" id="patrimonioF1" name="patrimonioF1" placeholder="Ex.: 30800" form="f1">
                            </div> 
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Prioridade</label>
                                    <select class="form-control<?php echo isset($alertaPrioridadeF2) ? $alertaPrioridadeF2 : ''; ?>" name="prioridadeF1" id="prioridadeF1" form="f1" required="">
                                        <?php
                                        if ($sPrioridade->getValidador()) {
                                            foreach ($sPrioridade->mConexao->getRetorno() as $value) {
                                                $value['nomenclatura'] == 'Normal' ? $atributo = 'selected=""' : $atributo = '';
                                                if($value['nomenclatura'] == 'Normal' || $value['nomenclatura'] == 'Alta'){
                                                    echo '<option value="' . $value['idprioridade'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                                }else if($_SESSION['credencial']['nivelPermissao'] >= $value['idprioridade']){
                                                    echo '<option value="' . $value['idprioridade'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                                }
                                                
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>  
                            <div class="col-sm-6">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label>Descrição</label>
                                    <textarea class="form-control" rows="3" name="descricaoF1" id="descricaoF1" placeholder="Descrição..." required="" form="f1"></textarea>
                                </div>
                            </div>
                            <!-- próxima build
                            <div class="form-group col-md-3">
                                <label for="print">Print</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="print">
                                        <label class="custom-file-label" for="print">Caminho do diretório</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Enviar</span>
                                    </div>
                                </div>
                            </div>
                            -->
                        </div>
                    </div>
                <form action="<?php echo $sConfiguracao->getDiretorioControleSuporte(); ?>sSolicitarSuporte.php" method="post" enctype="multipart/form-data" name="f1" id="f1">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" value="f1" name="formulario" form="f1">
                        <input type="hidden" value="inserir" name="acaoF1" form="f1">
                        <input type="hidden" value="menu2_1" name="paginaF1" form="f1">
                        <button type="submit" class="btn btn-primary">Próxima</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
    function habilitar() {
        if (document.getElementById('meusDados').checked) {
            document.getElementById('secretaria').disabled = true;
            document.getElementById('departamento').disabled = true;
            document.getElementById('coordenacao').disabled = true;
            document.getElementById('setor').disabled = true;
            document.getElementById('nome').disabled = true;
            document.getElementById('sobrenome').disabled = true;
            document.getElementById('telefone').disabled = true;
            document.getElementById('whatsApp').disabled = true;
            document.getElementById('email').disabled = true;
        } else {
            document.getElementById('secretaria').disabled = false;
            document.getElementById('departamento').disabled = false;
            document.getElementById('coordenacao').disabled = false;
            document.getElementById('setor').disabled = false;
            document.getElementById('nome').disabled = false;
            document.getElementById('sobrenome').disabled = false;
            document.getElementById('telefone').disabled = false;
            document.getElementById('whatsApp').disabled = false;
            document.getElementById('email').disabled = false;
        }
    }
    
    $(document).ready(function () {
        //traz os departamentos de acordo com a secretaria selecionada   
        $('#secretaria').on('change', function () {
            var idSecretaria = $(this).val();

            //mostra somente os departamentos da secretaria escolhida
            $.ajax({
                url: 'https://itapoa.app.br/App/sistema/acesso/ajaxDepartamento.php',
                type: 'POST',
                data: {
                    'idSecretaria': idSecretaria
                },
                success: function (html) {
                    $('#departamento').html(html);
                }
            });

            //mostra somente as coordenações de acordo com a secretaria selecionada
            var idSecretaria = $(this).val();
            //mostra as coordenações do departamento escolhido
            $.ajax({
                url: 'https://itapoa.app.br/App/sistema/acesso/ajaxCoordenacao.php',
                type: 'POST',
                data: {
                    'idSecretaria': idSecretaria
                },
                success: function (html) {
                    $('#coordenacao').html(html);
                }
            });

            //mostra somente as coordenações de acordo com a secretaria selecionada
            var idSecretaria = $(this).val();
            //mostra as coordenações do departamento escolhido
            $.ajax({
                url: 'https://itapoa.app.br/App/sistema/acesso/ajaxSetor.php',
                type: 'POST',
                data: {
                    'idSecretaria': idSecretaria
                },
                success: function (html) {
                    $('#setor').html(html);
                }
            });
        });
    });
    
    
</script>