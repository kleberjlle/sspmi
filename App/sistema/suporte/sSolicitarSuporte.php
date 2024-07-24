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
    sProtocolo,
    sEtapa
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
    isset($_POST['patrimonioF1']) ? $patrimonio = 'Indefinido' : $patrimonio = $_POST['patrimonioF1'];
    $idLocal = $_POST['localF1'];
    $idPrioridade = $_POST['prioridadeF1'];
    $descricao = $_POST['descricaoF1'];
    
    //verifica se serão passados os dados do solicitante ou do requerente
    if(!$meusDados){
        $secretaria = $_POST['secretariaF1'];
        $departamento = $_POST['departamentoF1'];
        $coordenacao = $_POST['coordenacaoF1'];
        $setor = $_POST['setorF1'];
        
        
    }
    
         //busca id do equipamento
        $sEquipamento = new sEquipamento();
        $sEquipamento->setNomeCampo('patrimonio');
        $sEquipamento->setValorCampo($patrimonio);
        $sEquipamento->consultar('tMenu2_1.php');

        if($sEquipamento->getValidador()){
            foreach ($sEquipamento->mConexao->getRetorno() as $linha) {
                if ($linha['patrimonio'] == $patrimonio) {
                    $idEquipamento = $linha['idequipamento'];
                }
            }
        }else{
            foreach ($sEquipamento->mConexao->getRetorno() as $linha) {
                if ($linha['patrimonio'] == 'Indefinido') {
                    $idEquipamento = $linha['idequipamento'];
                }
            }
        }
        
        //gerar histórico dos campos do solicitante ou requerente
        alimentaHistorico($pagina, $acao, 'nomeDoRequerente', $valorCampoAnterior, $nome, $idUsuario);
        alimentaHistorico($pagina, $acao, 'sobrenomeDoRequerente', $valorCampoAnterior, $sobrenome, $idUsuario);
        alimentaHistorico($pagina, $acao, 'telefoneDoRequerente', $valorCampoAnterior, $telefone, $idUsuario);
        alimentaHistorico($pagina, $acao, 'whatsAppDoRequerente', $valorCampoAnterior, $whatsApp, $idUsuario);
        alimentaHistorico($pagina, $acao, 'emailDoRequerente', $valorCampoAnterior, $email, $idUsuario);
        alimentaHistorico($pagina, $acao, 'acessoRemoto', $valorCampoAnterior, $acessoRemoto, $idUsuario);
        alimentaHistorico($pagina, $acao, 'patrimonio', $valorCampoAnterior, $patrimonio, $idUsuario);
        alimentaHistorico($pagina, $acao, 'prioridade', $valorCampoAnterior, $idPrioridade, $idUsuario);
        alimentaHistorico($pagina, $acao, 'descricao', $valorCampoAnterior, $descricao, $idUsuario); 
        alimentaHistorico($pagina, $acao, 'usuario_idusuario', $valorCampoAnterior, $idSolicitante, $idUsuario);        
        
        //inserir dados na tabela protocolo
        $dadosProtocolo = [
            'nomeDoRequerente' => $nome,
            'sobrenomeDoRequerente' => $sobrenome,
            'telefoneDoRequerente' => $telefone,
            'whatsAppDoRequerente' => $whatsApp,
            'emailDoRequerente' => $email,
            'usuario_idusuario' => $idSolicitante
        ];
        
        //registra o protocolo
        $sProtocolo = new sProtocolo();
        $sProtocolo->inserir('tMenu2_1.php', $dadosProtocolo);
        $idProtocolo = $sProtocolo->mConexao->getRegistro();
        
        //consulta dados da etapa para determinar o seu número
        $sEtapa = new sEtapa();
        $sEtapa->setNomeCampo('protocolo_idprotocolo');
        $sEtapa->setValorCampo($idProtocolo);
        $sEtapa->consultar('tMenu2_1.php');
        
        //verifica se existe um número para seguir a sequência, caso não exista, cria o primeiro
        $numero = 0;
        if($sEtapa->getValidador()){            
            foreach ($sEtapa->mConexao->getRetorno() as $linha) {
                if ($linha['numero'] > $numero) {
                    $numero = $linha['numero'];
                }
            }
        }else{
            $numero++;
        }
        
        //gerar histórico dos campos da etapa
        alimentaHistorico($pagina, $acao, 'equipamento_idequipamento', $valorCampoAnterior, $idEquipamento, $idUsuario);
        alimentaHistorico($pagina, $acao, 'protocolo_idprotocolo', $valorCampoAnterior, $idProtocolo, $idUsuario);
        alimentaHistorico($pagina, $acao, 'local_idlocal', $valorCampoAnterior, $idLocal, $idUsuario);
                
        $dadosEtapa = [
            'numero' => $numero,
            'acessoRemoto' => $acessoRemoto,
            'descricao' => $descricao,
            'equipamento_idequipamento' => $idEquipamento,
            'protocolo_idprotocolo' => $idProtocolo,
            'local_idlocal' => $idLocal,
            'prioridade_idprioridade' => $idPrioridade
        ];
        
        $sEtapa->inserir('tMenu2_1.php', $dadosEtapa);
        
    
    
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