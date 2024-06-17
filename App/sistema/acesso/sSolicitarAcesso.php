<?php

require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sSair,
    sHistorico,
    sConfiguracao,
    sEmail,
    sCargo
};
if (isset($_POST['pagina'])) {
    if ($_POST['pagina'] != 'tSolicitarAcesso.php') {
        //solicitar saída com tentativa de violação
        $sSair = new sSair();
        $sSair->verificar('0');
    }
    $sConfiguracao = new sConfiguracao();

    $pagina = $_POST['pagina'];
    $acao = $_POST['acao'];
    $valorCampoAnterior = '';
    $idUsuario = '';
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $sexo = $_POST['sexo'];
    $telefone = $_POST['telefone'];
    isset($_POST['whatsApp']) ? $whatsApp = 1 : $whatsApp = 0;
    $email = $_POST['email'];
    $idSecretaria = $_POST['secretaria'];
    $idDepartamento = $_POST['departamento'];
    $idCoordenacao = $_POST['coordenacao'];
    $idSetor = $_POST['setor'];
    $idCargo = $_POST['cargo'];
    isset($_POST['termo']) ? $termo = 1 : $termo = 0;
    
    //registrar solicitação no sistema
    alimentaHistorico($pagina, $acao, 'nome', $valorCampoAnterior, $nome, $idUsuario);
    alimentaHistorico($pagina, $acao, 'sobrenome', $valorCampoAnterior, $sobrenome, $idUsuario);
    alimentaHistorico($pagina, $acao, 'sexo', $valorCampoAnterior, $sexo, $idUsuario);
    alimentaHistorico($pagina, $acao, 'telefone_idtelefone', $valorCampoAnterior, $telefone, $idUsuario);
    alimentaHistorico($pagina, $acao, 'whatsApp', $valorCampoAnterior, $whatsApp, $idUsuario);
    alimentaHistorico($pagina, $acao, 'secretaria', $valorCampoAnterior, $secretaria, $idUsuario);
    alimentaHistorico($pagina, $acao, 'departamento', $valorCampoAnterior, $departamento, $idUsuario);
    alimentaHistorico($pagina, $acao, 'coordenacao', $valorCampoAnterior, $coordenacao, $idUsuario);
    alimentaHistorico($pagina, $acao, 'setor', $valorCampoAnterior, $setor, $idUsuario);
    alimentaHistorico($pagina, $acao, 'cargo', $valorCampoAnterior, $cargo, $idUsuario);
    //verifica se o email já não está registrado
    $sEmail = new sEmail($email, '');
    $sEmail->verificar('tSolicitarAcesso.php');
    alimentaHistorico($pagina, $acao, 'email', $valorCampoAnterior, $email, $idUsuario);
    if(!$sEmail->getValidador()){
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tSolicitarAcesso.php?campo=email&codigo={$sEmail->getSNotificacao()->getCodigo()}");
        exit();
    }
    
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