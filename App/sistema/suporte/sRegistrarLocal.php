<?php

session_start();

require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sSair,
    sConfiguracao,
    sHistorico,
    sTratamentoDados,
    sSecretaria,
    sTelefone
};

//verifica se tem credencial para acessar o sistema
if (!isset($_SESSION['credencial'])) {
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}

if (isset($_POST['pagina'])) {
    $pagina = $_POST['pagina'];
    $acao = $_POST['acao'];
    $idUsuario = $_SESSION['credencial']['idUsuario'];
    $secretaria = $_POST['secretaria'];
    $endereco = $_POST['endereco'];
    $ambiente = $_POST['ambiente'];
    $telefone = $_POST['telefone'];
    $whatsApp = $_POST['whatsApp'];

    alimentaHistorico($pagina, $acao, 'secretaria', null, $secretaria, $idUsuario);
    alimentaHistorico($pagina, $acao, 'endereco', null, $endereco, $idUsuario);
    alimentaHistorico($pagina, $acao, 'ambiente', null, $ambiente, $idUsuario);
    alimentaHistorico($pagina, $acao, 'telefone', null, $telefone, $idUsuario);
    alimentaHistorico($pagina, $acao, 'whatsApp', null, $whatsApp, $idUsuario);

    //tratamento de dados
    $tratamento = new sTratamentoDados($secretaria);

    //verifica se já existe alguma secretaria registrada com a nomenclatura
    $secretariaTratada = $tratamento->tratarNomenclatura();
    $sSecretaria = new sSecretaria(0);
    $sSecretaria->consultar('tMenu4_1.php');

    //compara os registros do BD com a nova solicitação
    foreach ($sSecretaria->mConexao->getRetorno() as $linha) {
        if ($secretariaTratada == $linha['nomenclatura']) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=4_1&campo=secretaria&codigo=A15");
            exit();
        }
    }

    //verifica quantidade de caracteres do registro
    if (mb_strlen($endereco) < 5) {
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=4_1&campo=endereco&codigo=A16");
        exit();
    }

    //valida o número de telefone
    $sTelefone = new sTelefone(0, 0, '');
    $telefoneTratado = $sTelefone->tratarTelefone($telefone);
    if (strlen($telefoneTratado)) {
        $sTelefone->verificarTelefone($telefoneTratado);
        if (!$sTelefone->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=4_1&campo=telefone&codigo={$sTelefone->getSNotificacao()->getCodigo()}");
            exit();
        }
    }





    //inserir novo registro no BD
    //$sCargo->setNomeCampo('nomenclatura');
    //$sCargo->setValorCampo($dadosTratados);
    //$sCargo->inserir('tMenu5_1.php');
    //$sConfiguracao = new sConfiguracao();
    //header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=5_1&campo=cargo&codigo=S4");    
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

?>