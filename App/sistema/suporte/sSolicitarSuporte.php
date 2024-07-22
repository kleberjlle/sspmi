<?php

session_start();

require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sSair,
    sHistorico,
    sConfiguracao
};

use App\sistema\suporte\{
    sProtocolo
};

//verifica se tem credencial para acessar o sistema
if (!isset($_SESSION['credencial'])) {
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}

if (isset($_POST['formulario'])) {    
    //verifica se é para abrir o chamado com os dados do solicitante ou do representante
    $pagina = $_POST['paginaF1'];
    $acao = $_POST['acaoF1'];
    $idUsuario = $_SESSION['credencial']['idUsuario'];
    $valorCampoAnterior = '';
    isset($_POST['meusDados']) ? $meusDados = $_POST['meusDados'] : $meusDados = false;
    $nome = $_SESSION['credencial']['nome'];
    $sobrenome = $_SESSION['credencial']['sobrenome'];
    $telefone = $_SESSION['credencial']['telefoneUsuario'];
    $whatsApp = $_SESSION['credencial']['whatsAppUsuario'];
    $email = $_SESSION['credencial']['emailUsuario'];
    $idSolicitante = $_SESSION['credencial']['idUsuario'];
    
    //verifica de qual formulário os dados vieram
    if($_POST['formulario'] == 'f1'){
        //verifica se serão passados os dados do solicitante ou do requerente
        if($meusDados){
            //gerar histórico dos campos do solicitante ou requerente
            alimentaHistorico($pagina, $acao, 'nomeDoRequerente', $valorCampoAnterior, $nome, $idUsuario);
            alimentaHistorico($pagina, $acao, 'sobrenomeDoRequerente', $valorCampoAnterior, $sobrenome, $idUsuario);
            alimentaHistorico($pagina, $acao, 'telefoneDoRequerente', $valorCampoAnterior, $telefone, $idUsuario);
            alimentaHistorico($pagina, $acao, 'whatsAppDoRequerente', $valorCampoAnterior, $whatsApp, $idUsuario);
            alimentaHistorico($pagina, $acao, 'emailDoRequerente', $valorCampoAnterior, $email, $idUsuario);
            alimentaHistorico($pagina, $acao, 'usuario_idusuario', $valorCampoAnterior, $idSolicitante, $idUsuario);
            
            //gerar protocolo
            $dadosProtocolo = [
                'nomeDoRequerente' => $nome,
                'sobrenomeDoRequerente' => $sobrenome,
                'telefoneDoRequerente' => $telefone,
                'whatsAppDoRequerente' => $whatsApp,
                'emailDoRequerente' => $email,
                'usuario_idusuario' => $idSolicitante
            ];
                      
        }else{
            echo 'dados do requerente';
        }
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