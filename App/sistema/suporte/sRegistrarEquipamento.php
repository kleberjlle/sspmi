<?php

session_start();

require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sSair,
    sTratamentoDados,
    sConfiguracao,
    sHistorico,
};
use App\sistema\suporte\{
    sCategoria
};

//verifica se tem credencial para acessar o sistema
if (!isset($_SESSION['credencial'])) {
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}

if (isset($_POST['formulario'])) {
    $pagina = $_POST['paginaF2'];
    $acao = $_POST['acaoF2'];
    $idUsuario = $_SESSION['credencial']['idUsuario'];
    
    if ($_POST['formulario'] == 'f2') {
        $categoria = $_POST['categoriaF2'];

        //alimenta a tabela de histórico
        alimentaHistorico($pagina, $acao, 'categoria', null, $categoria, $idUsuario);

        //tratamento de dados
        $tratamentoCategoria = new sTratamentoDados($categoria);
        $categoriaTratada = $tratamentoCategoria->tratarNomenclatura();
        
        //instancia classe
        $sCategoria = new sCategoria();
        $sCategoria->setNomeCampo('nomenclatura');
        $sCategoria->setValorCampo($categoriaTratada);
        $sCategoria->consultar('tMenu3_1.php');

        //compara os registros do BD com a nova solicitação
        if ($sCategoria->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=categoriaF2&codigo={$sCategoria->getSNotificacao()->getCodigo()}");
            exit();
        }
        
        if(strlen($categoriaTratada) < 5){
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=categoriaF2&codigo=A16");
            exit();
        }
        
        //inserir novo registro no BD
        $sCategoria->inserir('tMenu3_1.php');
        
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=categoriaF2&codigo=S4");
        exit();
    }
} else {
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
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
