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

$pagina = $_POST['pagina'];
$acao = $_POST['acao'];
$idUsuario = $_SESSION['credencial']['idUsuario'];
$secretaria = $_POST['secretaria'];
$endereco = $_POST['endereco'];
$ambiente = $_POST['ambiente'];
$telefone = $_POST['telefone'];
$whatsApp = $_POST['whatsApp'];




alimentaHistorico($pagina, $acao, 'nome', $valorCampoAnterior, $nome, $idUsuario);


if (isset($_POST['pagina'])) {
    //alimenta histórico
    $tratarDados = [
        'pagina' => $_POST['pagina'],
        'acao' => $_POST['acao'],
        'campo' => 'nomenclatura',
        'valorCampoAtual' => $_POST['cargo'],
        'valorCampoAnterior' => null,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'navegador' => $_SERVER['HTTP_USER_AGENT'],
        'sistemaOperacional' => php_uname(),
        'nomeDoDispositivo' => gethostname(),
        'idUsuario' => $_SESSION['credencial']['idUsuario']
    ];
    $sHistorico = new sHistorico();
    $sHistorico->inserir('tMenu5_1.php', $tratarDados);

    //consulta os cargos existentes
    $sCargo = new sCargo(0);
    $sCargo->consultar('tMenu5_1.php');

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
    if ($registro) {
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=5_1&campo=cargo&codigo=A15");
        exit();
    } else {
        //inserir novo registro no BD
        $sCargo->setNomeCampo('nomenclatura');
        $sCargo->setValorCampo($dadosTratados);
        $sCargo->inserir('tMenu5_1.php');

        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=5_1&campo=cargo&codigo=S4");
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
        $sHistorico->inserir('tMenu4_1.php', $tratarDados);
    }

}
?>