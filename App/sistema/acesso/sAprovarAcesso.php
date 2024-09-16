<?php

session_start();
require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sSair,
    sConfiguracao,
    sHistorico,
    sUsuario,
    sTelefone,
    sEmail,
    sCargo,
    sTratamentoDados,
    sNotificacao,
    sSecretaria,
    sDepartamento,
    sCoordenacao,
    sSetor,
    sSolicitacao,
    sSenha
};

//verifica se tem credencial para acessar o sistema
if (!isset($_SESSION['credencial'])) {
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}

if (isset($_POST['pagina'])) {
    if ($_POST['pagina'] != 'tMenu1_3_1.php') {
        //solicitar saída com tentativa de violação
        $sSair = new sSair();
        $sSair->verificar('0');
    }
    
    $idSolicitacao = $_POST['idSolicitacao'];
    isset($_POST['situacao']) ? $situacao = 1 : $situacao = 0;
    $pagina = $_POST['pagina'];
    $acao = $_POST['acao'];
    $idUsuario = $_SESSION['credencial']['idUsuario'];
    
    //configura timezone para São Paulo
    $sConfiguracao = new sConfiguracao();
    $sConfiguracao->getTimeZone();
    $dataHoraExaminador = date("Y-m-d H:i:s");
    
    //alimenta o histórico
    alimentaHistorico($pagina, $acao, 'situacao', '', $situacao, $idUsuario);
    alimentaHistorico($pagina, $acao, 'examinador', '', $idUsuario, $idUsuario);    
    alimentaHistorico($pagina, $acao, 'dataHoraExaminador', '', $dataHoraExaminador, $idUsuario);    
    
    //altera os dados da solicitação
    $sSolicitacao = new sSolicitacao();
    $sSolicitacao->setIdSolicitacao($idSolicitacao);
    
    /*
    //altera o campo situação
    $sSolicitacao->setNomeCampo('situacao');
    $sSolicitacao->setValorCampo($situacao);
    $sSolicitacao->alterar($pagina);
    
    //altera o campo examinador
    $sSolicitacao->setNomeCampo('examinador');
    $sSolicitacao->setValorCampo($idUsuario);
    $sSolicitacao->alterar($pagina);
    
    //altera o campo dataHoraExaminador
    $sSolicitacao->setNomeCampo('dataHoraExaminador');
    $sSolicitacao->setValorCampo($dataHoraExaminador);
    $sSolicitacao->alterar($pagina);
* 
     */
    
    //consulta dados da solicitação
    $sSolicitacao->consultar($pagina);
     
    
    foreach ($sSolicitacao->mConexao->getRetorno() as $value) {
        $nome = $value['nome'];
        $sobrenome = $value['sobrenome'];
        $sexo = $value['sexo'];
        $telefone = $value['telefone'];
        $whatsApp = $value['whatsApp'];
        $email = $value['email'];
        $idSecretaria = $value['secretaria_idsecretaria'];
        $idDepartamento = $value['departamento_iddepartamento'];
        $idCoordenacao = $value['coordenacao_idcoordenacao'];
        $idSetor = $value['setor_idsetor'];
        $idCargo = $value['cargo_idcargo'];
        $situacao = $value['situacao'];
        $examinador = $value['examinador'];
        $dataHoraSolicitacao = $value['dataHoraSolicitacao'];
        $dataHoraExaminador = $value['dataHoraExaminador'];
    }
    
    //verifica os dados antes de inserir no bd
    //verifica nome
    $sUsuario = new sUsuario();
    $sUsuario->verificarNome($nome);
    
    if(!$sUsuario->getValidador()){
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_3&campo=nome&codigo={$sUsuario->getSNotificacao()->getCodigo()}");
        exit();
    }
    
    //verifica sobrenome
    $sUsuario->verificarSobrenome($sobrenome);
    
    if(!$sUsuario->getValidador()){
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_3&campo=sobrenome&codigo={$sUsuario->getSNotificacao()->getCodigo()}");
        exit();
    }
    
    //verifica sobrenome
    $sUsuario->verificarSobrenome($sobrenome);
    
    if(!$sUsuario->getValidador()){
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_3&campo=sobrenome&codigo={$sUsuario->getSNotificacao()->getCodigo()}");
        exit();
    }
    
    //insere dados do telefone
    $dados = [
        'whatsApp' => $whatsApp,
        'numero' => $telefone
    ];
    $sTelefone = new sTelefone(0, 0, 0);
    $sTelefone->inserir('tMenu1_3_1.php', $dados);
    $idTelefone = $sTelefone->mConexao->getRegistro();
    
    //gera senha para inserir no bd
    $sSenha = new sSenha(true);
    $sSenha->gerar();
    $sSenha->criptografar($sSenha->getSenha());
    
    //insere email e senha no bd
    $dados = [
        'nomenclatura' => $email,
        'senha' => $sSenha->getSenhaCriptografada()
    ];
    $sEmail = new sEmail($email, '');
    $sEmail->inserir($pagina, $dados);
    $idEmail = $sEmail->mConexao->getRegistro();    
    
    //dados do usuario
    $sUsuario->setNome($nome);
    $sUsuario->setSobrenome($sobrenome);
    $sUsuario->setSexo($sexo);
    $sUsuario->setSituacao($situacao);
    $sUsuario->setIdSetor($idSetor);
    $sUsuario->setIdSetor($idCoordenacao);
    $sUsuario->setIdSetor($idDepartamento);
    $sUsuario->setIdSetor($idSecretaria);
    $sUsuario->setIdTel($idTelefone);
    $sUsuario->setIdCargo($idCargo);
    $sUsuario->setIdEmail($idEmail);
    $sUsuario->setIdPermissao(1);
    
    //$sUsuario->inserir($pagina);
    
    
    //gera notificação e redireciona para a página
    $sNotificacao = new sNotificacao('S1');    
    header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_3&campo=verificar&codigo={$sNotificacao->getCodigo()}");
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
    $sHistorico->inserir('tMenu1_1_1.php', $tratarDados);
}
?>