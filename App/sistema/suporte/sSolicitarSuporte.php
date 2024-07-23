<?php

session_start();

require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sSair,
    sHistorico,
    sConfiguracao
};

use App\sistema\suporte\{
    sEquipamento,
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
    $acessoRemoto = $_POST['acessoRemotoF1'];
    $patrimonio = $_POST['patrimonioF1'];
    $prioridade = $_POST['prioridadeF1'];
    $descricao = $_POST['descricaoF1'];
    
    $sProtocolo = new sProtocolo();
    
    //busca id do equipamento
    $sEquipamento = new sEquipamento();
    $sEquipamento->setNomeCampo('patrimonio');
    $sEquipamento->setValorCampo($patrimonio);
    $sEquipamento->consultar('tMenu2_1.php');
    
    if($sEquipamento->getValidador()){
        foreach ($sCargo->mConexao->getRetorno() as $linha) {
            if ($linha['patrimonio'] == $patrimonio) {
                $idEquipamento = $linha['idequipamento'];
            }else{
                $idEquipamento = 0;
            }
        }
    }
    
    //verifica se serão passados os dados do solicitante ou do requerente
    if($meusDados){
        //gerar histórico dos campos do solicitante ou requerente
        alimentaHistorico($pagina, $acao, 'nomeDoRequerente', $valorCampoAnterior, $nome, $idUsuario);
        alimentaHistorico($pagina, $acao, 'sobrenomeDoRequerente', $valorCampoAnterior, $sobrenome, $idUsuario);
        alimentaHistorico($pagina, $acao, 'telefoneDoRequerente', $valorCampoAnterior, $telefone, $idUsuario);
        alimentaHistorico($pagina, $acao, 'whatsAppDoRequerente', $valorCampoAnterior, $whatsApp, $idUsuario);
        alimentaHistorico($pagina, $acao, 'emailDoRequerente', $valorCampoAnterior, $email, $idUsuario);
        alimentaHistorico($pagina, $acao, 'usuario_idusuario', $valorCampoAnterior, $idSolicitante, $idUsuario);
        alimentaHistorico($pagina, $acao, 'acessoRemoto', $valorCampoAnterior, $acessoRemoto, $idUsuario);
        alimentaHistorico($pagina, $acao, 'patrimonio', $valorCampoAnterior, $patrimonio, $idUsuario);
        alimentaHistorico($pagina, $acao, 'prioridade', $valorCampoAnterior, $prioridade, $idUsuario);
        alimentaHistorico($pagina, $acao, 'descricao', $valorCampoAnterior, $descricao, $idUsuario);

        //inserir dados na tabela protocolo
        $dadosProtocolo = [
            'nomeDoRequerente' => $nome,
            'sobrenomeDoRequerente' => $sobrenome,
            'telefoneDoRequerente' => $telefone,
            'whatsAppDoRequerente' => $whatsApp,
            'emailDoRequerente' => $email,
            'usuario_idusuario' => $idSolicitante
        ];
        
        $sProtocolo->inserir('tMenu2_1.php', $dadosProtocolo);
        $idProtocolo = $sProtocolo->mConexao->getRegistro();
        
        $dadosEtapa = [
            'acessoRemoto' => $acessoRemoto,
            'descricao' => $descricao,
            'equipamento_idequipamento' => $idEquipamento,
            'protocolo_idprotocolo' => $idProtocolo,
            ''
        ];

    }else{
        echo 'dados do requerente';
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