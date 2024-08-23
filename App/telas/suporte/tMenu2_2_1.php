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

if (isset($_GET)) {
    $seguranca = base64_decode($_GET['seguranca']);
    $idProtocolo = base64_decode($_GET['protocolo']);
    //verifica se o id do usuário via GET é o mesmo da sessão
    if ($seguranca != $_SESSION['credencial']['idUsuario'] && $_SESSION['credencial']['nivelPermissao'] < 2) {
        //solicitar saída com tentativa de violação
        $sSair = new sSair();
        $sSair->verificar('0');
    }
}

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
       
        $i = 0;
        foreach ($sEtapa->mConexao->getRetorno() as $key => $value) {
            $idEquipamento = $value['equipamento_idequipamento'];
            $descricao = $value['descricao'];
            $idLocal = $value['local_idlocal'];
            $idPrioridade = $value['prioridade_idprioridade'];
            
            $etapaReversa[$i] = $value;           
            $i++;
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
} else {
    //notificar erro 
}

if($whatsApp){
    $whatsApp = '<b><i class="fab fa-whatsapp mr-1"></i></b>';
}else{
    $whatsApp = '';
}

echo <<<HTML
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Image -->
            <div class="card card-{$cor} card-outline">
                <div class="card-body box-profile">
                    <!--
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{$sConfiguracao->getDiretorioPrincipal()}vendor/almasaeed2010/adminlte/dist/img/{$imagem}" alt="User profile picture">
                    </div>
                    -->
                    {$nome}
                    <ul class="list-group list-group-unbordered mb-4">
                        <li class="list-group-item">
                            <i class="fas fa-building mr-1"></i><b> Secretaria</b><a class="float-right">{$secretaria}</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-house-user mr-1"></i><b> Departamento/ Unidade</b><a class="float-right">{$departamento}</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-house-user mr-1"></i><b> Coordenação</b> <a class="float-right">{$coordenacao}</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-house-user mr-1"></i><b> Setor</b> <a class="float-right">{$setor}</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-phone mr-1"></i><b> Telefone</b>
                            <a class="float-right">
                            {$whatsApp}
                            {$telefoneTratado}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-envelope-open-text mr-1"></i><b> Email</b> <a class="float-right">{$email}</a>
                        </li>
                    </ul>
                </div>
                <div class="card-footer">  
                </div>
                
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-4">
            <div class="card card-{$cor} card-outline">
                <div class="card-header">
                    <h3 class="card-title">Equipamento</h3>
                    <!-- /.card-tools -->
                </div>
                <div class="card-body box-profile">
                    <ul class="list-group list-group-unbordered mb-4">
                        <li class="list-group-item">
                            <i class="fas fa-barcode mr-1"></i><b> Patrimônio</b><a class="float-right">$patrimonio</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-laptop mr-1"></i><b> Categoria</b><a class="float-right">$categoria</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-tag mr-1"></i><b> Marca</b> <a class="float-right">$marca</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-tags mr-1"></i><b> Modelo</b> <a class="float-right">$modelo</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-qrcode mr-1"></i><b> Service Tag</b> <a class="float-right">$etiqueta</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-barcode mr-1"></i><b> Número de Série</b> <a class="float-right">$serie</a><br />
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-bolt mr-1"></i><b> Tensão de Entrada</b> <a class="float-right">$tensao</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-plug mr-1"></i><b> Corrente de Entrada</b> <a class="float-right">$corrente</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fab fa-windows mr-1"></i><b> Sistema Operacional</b> <a class="float-right">$sistemaOperacional</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fab fa-windows mr-1"></i><b> Ambiente</b> <a class="float-right">$ambiente</a>
                        </li>
                    </ul>
                </div>
                <div class="card-footer"> 
                    <form action="{$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_2_1" name="f2" id="f2" method="post">
                        <input type="hidden" name="menu" value="3_2_1" form="f2">
                        <input type="hidden" name="idEquipamento" value="{$idEquipamento}" form="f2">
                        <button type="submit" class="btn btn-primary float-left" form="f2">Alterar</button>
                    </form>
                </div>  
                <!-- /.card-body -->
            </div>
        </div>        
        <div class="col-md-4">                    
