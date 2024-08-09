<?php
use App\sistema\acesso\{
    sTratamentoDados,
    sConfiguracao,
    sSair,
    sUsuario
};
use App\sistema\suporte\{
    sProtocolo,
    sPrioridade,
    sEtapa,
    sEquipamento,
    sCategoria,
    sModelo,
    sMarca,
    sTensao,
    sCorrente,
    sSistemaOperacional,
    sAmbiente,
    sLocal
};

$seguranca = $_POST['seguranca'];
$idProtocolo = $_POST['idProtocolo'];

//consulta os dados para apresentar na tabela
$sProtocolo = new sProtocolo();
$sProtocolo->setNomeCampo('idprotocolo');
$sProtocolo->setValorCampo($idProtocolo);
$sProtocolo->consultar('tMenu2_2_2.php');

$sConfiguracao = new sConfiguracao();

if ($sProtocolo->getValidador()) {
    foreach ($sProtocolo->mConexao->getRetorno() as $value) {
        //dados do usuario
        $sUsuario = new sUsuario();
        $sUsuario->setNomeCampo('idusuario');
        $sUsuario->setValorCampo($value['usuario_idusuario']);
        $sUsuario->consultar('tMenu2_2_1.php');
        
        //campo do requerente ou solicitante
        $nomeSolicitante = $sUsuario->getNome() . ' ' . $sUsuario->getSobrenome();
        $nomeRequerente = $value['nomeDoRequerente'] . ' ' . $value['sobrenomeDoRequerente'];
        
        //demais dados do protocolo
        $secretaria = $value['secretaria'];
        $departamento = $value['departamento'];
        $coordenacao = $value['coordenacao'];
        $setor = $value['setor'];
        $telefone = $value['telefoneDoRequerente'];
        $whatsApp = $value['whatsAppDoRequerente'];
        $email = $value['emailDoRequerente'];      
        
        //trata os nomes do solicitante e requerente
        if ($nomeSolicitante == $nomeRequerente) {
            $requerente = false;
            $nome = '<h3 class="profile-username text-center">'.$nomeSolicitante. '</h3>';
        } else {
            $requerente = true;
            $nome = '<h3 class="profile-username text-center">'.$nomeRequerente . '</h3><p class="text-muted text-center">por <i>' . $nomeSolicitante . '</i></p>';
        }    
        
        //verifique se há algum protocolo sem etapa vinculada
        $idProtocolo = $value['idprotocolo'];
        $sEtapa = new sEtapa();
        $sEtapa->setNomeCampo('protocolo_idprotocolo');
        $sEtapa->setValorCampo($idProtocolo);
        $sEtapa->consultar('tMenu2_2_1.php');
        
        foreach ($sEtapa->mConexao->getRetorno() as $key => $value) {
            $idEquipamento = $value['equipamento_idequipamento'];
            $descricao = $value['descricao'];
            $idLocal = $value['local_idlocal'];
            $idPrioridade = $value['prioridade_idprioridade'];
        }
        
        //tratamento da data de abertura
        $sTratamentoDataAbertura = new sTratamentoDados($value['dataHoraAbertura']);
        $dataAberturaTratada = $sTratamentoDataAbertura->tratarData();

        //campo protocolo
        $ano = date("Y", strtotime(str_replace('-', '/', $value['dataHoraAbertura'])));
        $protocolo = str_pad($idProtocolo, 5, 0, STR_PAD_LEFT);
        $protocolo = $ano . $protocolo;
        
        //tratamento da data de encerramento
        if (!is_null($value['dataHoraEncerramento'])) {
            $sTratamentoDataEncerramento = new sTratamentoDados($value['dataHoraEncerramento']);
            $dataEncerramentoTratada = $sTratamentoDataEncerramento->tratarData();
        } else {
            $dataEncerramentoTratada = '--/--/---- --:--:--';
        }
            
        //campo prioridade
        $sPrioridade = new sPrioridade();
        $sPrioridade->setNomeCampo('idprioridade');
        $sPrioridade->setValorCampo($idPrioridade);
        $sPrioridade->consultar('tMenu2_2_1.php');

        foreach ($sPrioridade->mConexao->getRetorno() as $key => $value) {
            $prioridade = $value['nomenclatura'];
        }
        
        //altera a cor das marcações da prioridade
        $sTratamentoPrioridade = new sTratamentoDados($prioridade);
        $dadosPrioridade = $sTratamentoPrioridade->corPrioridade();
        $posicao= $dadosPrioridade[0];
        $cor = $dadosPrioridade[1];
        
        foreach ($sPrioridade->mConexao->getRetorno() as $key => $value) {
            $prioridade = $value['nomenclatura'];
        }
        
        //altera a cor das marcações da prioridade
        $sTratamentoPrioridade = new sTratamentoDados($prioridade);
        $dadosPrioridade = $sTratamentoPrioridade->corPrioridade();
        $posicao= $dadosPrioridade[0];
        $cor = $dadosPrioridade[1];
        
        //tratamento do telefone
        $sTratamentoTelefone = new sTratamentoDados($telefone);
        $telefoneTratado = $sTratamentoTelefone->tratarTelefone();
        
        //dados do equipamento
        $sEquipamento = new sEquipamento();
        $sEquipamento->setNomeCampo('idequipamento');
        $sEquipamento->setValorCampo($idEquipamento);
        $sEquipamento->consultar('tMenu2_2_1.php');
        
        foreach ($sEquipamento->mConexao->getRetorno() as $value) {
            $patrimonio = $value['patrimonio'];
            $idCategoria = $value['categoria_idcategoria'];
            $idModelo = $value['modelo_idmodelo'];
            $etiqueta = $value['etiquetaDeServico'];
            $serie = $value['numeroDeSerie'];
            $idTensao = $value['tensao_idtensao'];
            $idCorrente = $value['corrente_idcorrente'];
            $idSistemaOperacional = $value['sistemaOperacional_idsistemaOperacional'];
            $idAmbiente = $value['ambiente_idambiente'];
        }
        
        //dados da categoria
        $sCategoria = new sCategoria();
        $sCategoria->setNomeCampo('idcategoria');
        $sCategoria->setValorCampo($idCategoria);
        $sCategoria->consultar('tMenu2_2_1.php');
        
        foreach ($sCategoria->mConexao->getRetorno() as $value) {
            $categoria = $value['nomenclatura'];
        }
        
        //dados da modelo
        $sModelo = new sModelo();
        $sModelo->setNomeCampo('idmodelo');
        $sModelo->setValorCampo($idModelo);
        $sModelo->consultar('tMenu2_2_1.php');
        
        foreach ($sModelo->mConexao->getRetorno() as $value) {
            $idMarca = $value['marca_idmarca'];
            $modelo = $value['nomenclatura'];
        }
        
        //dados da marca
        $sMarca = new sMarca();
        $sMarca->setNomeCampo('idmarca');
        $sMarca->setValorCampo($idMarca);
        $sMarca->consultar('tMenu2_2_1.php');
        
        foreach ($sMarca->mConexao->getRetorno() as $value) {
            $marca = $value['nomenclatura'];
        }
        
        //dados da tensao
        $sTensao = new sTensao();
        $sTensao->setNomeCampo('idtensao');
        $sTensao->setValorCampo($idTensao);
        $sTensao->consultar('tMenu2_2_1.php');
        
        foreach ($sTensao->mConexao->getRetorno() as $value) {
            $tensao = $value['nomenclatura'];
        }
        
        //dados da corrente
        $sCorrente = new sCorrente();
        $sCorrente->setNomeCampo('idcorrente');
        $sCorrente->setValorCampo($idCorrente);
        $sCorrente->consultar('tMenu2_2_1.php');
        
        foreach ($sCorrente->mConexao->getRetorno() as $value) {
            $corrente = $value['nomenclatura'];
        }
        
        //dados da sistemaOperacional
        $sSistemaOperacional = new sSistemaOperacional();
        $sSistemaOperacional->setNomeCampo('idsistemaOperacional');
        $sSistemaOperacional->setValorCampo($idSistemaOperacional);
        $sSistemaOperacional->consultar('tMenu2_2_1.php');
        
        foreach ($sSistemaOperacional->mConexao->getRetorno() as $value) {
            $sistemaOperacional = $value['nomenclatura'];
        }
        
        //dados da ambiente
        $sAmbiente = new sAmbiente();
        $sAmbiente->setNomeCampo('idambiente');
        $sAmbiente->setValorCampo($idAmbiente);
        $sAmbiente->consultar('tMenu2_2_1.php');
        
        foreach ($sAmbiente->mConexao->getRetorno() as $value) {
            $ambiente = $value['nomenclatura'];
        }
        
    }
}

