<?php
session_start();

require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sSair,
    sHistorico,
    sConfiguracao,
    sNotificacao
};
use App\sistema\suporte\{
    sEtapa
};

//verifica se tem credencial para acessar o sistema
if (!isset($_SESSION['credencial'])) {
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}

//instancia as configurações do sistema
$sConfiguracao = new sConfiguracao();

if(isset($_POST['pagina'])){
    //cria variáveis locais com os dados recebidos via post
    $pagina = $_POST['pagina'];
    $idProtocolo = $_POST['idProtocolo'];
    $numero = $_POST['etapa'];
    $idLocal = $_POST['local'];  
    $idResponsavel = $_POST['responsavel'];
        
    //buscar dados da etapa
    $sEtapa = new sEtapa();
    $sEtapa->setNomeCampo('protocolo_idprotocolo');
    $sEtapa->setValorCampo($idProtocolo);
    $sEtapa->consultar('tMenu2_2_1_3_1.php');
    
    foreach ($sEtapa->mConexao->getRetorno() as $value) {
        $idEtapa = $value['idetapa'];
        $numero = $value['numero'];
        $idLocal = $value['local_idlocal'];
        $responsavel = $value['usuario_idusuario'];
    }
    
    if($idResponsavel == $responsavel){
        //gera notificação e redireciona para a página
        $sNotificacao = new sNotificacao('A23');    
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=2_2_1_3_1&campo=responsavel&codigo={$sNotificacao->getCodigo()}&pagina=tMenu2_2_1_3_1.php&idProtocolo={$idProtocolo}&etapa={$numero}");
        exit();
    }
    
    //variáveis para o histórico
    $acao = $_POST['acao'];
    $valorCampoAtual = '';
    $valorCampoAnterior = $idLocal;
    $ip = $_SERVER['REMOTE_ADDR'];
    $navegador = $_SERVER['HTTP_USER_AGENT'];
    $sistemaOperacional = php_uname();
    $nomeDoDispositivo = gethostname();
    $idUsuario = $_SESSION['credencial']['idUsuario'];
    
    //configura timezone para São Paulo
    $sConfiguracao = new sConfiguracao();
    $sConfiguracao->getTimeZone();
    $dataHoraEncerramento = date("Y-m-d H:i:s");    
    
    //alimentar o histórico
    alimentaHistorico($pagina, $acao, 'local_idlocal', $valorCampoAnterior, $idLocal, $idUsuario);
    exit();
    //encerrar etapa anterior (etapa 1)    
    //altera o campo dataHoraEncerramento
    $sEtapa->setIdEtapa($idEtapa);
    $sEtapa->setNomeCampo('dataHoraEncerramento');
    $sEtapa->setValorCampo($dataHoraEncerramento);
    $sEtapa->alterar('tMenu2_2_3.php');
    
    //altera o campo usuário
    $sEtapa->setNomeCampo('usuario_idusuario');
    $sEtapa->setValorCampo($idUsuario);
    $sEtapa->alterar('tMenu2_2_3.php');
    
    //altera o campo solucao
    $sEtapa->setNomeCampo('solucao');
    $sEtapa->setValorCampo($solucao);
    $sEtapa->alterar('tMenu2_2_3.php');
    
    //alimentar o histórico
    $acao = 'inserir';
    $numero += $numero;
    alimentaHistorico($pagina, $acao, 'numero', $valorCampoAnterior, $numero, $idUsuario);
    alimentaHistorico($pagina, $acao, 'acessorRemoto', $valorCampoAnterior, $acessoRemoto, $idUsuario);
    alimentaHistorico($pagina, $acao, 'descricao', $valorCampoAnterior, $descricao, $idUsuario);
    alimentaHistorico($pagina, $acao, 'equipamento_idequipamento', $valorCampoAnterior, $idEquipamento, $idUsuario);
    alimentaHistorico($pagina, $acao, 'protocolo_idprotocolo', $valorCampoAnterior, $idProtocolo, $idUsuario);
    alimentaHistorico($pagina, $acao, 'local_idlocal', $valorCampoAnterior, $idLocal, $idUsuario);
    alimentaHistorico($pagina, $acao, 'prioridade_idprioridade', $valorCampoAnterior, $idPrioridade, $idUsuario);
    alimentaHistorico($pagina, $acao, 'usuario_idusuario', $valorCampoAnterior, $idUsuario, $idUsuario);
    
    //inserir nova etapa no sistema
    //inserir dados na nova etapa
    $dadosTratados = [
        'numero' => $numero,
        'acessoRemoto' => $acessoRemoto,
        'descricao' => $descricao,
        'equipamento_idequipamento' => $idEquipamento,
        'protocolo_idprotocolo' => $idProtocolo,
        'local_idlocal' => $idLocal,
        'prioridade_idprioridade' => $idPrioridade,
        'usuario_idusuario' => $idUsuario
    ];
    $sEtapa->inserir('tMenu2_2_3.php', $dadosTratados);
    
    //gera notificação e redireciona para a página
    $sNotificacao = new sNotificacao('S6');    
    header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=2_2&campo=atribuir&codigo={$sNotificacao->getCodigo()}");
    exit();
}

function alimentaHistorico($pagina, $acao, $campo, $valorCampoAnterior, $valorCampoAtual, $idUsuario) {
    //tratar os campos antes do envio
    $tratarDados = [
        'pagina' => $pagina,
        'acao' => $acao,
        'campo' => $campo,
        'valorCampoAtual' => $valorCampoAtual,
        'valorCampoAnterior' => $valorCampoAnterior,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'navegador' => $_SERVER['HTTP_USER_AGENT'],
        'sistemaOperacional' => php_uname(),
        'nomeDoDispositivo' => gethostname(),
        'idUsuario' => $idUsuario
    ];

    //insere na tabela histórico
    $sHistorico = new sHistorico();
    $sHistorico->inserir('tSolicitarAcesso.php', $tratarDados);
}
?>