HTML;
       
    //inverte a ordem de ASC para DESC
    $etapaReversa = array_reverse($etapaReversa, true);
            
    $i = 0;
    $quantidadeEtapas = count($etapaReversa)-1;
    foreach ($etapaReversa as $value) {
        $numero = $value['numero'];
        $idPrioridadeEtapa = $value['prioridade_idprioridade'];
        $dataAberturaEtapa = $value['dataHoraAbertura'];
        $dataEncerramentoEtapa = $value['dataHoraEncerramento'];
        $acessoRemotoEtapa = $value['acessoRemoto'];
        $descricaoEtapa = $value['descricao'];
        $idLocalEtapa = $value['local_idlocal'];
        if(!is_null($value['usuario_idusuario'])){
            $idUsuarioEtapa = $value['usuario_idusuario'];
        }else{
            $idUsuarioEtapa = 0;
        }
        
        $solucaoEtapa = $value['solucao'];
        
        //tratamento do numero da etapa
        $quantidadeEtapas == $i ? $recente = '' : $recente = '(atual)';
        $i++;
        
        //buscar dados da prioridade
        $sPrioridadeEtapa = new sPrioridade();
        $sPrioridadeEtapa->setNomeCampo('idprioridade');
        $sPrioridadeEtapa->setValorCampo($idPrioridadeEtapa);
        $sPrioridadeEtapa->consultar('tMenu2_2_1.php');
        
        foreach ($sPrioridadeEtapa->mConexao->getRetorno() as $value) {
            $prioridadeEtapa = $value['nomenclatura'];
        }
        
        //tratamento da prioridade
        $sTratamentoPrioridadeEtapa = new sTratamentoDados($prioridadeEtapa);
        $dadosPrioridadeEtapa = $sTratamentoPrioridadeEtapa->corPrioridade();
        $posicaoEtapa = $dadosPrioridadeEtapa[0];
        $corEtapa = $dadosPrioridadeEtapa[1];
        
        //tratamento da data de abertura
        $sTratamentoDataAberturaEtapa = new sTratamentoDados($dataAberturaEtapa);
        $dataAberturaEtapaTratada = $sTratamentoDataAberturaEtapa->tratarData();
        
        //tratamento da data de encerramento
        if (!is_null($dataEncerramentoEtapa)) {
            $sTratamentoDataEncerramentoEtapa = new sTratamentoDados($dataEncerramentoEtapa);
            $dataEncerramentoEtapaTratada = $sTratamentoDataEncerramentoEtapa->tratarData();
        } else {
            $dataEncerramentoEtapaTratada = '--/--/---- --:--:--';
        }
        
        //buscar dados da local
        $sLocalEtapa = new sLocal();
        $sLocalEtapa->setNomeCampo('idlocal');
        $sLocalEtapa->setValorCampo($idLocalEtapa);
        $sLocalEtapa->consultar('tMenu2_2_1.php');
        
        foreach ($sLocalEtapa->mConexao->getRetorno() as $value) {
            $localEtapa = $value['nomenclatura'];
        }
        
        //buscar dados da usuario
        if($idUsuarioEtapa == 0){
            $responsavelEtapa = '--';
        }else{
            $sUsuarioEtapa = new sUsuario();
            $sUsuarioEtapa->setNomeCampo('idusuario');
            $sUsuarioEtapa->setValorCampo($idUsuarioEtapa);
            $sUsuarioEtapa->consultar('tMenu2_2_1.php');
            $responsavelEtapa = $sUsuarioEtapa->getNome();
        }
        
        
        echo <<<HTML
            <div class="card card-$cor card-outline collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Protocolo n.º: $protocolo - Etapa $numero $recente</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body box-profile">
                    <ul class="list-group list-group-unbordered mb-4">
                        <li class="list-group-item">
                            <i class="fas fa-route mr-1"></i><b> Etapa</b><a class="float-right">$numero</a>
                        </li>
                        <li class="list-group-item">
                            <i class="far fa-flag text-$corEtapa mr-1"></i><b> Prioridade</b><a class="float-right text-$corEtapa">$prioridadeEtapa</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-clock mr-1"></i><b> Data e Hora - Abertura</b><a class="float-right">$dataAberturaEtapaTratada</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-clock mr-1"></i><b> Data e Hora - Encerramento</b><a class="float-right">$dataEncerramentoEtapaTratada</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-broadcast-tower mr-1"></i><b> Acesso Remoto</b> <a class="float-right">$acessoRemotoEtapa</a>
                        </li>
                        <!-- próxima build
                        <li class="list-group-item">
                            <i class="far fa-images mr-1"></i><b> Print</b>
                            <a class="float-right">
                                <img src="http://localhost/SSPMI/App/telas/suporte/img/2023000101.png" width="150px" height="100px" alt="..." data-toggle="modal" data-target="#modal-xl">
                                <img src="https://placehold.it/150x100" alt="...">
                            </a>
                        </li>
                        -->
                        <li class="list-group-item">
                            <i class="far fa-file-alt mr-1"></i><b> Descrição</b> <a class="float-right">$descricaoEtapa</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-project-diagram mr-1"></i><b> Local</b> <a class="float-right">$localEtapa</a>
                        </li>
                        <li class="list-group-item">
                            <i class="far fa-id-card mr-1"></i><b> Responsável</b> <a class="float-right">$responsavelEtapa</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas far fa-file-alt mr-1"></i><b> Solução</b> <a class="float-right">$solucaoEtapa</a>
                        </li>
                        <!-- /.card-body -->
                    </ul>
                </div>
                <!-- /.card-body -->
                <div class="card-footer"> 
                <!--
                    <button type="submit" class="btn btn-primary float-left" form="alterarSuporte">Alterar</button>                    
                    <button type="submit" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal2">Finalizar Suporte</button>
                    <form action="../../sistema/suporte/sAlterarSuporte.php" id="alterarSuporte" method="post">
                        <input type="hidden" name="pagina" value="2_2_1">
                    </form>
                    <form action="../../sistema/suporte/sFinalizarSuporte.php" id="finalizarSuporte" method="post">
                        <input type="hidden" name="pagina" value="2_2_1">
                    </form>
                -->
                </div>
            </div>
HTML;
    }
echo <<<HTML
            <!-- /.card 
        </div>        
    </div>
    <!-- /.row
</div>
<!-- /.container-fluid
<div class="modal fade" id="modal-xl">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Imagem 1</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p><img src="http://localhost/SSPMI/App/telas/suporte/img/2023000101.png" width="1024px" height="640px" alt="..."></p>
            </div>            
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid
<div class="modal fade" id="modal2">
    <div class="modal-dialog modal-xl card-orange card-outline">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Finalizar Suporte</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-sm-6">
                    <!-- textarea
                    <div class="form-group">
                        <label>Solução</label>
                        <textarea class="form-control" rows="3" required="" placeholder="Ex.: Alterado endereço de Gateway para 192.168.0.243"></textarea>
                    </div>
                </div>
            </div>
            <form action="../../sistema/suporte/sFinalizarSuporte.php" id="finalizarSuporte" method="post">
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary float-left" form="finalizarSuporte">Finalizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
    -->
HTML;
?>