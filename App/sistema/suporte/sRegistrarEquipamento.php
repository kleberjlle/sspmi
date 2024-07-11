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
    sCategoria,
    sModelo,
    sTensao,
    sCorrente,
    sSistemaOperacional
};

//verifica se tem credencial para acessar o sistema
if (!isset($_SESSION['credencial'])) {
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}

if (isset($_POST['formulario'])) {
    //registrar categoria
    if ($_POST['formulario'] == 'f2') {
        $pagina = $_POST['paginaF2'];
        $acao = $_POST['acaoF2'];
        $idUsuario = $_SESSION['credencial']['idUsuario'];
        
        
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
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=categoriaF2&codigo=A15");
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
    //registrar tensao
    if ($_POST['formulario'] == 'f3') {
        $pagina = $_POST['paginaF3'];
        $acao = $_POST['acaoF3'];
        $idUsuario = $_SESSION['credencial']['idUsuario'];
        $tensao = $_POST['tensaoF3'];

        //alimenta a tabela de histórico
        alimentaHistorico($pagina, $acao, 'tensao', null, $tensao, $idUsuario);

        //tratamento de dados
        $tratamentoTensao = new sTratamentoDados($tensao);
        $tensaoTratada = $tratamentoTensao->tratarNomenclatura();
        
        //instancia classe
        $sTensao = new sTensao();
        $sTensao->setNomeCampo('nomenclatura');
        $sTensao->setValorCampo($tensaoTratada);
        $sTensao->consultar('tMenu3_1.php');

        //compara os registros do BD com a nova solicitação
        if ($sTensao->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=tensaoF3&codigo=A10");
            exit();
        }
        
        if(strlen($tensaoTratada) < 5){
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=tensaoF3&codigo=A16");
            exit();
        }
        
        //inserir novo registro no BD
        $sTensao->inserir('tMenu3_1.php');
        
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=tensaoF3&codigo=S4");
        exit();
    }    
    //registrar modelo
    if ($_POST['formulario'] == 'f4') {
        $pagina = $_POST['paginaF4'];
        $acao = $_POST['acaoF4'];
        $idUsuario = $_SESSION['credencial']['idUsuario'];
        $modelo = $_POST['modeloF4'];
        $idTensao = $_POST['tensaoF4'];

        //alimenta a tabela de histórico
        alimentaHistorico($pagina, $acao, 'modelo', null, $modelo, $idUsuario);

        //tratamento de dados
        $tratamentoModelo = new sTratamentoDados($modelo);
        $modeloTratado = $tratamentoModelo->tratarNomenclatura();
        
        //instancia classe
        $sModelo = new sModelo();
        $sModelo->setNomeCampo('nomenclatura', 'tensao_idtensao');
        $sModelo->setValorCampo($modeloTratado, $idTensao);
        $sModelo->consultar('tMenu3_1.php');

        //compara os registros do BD com a nova solicitação
        if ($sModelo->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=modeloF4&codigo=A10");
            exit();
        }
        
        if(strlen($modeloTratado) < 5){
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=modeloF4&codigo=A16");
            exit();
        }
        
        //inserir novo registro no BD
        $dados = [
            'nomenclatura' => $modeloTratado,
            'tensao_idtensao' => $idTensao
        ];
        $sModelo->inserir('tMenu3_1.php', $dados);
        
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=modeloF4&codigo=S4");
        exit();
    }    
    //registrar tensão
    if ($_POST['formulario'] == 'f5') {
        $pagina = $_POST['paginaF5'];
        $acao = $_POST['acaoF5'];
        $idUsuario = $_SESSION['credencial']['idUsuario'];
        $tensao = $_POST['tensaoF5'];

        //alimenta a tabela de histórico
        alimentaHistorico($pagina, $acao, 'tensao', null, $tensao, $idUsuario);

        //tratamento de dados
        $tratamentoTensao = new sTratamentoDados($tensao);
        $tensaoTratada = $tratamentoTensao->tratarNomenclatura();
        
        //instancia classe
        $sTensao = new sTensao();
        $sTensao->setNomeCampo('nomenclatura');
        $sTensao->setValorCampo($tensaoTratada);
        $sTensao->consultar('tMenu3_1.php');
        
        //compara os registros do BD com a nova solicitação
        if ($sTensao->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=tensaoF5&codigo=A15");
            exit();
        }
        
        //verifica se a quantidade de caracter atende aos requisitos do sistema
        if(strlen($tensaoTratada) < 2){
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=tensaoF5&codigo=A8");
            exit();
        }
        
        //inserir novo registro no BD
        $sTensao->inserir('tMenu3_1.php');
        
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=tensaoF5&codigo=S4");
        exit();
    } 
    //registrar corrente
    if ($_POST['formulario'] == 'f6') {
        $pagina = $_POST['paginaF6'];
        $acao = $_POST['acaoF6'];
        $idUsuario = $_SESSION['credencial']['idUsuario'];
        $corrente = $_POST['correnteF6'];

        //alimenta a tabela de histórico
        alimentaHistorico($pagina, $acao, 'corrente', null, $corrente, $idUsuario);

        //tratamento de dados
        $tratamentoCorrente = new sTratamentoDados($corrente);
        $correnteTratada = $tratamentoCorrente->tratarNomenclatura();
        
        //instancia classe
        $sCorrente = new sCorrente();
        $sCorrente->setNomeCampo('nomenclatura');
        $sCorrente->setValorCampo($correnteTratada);
        $sCorrente->consultar('tMenu3_1.php');
        
        //compara os registros do BD com a nova solicitação
        if ($sCorrente->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=correnteF6&codigo=A15");
            exit();
        }
        
        //verifica se a quantidade de caracter atende aos requisitos do sistema
        if(strlen($correnteTratada) < 2){
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=correnteF6&codigo=A8");
            exit();
        }
        
        //inserir novo registro no BD
        $sCorrente->inserir('tMenu3_1.php');
        
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=correnteF6&codigo=S4");
        exit();
    } 
    //registrar sistema operacional
    if ($_POST['formulario'] == 'f7') {
        $pagina = $_POST['paginaF7'];
        $acao = $_POST['acaoF7'];
        $idUsuario = $_SESSION['credencial']['idUsuario'];
        $sistemaOperacional = $_POST['sistemaOperacionalF7'];

        //alimenta a tabela de histórico
        alimentaHistorico($pagina, $acao, 'sistemaOperacional', null, $sistemaOperacional, $idUsuario);

        //tratamento de dados
        $tratamentoSistemaOperacional = new sTratamentoDados($sistemaOperacional);
        $sistemaOperacionalTratada = $tratamentoSistemaOperacional->tratarNomenclatura();
        
        //instancia classe
        $sSistemaOperacional = new sSistemaOperacional();
        $sSistemaOperacional->setNomeCampo('nomenclatura');
        $sSistemaOperacional->setValorCampo($sistemaOperacionalTratada);
        $sSistemaOperacional->consultar('tMenu3_1.php');
        
        //compara os registros do BD com a nova solicitação
        if ($sSistemaOperacional->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=sistemaOperacionalF7&codigo=A15");
            exit();
        }
        
        //verifica se a quantidade de caracter atende aos requisitos do sistema
        if(strlen($sistemaOperacionalTratada) < 5){
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=sistemaOperacionalF7&codigo=A16");
            exit();
        }
        
        //inserir novo registro no BD
        $sSistemaOperacional->inserir('tMenu3_1.php');
        
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=sistemaOperacionalF7&codigo=S4");
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