if($_POST['formulario'] == 'f1'){
echo <<<HTML
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-{$cor} card-outline">
                <div class="card-header">
                    <h3 class="card-title">Protocolo n.º: {$protocolo}</h3>
                </div>
                <!-- form start -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Secretaria</label>
                                <select class="form-control" name="secretaria" id="secretaria" disabled="" form="f2">
                                    <option value="0" selected="">--</option>
HTML;
                                    foreach ($sSecretaria->mConexao->getRetorno() as $value) {
                                        echo '<option value="' . $value['idsecretaria'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                    }
                                echo <<<HTML
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="departamento">Departamento</label>
                                <select class="form-control" name="departamento" id="departamento" disabled="" form="f2">
                                     <option value="0" selected="">--</option>
HTML;
                                    foreach ($sDepartamento->mConexao->getRetorno() as $value) {
                                        echo '<option value="' . $value['iddepartamento'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                    }
                                echo <<<HTML
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Coordenação</label>
                                <select class="form-control" name="coordenacao" id="coordenacao" disabled="" form="f2">
                                     <option value="0" selected="">--</option>
HTML;
                                    foreach ($sCoordenacao->mConexao->getRetorno() as $value) {
                                        echo '<option value="' . $value['idcoordenacao'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                    }
                                    echo <<<HTML
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="setor">Setor</label>
                                <select class="form-control" name="setor" id="setor" disabled="" form="f2">
                                    <option value="0" selected="">--</option>
HTML;
                                    foreach ($sSetor->mConexao->getRetorno() as $value) {
                                        echo '<option value="' . $value['idsetor'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                    }
                                    echo <<<HTML
                                </select>
                            </div>
                        </div>
                    
                        <!-- próxima build
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
                <form action="{$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=2_1_1" method="post" enctype="multipart/form-data" name="f1" id="f1">
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
HTML;
}
?>
<script type="text/javascript">
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
