<?php
session_start();

require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sSair,
    sConfiguracao,
    sHistorico,
    sCargo,
    sTratamentoDados
};

//verifica se tem credencial para acessar o sistema
if (!isset($_SESSION['credencial'])) {
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}

if (isset($_POST['pagina'])) {
    $idUsuario = $_SESSION['credencial']['idUsuario'];
    $idCargo = $_POST['idCargo'];
    $valorCampoAtual = $_POST['cargo'];
    $pagina = $_POST['pagina'];
    $acao = $_POST['acao'];
    
    //consulta os cargos existentes
    $sCargoAnterior = new sCargo($idCargo);
    $sCargoAnterior->consultar('tMenu5_2_1.php');
    $valorCampoAnterior = $sCargoAnterior->getNomenclatura();
        
    //tratar os campos antes do envio
    $dados = [
        'pagina' => $pagina,
        'acao' => $acao,
        'campo' => 'nomenclatura',
        'valorCampoAtual' => $valorCampoAtual,
        'valorCampoAnterior' => $valorCampoAnterior,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'navegador' => $_SERVER['HTTP_USER_AGENT'],
        'sistemaOperacional' => php_uname(),
        'nomeDoDispositivo' => gethostname(),
        'idUsuario' => $idUsuario
    ];
    
    $sHistorico = new sHistorico();
    $sHistorico->inserir('tMenu5_2_1.php', $dados);
    
    

    //coloca primeiras letras maiúsculas para comparativo
    $sTratamentoDados = new sTratamentoDados($_POST['cargo']);
    $dadosTratados = $sTratamentoDados->tratarNomenclatura();

    $registro = false;
    //compara os registros do BD com a nova solicitação
    foreach ($sCargo->mConexao->getRetorno() as $linha) {
        if ($linha['nomenclatura'] == $dadosTratados) {
            $registro = true;
        }
    }
    
    //caso já exista registro no BD, retornar mensagem de alerta, senão retorna mensagem de sucesso
    if($registro){
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=5_1&campo=cargo&codigo=A15");
        exit();
    }else{
        //inserir novo registro no BD
        $sCargo->setNomeCampo('nomenclatura');
        $sCargo->setValorCampo($dadosTratados);
        $sCargo->inserir('tMenu5_1.php');
        
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=5_1&campo=cargo&codigo=S4");
        exit();
    }
}
?>