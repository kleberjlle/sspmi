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
    sMarca,
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
    //registrar marca
    if ($_POST['formulario'] == 'f3') {
        $pagina = $_POST['paginaF3'];
        $acao = $_POST['acaoF3'];
        $idUsuario = $_SESSION['credencial']['idUsuario'];
        $marca = $_POST['marcaF3'];

        //alimenta a tabela de histórico
        alimentaHistorico($pagina, $acao, 'marca', null, $marca, $idUsuario);

        //tratamento de dados
        $tratamentoMarca = new sTratamentoDados($marca);
        $marcaTratada = $tratamentoMarca->tratarNomenclatura();
        
        //instancia classe
        $sMarca = new sMarca();
        $sMarca->setNomeCampo('nomenclatura');
        $sMarca->setValorCampo($marcaTratada);
        $sMarca->consultar('tMenu3_1.php');

        //compara os registros do BD com a nova solicitação
        if ($sMarca->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=marcaF3&codigo=A10");
            exit();
        }
        
        if(strlen($marcaTratada) < 5){
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=marcaF3&codigo=A16");
            exit();
        }
        
        //inserir novo registro no BD
        $sMarca->inserir('tMenu3_1.php');
        
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=marcaF3&codigo=S4");
        exit();
    }    
    //registrar modelo
    if ($_POST['formulario'] == 'f4') {
        $pagina = $_POST['paginaF4'];
        $acao = $_POST['acaoF4'];
        $idUsuario = $_SESSION['credencial']['idUsuario'];
        $modelo = $_POST['modeloF4'];
        $idMarca = $_POST['marcaF4'];

        //alimenta a tabela de histórico
        alimentaHistorico($pagina, $acao, 'modelo', null, $modelo, $idUsuario);

        //tratamento de dados
        $tratamentoModelo = new sTratamentoDados($modelo);
        $modeloTratado = $tratamentoModelo->tratarNomenclatura();
        
        //instancia classe
        $sModelo = new sModelo();
        $sModelo->setNomeCampo('nomenclatura', 'marca_idmarca');
        $sModelo->setValorCampo($modeloTratado, $idMarca);
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
            'marca_idmarca' => $idMarca
        ];
        $sModelo->inserir('tMenu3_1.php', $dados);
        
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=3_1&campo=modeloF4&codigo=S4");
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
