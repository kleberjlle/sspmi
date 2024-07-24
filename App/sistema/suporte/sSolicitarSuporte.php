<?php

session_start();

require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sSair,
    sHistorico,
    sConfiguracao,
    sSecretaria,
    sDepartamento,
    sCoordenacao,
    sSetor,
    sTratamentoDados
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
    $acessoRemoto = $_POST['acessoRemotoF1'];
    isset($_POST['patrimonioF1']) ? $patrimonio = 'Indefinido' : $patrimonio = $_POST['patrimonioF1'];
    $idLocal = $_POST['localF1'];
    $idPrioridade = $_POST['prioridadeF1'];
    $descricao = $_POST['descricaoF1'];
    
    //verifica se serão passados os dados do solicitante ou do requerente
    if ($meusDados) {
        $nome = $_SESSION['credencial']['nome'];
        $sobrenome = $_SESSION['credencial']['sobrenome'];
        $telefone = $_SESSION['credencial']['telefoneUsuario'];
        $whatsApp = $_SESSION['credencial']['whatsAppUsuario'];
        $email = $_SESSION['credencial']['emailUsuario'];
        $idSecretaria = $_SESSION['credencial']['idSecretaria'];
        $idDepartamento = $_SESSION['credencial']['idDepartamento'];
        $idCoordenacao = $_SESSION['credencial']['idCoordenacao'];
        $idSetor = $_SESSION['credencial']['idSetor'];
    } else {
        $nome = $_POST['nomeF1'];
        $sobrenome = $_POST['sobrenomeF1'];
        $telefone = $_POST['telefoneF1'];
        $whatsApp = $_POST['whatsAppF1'];
        $email = $_POST['emailF1'];
        $idSecretaria = $_POST['secretariaF1'];
        $idDepartamento = $_POST['departamentoF1'];
        $idCoordenacao = $_POST['coordenacaoF1'];
        $idSetor = $_POST['setorF1'];
    }
    
    //instancia as configurações do sistema
    $sConfiguracao = new sConfiguracao();
    
    //trata os dados para inserção no bd
    $sTratamentoNome = new sTratamentoDados($nome);
    $nomeTratado = $sTratamentoNome->tratarNomenclatura();
    
    //trata os dados para inserção no bd
    $sTratamentoSobreNome = new sTratamentoDados($sobrenome);
    $sobreNomeTratado = $sTratamentoSobreNome->tratarNomenclatura();

    //trata os dados para inserção no bd
    $sTratamentoTelefone = new sTratamentoDados($telefone);
    $telefoneTratado = $sTratamentoTelefone->tratarTelefone();
    
    //trata os dados para inserção no bd
    $sTratamentoEmail = new sTratamentoDados($email);
    $emailTratado = $sTratamentoEmail->tratarEmail();
    
    //trata os dados para inserção no bd
    $sTratamentoPatrimonio = new sTratamentoDados($patrimonio);
    $patrimonioTratado = $sTratamentoPatrimonio->tratarPatrimonio();

    //buscar nomenclatura dos locais
    if ($idSecretaria == 0) {
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=2_1&campo=secretariaF1&codigo=A17");
        exit();
    }
    $sSecretaria = new sSecretaria($idSecretaria);
    $sSecretaria->consultar('tMenu2_1.php');
    $secretaria = $sSecretaria->getNomenclatura();

    if ($idDepartamento == 0) {
        $departamento = '--';
    } else {
        $sDepartamento = new sDepartamento($idDepartamento);
        $sDepartamento->consultar('tMenu2_1.php');
        $departamento = $sDepartamento->getNomenclatura();
    }

    if ($idCoordenacao == 0) {
        $coordenacao = '--';
    } else {
        $sCoordenacao = new sCoordenacao($idCoordenacao);
        $sCoordenacao->consultar('tMenu2_1.php');
        $coordenacao = $sCoordenacao->getNomenclatura();
    }

    if ($idSetor == 0) {
        $setor = '--';
    } else {
        $sSetor = new sSetor($idSetor);
        $sSetor->consultar('tMenu2_1.php');
        $setor = $sSetor->getNomenclatura();
    }

    //busca id do equipamento
    $sEquipamento = new sEquipamento();
    $sEquipamento->setNomeCampo('patrimonio');
    $sEquipamento->setValorCampo($patrimonioTratado);
    $sEquipamento->consultar('tMenu2_1.php');

    if ($sEquipamento->getValidador()) {
        foreach ($sEquipamento->mConexao->getRetorno() as $linha) {
            if ($linha['patrimonio'] == $patrimonio) {
                $idEquipamento = $linha['idequipamento'];
            }
        }
    } else {
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
    alimentaHistorico($pagina, $acao, 'secretaria', $valorCampoAnterior, $secretaria, $idUsuario);
    alimentaHistorico($pagina, $acao, 'departamento', $valorCampoAnterior, $departamento, $idUsuario);
    alimentaHistorico($pagina, $acao, 'coordenacao', $valorCampoAnterior, $coordenacao, $idUsuario);
    alimentaHistorico($pagina, $acao, 'setor', $valorCampoAnterior, $setor, $idUsuario);

    //inserir dados na tabela protocolo
    $dadosProtocolo = [
        'nomeDoRequerente' => $nomeTratado,
        'sobrenomeDoRequerente' => $sobreNomeTratado,
        'telefoneDoRequerente' => $telefoneTratado,
        'whatsAppDoRequerente' => $whatsApp,
        'emailDoRequerente' => $emailTratado,
        'usuario_idusuario' => $idUsuario,
        'secretaria' => $secretaria,
        'departamento' => $departamento,
        'coordenacao' => $coordenacao,
        'setor' => $setor
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
    if ($sEtapa->getValidador()) {
        foreach ($sEtapa->mConexao->getRetorno() as $linha) {
            if ($linha['numero'] > $numero) {
                $numero = $linha['numero'];
            }
        }
    } else {
        $numero++;
    }

    //gerar histórico dos campos da etapa
    alimentaHistorico($pagina, $acao, 'equipamento_idequipamento', $valorCampoAnterior, $idEquipamento, $idUsuario);
    alimentaHistorico($pagina, $acao, 'protocolo_idprotocolo', $valorCampoAnterior, $idProtocolo, $idUsuario);
    alimentaHistorico($pagina, $acao, 'local_idlocal', $valorCampoAnterior, $idLocal, $idUsuario);

    //registra os dados na tabela etapa
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

    //redireciona para o formulário com mensagem de sucesso
    header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=2_1&campo=secretariaF1&codigo=S4");
    exit();
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
