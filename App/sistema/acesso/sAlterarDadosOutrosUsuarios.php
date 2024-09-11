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
    sSetor
};

//verifica se tem credencial para acessar o sistema
if (!isset($_SESSION['credencial'])) {
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}

if (isset($_POST['pagina'])) {
    if ($_POST['pagina'] != 'tMenu1_2_1.php') {
        //solicitar saída com tentativa de violação
        $sSair = new sSair();
        $sSair->verificar('0');
    }
    
    //receber valores para alteração
    $idUsuario = $_SESSION['credencial']['idUsuario'];
    $idUsuarioAlterar = $_POST['idUsuario'];
    $pagina = $_POST['pagina'];
    $acao = $_POST['acao'];
    //$imagem = $_POST['imagem']; próxima building
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $sexo = $_POST['sexo'];
    $telefone = $_POST['telefone'];
    isset($_POST['whatsApp']) ? $whatsApp = 1 : $whatsApp = 0;
    $email = $_POST['email'];
    $idCargo = $_POST['cargo'];
    $idPermissao = $_POST['permissao'];
    $idSecretaria = $_POST['secretaria'];
    $idDepartamento = $_POST['departamento'];
    $idCoordenacao = $_POST['coordenacao'];
    $idSetor = $_POST['setor'];
    isset($_POST['situacao']) ? $situacao = 1 : $situacao = 0;
    $atualizar = [];
    
    //buscando dados anteriores do usuário para posterior comparação com os dados passados
    $sUsuario = new sUsuario();
    $sUsuario->setIdUsuario($idUsuarioAlterar);
    $sUsuario->consultar('tMenu1_2_1.php');
    
    foreach ($sUsuario->mConexao->getRetorno() as $value) {
        $nome == $value['nome'] ? $nome = false : $atualizar = ['nome' => $nome];
        $sobrenome == $value['sobrenome'] ? $sobrenome = false : $atualizar = ['sobrenome' => $sobrenome];
        $sexo == $value['sexo'] ? $sexo = false : $sexo = $value['sexo'];
        //$imagem = $value['imagem'];
        $situacao == $value['situacao'] ? $situacao = false : $atualizar = ['situacao' => $situacao];
        $idSetor == $value['cargo_idcargo'] ? $idSetor = false : $atualizar = ['idSetor' => $idSetor];
        $idCoordenacao == $value['coordenacao_idcoordenacao'] ? $idCoordenacao = false : $atualizar = ['idCoordenacao' => $idCoordenacao];
        $idDepartamento == $value['departamento_iddepartamento'] ? $idDepartamento = false : $atualizar = ['idDepartamento' => $idDepartamento];
        $idSecretaria == $value['secretaria_idsecretaria'] ? $idSecretaria = false : $atualizar = ['idSecretaria' => $idSecretaria];        
        $idTelefone =$value['telefone_idtelefone'];
        $idCargo == $value['cargo_idcargo'] ? $idCargo = false : $atualizar = ['idCargo' => $idCargo];
        $idEmail = $value['email_idemail'];
        $idPermissao == $value['permissao_idpermissao'] ? $idPermissao = false : $atualizar = ['idPermissao' => $idPermissao];
    }
    
    //busca os dados do id do telefone
    $sTelefone = new sTelefone($idTelefone, 0, 'usuario');
    $sTelefone->consultar('tMenu1_2_1.php');
    
    $sTratamentoTelefone = new sTratamentoDados($telefone);
    $telefoneTratado = $sTratamentoTelefone->tratarTelefone();
    
    foreach ($sTelefone->mConexao->getRetorno() as $value) {
        $telefoneTratado == $value['numero'] ? $telefoneTratado = false : $atualizar = ['telefone' => $telefoneTratado];
        if($whatsApp != $value['whatsApp']){
            $atualizar = [
                'whatsApp' => $whatsApp
            ];
        }
    }
        
    //busca os dados do id do email
    $sEmail = new sEmail($idEmail, 'email');
    $sEmail->consultar('tMenu1_2_1.php');
    
    foreach ($sEmail->mConexao->getRetorno() as $value) {
        $emailTratado == $value['email'] ? $email = false : $atualizar = ['email' => $emailTratado];
    }
    
    //busca os dados do id do cargo
    $sCargo = new sCargo($idCargo);
    $sCargo->consultar('tMenu1_2_1.php');
    
    
    //etapa3 - verificar campos alterados
    if ($sUsuario->getNome() != $nome) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $sUsuario->getNome();
        alimentaHistorico($pagina, $acao, 'nome', $valorCampoAnterior, $nome, $idUsuarioSolicitante);
        exit();
        
        //etapa4 - validação do conteúdo
        $sUsuario->verificarNome($nome);
        if (!$sUsuario->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=nome&codigo={$sUsuario->getSNotificacao()->getCodigo()}");
            exit();
        } else {
            //etapa5 - atualizar os dados
            $alteracao = true;
            $atualizar['nome'] = $nome;
        }
    }
        
    if ($sUsuario->getSobrenome() != $sobrenome) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $sUsuario->getSobrenome();
        alimentaHistorico($pagina, $acao, 'sobrenome', $valorCampoAnterior, $sobrenome, $idUsuarioSolicitante);
               
        //etapa4 - validação do conteúdo
        $sUsuario->verificarSobrenome($sobrenome);
        if (!$sUsuario->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=sobrenome&codigo={$sUsuario->getSNotificacao()->getCodigo()}");
            exit();
        } else {
            //etapa5 - atualizar os dados
            $alteracao = true;
            $atualizar['sobrenome'] = $sobrenome;
        }
    }
    
    if ($sUsuario->getSexo() != $sexo) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $sUsuario->getSexo();
        alimentaHistorico($pagina, $acao, 'sexo', $valorCampoAnterior, $sexo, $idUsuarioSolicitante);

        //etapa4 - atualizar os dados
        $alteracao = true;
        $atualizar['sexo'] = $sexo;
    }
    
    if ($sTelefone->getNumero() != $telefoneTratado) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $sUsuario->getTelefone();
        alimentaHistorico($pagina, $acao, 'telefone', $valorCampoAnterior, $telefoneTratado, $idUsuarioSolicitante);
        
        //etapa4 - validação do conteúdo        
        $sTelefone->verificarTelefone($telefoneTratado);
        if (!$sTelefone->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=telefone&codigo={$sTelefone->getSNotificacao()->getCodigo()}");
            exit();
        } else {
            //etapa5 - atualizar os dados
            $alteracao = true;
            $atualizar['telefone'] = $telefoneTratado;
        }
    }    
    
    if ($sTelefone->getWhatsApp() != $whatsApp) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $sTelefone->getWhatsApp();
        alimentaHistorico($pagina, $acao, 'whatsApp', $valorCampoAnterior, $whatsApp, $idUsuarioSolicitante);

        //etapa4 - atualizar os dados
        $alteracao = true;
        $atualizar['whatsApp'] = $whatsApp;
    }

    if ($sEmail->getNomenclatura() != $email) {
        /*
        $sTratamentoEmail = new sTratamentoDados($email);
        $validaEmail = $sTratamentoEmail->tratarEmail();

        $seguranca = base64_encode($idUsuario);

        if(!$validaEmail){
            $sConfiguracao = new sConfiguracao();
            $sNotificacao = new sNotificacao('A2');
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&seguranca={$seguranca}&campo=email&codigo={$sNotificacao->getCodigo()}");
            exit();
        }
         * 
         */
        
        //insere dados na tabela histórico
        $valorCampoAnterior = $sEmail->getNomenclatura();
        alimentaHistorico($pagina, $acao, 'nomenclatura', $valorCampoAnterior, $email, $idUsuarioSolicitante);
        
        //etapa4 - validação de conteúdo
        $sEmail->setNomenclatura($email);
        $sEmail->verificar('tMenu1_2_1.php');  
        if (!$sEmail->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=email&codigo={$sEmail->getSNotificacao()->getCodigo()}");
            exit();
        } else {
            //etapa5 - atualizar os dados
            $alteracao = true;
            $atualizar['email'] = $email;
        }
    }
    
    if ($sUsuario->getIdCargo() != $idCargo) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $sUsuario->getIdCargo();
        alimentaHistorico($pagina, $acao, 'cargo_idcargo', $valorCampoAnterior, $idCargo, $idUsuarioSolicitante);

        //etapa4 - atualizar os dados
        $alteracao = true;
        $atualizar['idCargo'] = $idCargo;
    }    
    
    if ($sUsuario->getIdPermissao() != $idPermissao) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $idPermissao;
        alimentaHistorico($pagina, $acao, 'permissao_idpermissao', $valorCampoAnterior, $idPermissao, $idUsuario);

        //etapa4 - atualizar os dados
        $alteracao = true;
        $atualizar['idPermissao'] = $idPermissao;
    }
    
    if ($sUsuario->getSituacao() != $situacao) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $sUsuario->getSituacao();
        alimentaHistorico($pagina, $acao, 'situacao', $valorCampoAnterior, $situacao, $idUsuarioSolicitante);

        //etapa4 - atualizar os dados
        $alteracao = true;
        $atualizar['situacao'] = $situacao;
    }
    
    if ($sUsuario->getIdSecretaria() != $idSecretaria) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $sUsuario->getIdSecretaria();
        alimentaHistorico($pagina, $acao, 'secretaria_idsecretaria', $valorCampoAnterior, $idSecretaria, $idUsuarioSolicitante);
        echo $valorCampoAnterior = $sEmailSecretariaAnterior->getIdEmail();
        alimentaHistorico($pagina, $acao, 'email', $valorCampoAnterior, $sEmailSecretariaAtual->getIdEmail(), $idUsuarioSolicitante);
        exit();
        //etapa4 - atualizar os dados
        $alteracao = true;
        $atualizar['idSecretaria'] = $idSecretaria;
    }
    
    if ($sUsuario->getIdDepartamento() != $idDepartamento) {
        //insere dados na tabela histórico
        if($idDepartamento == 0){
            $idDepartamento = '';
        }
        $valorCampoAnterior = $sUsuario->getIdDepartamento();
        alimentaHistorico($pagina, $acao, 'departamento_iddepartamento', $valorCampoAnterior, $idDepartamento, $idUsuarioSolicitante);

        //etapa4 - atualizar os dados
        $alteracao = true;
        $atualizar['idDepartamento'] = $idDepartamento;
    }
    
    if ($sUsuario->getIdCoordenacao() != $idCoordenacao && $idCoordenacao != 0) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $sUsuario->getIdCoordenacao();
        alimentaHistorico($pagina, $acao, 'coordenacao_idcoordenacao', $valorCampoAnterior, $idCoordenacao, $idUsuarioSolicitante);

        //etapa4 - atualizar os dados
        $alteracao = true;
        $atualizar['idCoordenacao'] = $idCoordenacao;
    }
    
    if ($sUsuario->getIdSetor() != $idSetor && $idSetor != 0) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $sUsuario->getIdSetor();
        alimentaHistorico($pagina, $acao, 'setor_idsetor', $valorCampoAnterior, $idSetor, $idUsuarioSolicitante);

        //etapa4 - atualizar os dados
        $alteracao = true;
        $atualizar['idSetor'] = $idSetor;
    }
    
    //QA - início da área de testes
    /* verificar o que tem no objeto

      echo "<pre>";
      echo var_dump($_SESSION['credencial']);
      echo "</pre>";
      
      echo "<pre>";
      echo var_dump($alteracao);
      echo "</pre>";
      exit();
      // */
    //QA - fim da área de testes
    
    //etapa5 - alterar os dados
    if ($alteracao == false) {
        //se não tem campo para validar
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}");
    }else{        
        //se tem campos para atualizar
        if (array_key_exists('nome', $atualizar)) {
            //atualize o campo nome
            $sUsuario->setIdUsuario($idUsuario);
            $sUsuario->setNomeCampo('nome');
            $sUsuario->setValorCampo($nome);
            $sUsuario->alterar('tMenu1_2_1.php');
                        
            if ($sUsuario->mConexao->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=nome&codigo={$sUsuario->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('sobrenome', $atualizar)) {
            //atualize o campo sobrenome
            $sUsuario->setIdUsuario($idUsuario);
            $sUsuario->setNomeCampo('sobrenome');
            $sUsuario->setValorCampo($sobrenome);
            $sUsuario->alterar('tMenu1_2_1.php');
            
            if ($sUsuario->mConexao->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=sobrenome&codigo={$sUsuario->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('sexo', $atualizar)) {
            //atualize o campo sexo
            $sUsuario->setIdUsuario($idUsuario);
            $sUsuario->setNomeCampo('sexo');
            $sUsuario->setValorCampo($sexo);
            $sUsuario->alterar('tMenu1_2_1.php');
            
            if ($sUsuario->mConexao->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=sexo&codigo={$sUsuario->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('telefone', $atualizar)) {
            //atualize o campo telefone
            $sTelefone->setIdTelefone($sUsuario->getTelefone());
            $sTelefone->setNomeCampo('numero');
            $sTelefone->setValorCampo($telefoneTratado);
            $sTelefone->alterar('tMenu1_2_1.php');
            
            if ($sTelefone->mConexao->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=telefone&codigo={$sTelefone->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('whatsApp', $atualizar)) {
            //atualize o campo whatsApp
            $sTelefone->setIdTelefone($sUsuario->getTelefone());
            $sTelefone->setNomeCampo('whatsApp');
            $sTelefone->setValorCampo($whatsApp);
            $sTelefone->alterar('tMenu1_2_1.php');
            
            if ($sTelefone->mConexao->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=whatsApp&codigo={$sTelefone->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('email', $atualizar)) {
            //atualize o campo email
            $sEmail->setIdEmail($sUsuario->getIdEmail());
            $sEmail->setNomeCampo('nomenclatura');
            $sEmail->setValorCampo($email);
            $sEmail->alterar('tMenu1_2_1.php');
            
            if ($sEmail->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=email&codigo={$sEmail->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('idCargo', $atualizar)) {
            //atualize o campo cargo
            $sUsuario->setIdUsuario($idUsuario);
            $sUsuario->setNomeCampo('cargo_idcargo');
            $sUsuario->setValorCampo($idCargo);
            $sUsuario->alterar('tMenu1_2_1.php');
            
            if ($sUsuario->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=cargo&codigo={$sUsuario->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('idPermissao', $atualizar)) {
            //atualize o campo cargo
            $sUsuario->setIdUsuario($idUsuario);
            $sUsuario->setNomeCampo('permissao_idpermissao');
            $sUsuario->setValorCampo($idPermissao);
            $sUsuario->alterar('tMenu1_2_1.php');
            
            if ($sUsuario->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=permissao&codigo={$sUsuario->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('idSecretaria', $atualizar)) {
            //atualize o campo cargo
            $sUsuario->setIdUsuario($idUsuario);
            $sUsuario->setNomeCampo('secretaria_idsecretaria');
            $sUsuario->setValorCampo($idSecretaria);
            $sUsuario->alterar('tMenu1_2_1.php');
            
            if ($sUsuario->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=secretaria&codigo={$sUsuario->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('idDepartamento', $atualizar)) {
            //atualize o campo cargo
            if(empty($idDepartamento)){
                $idDepartamento = 'null';
            }
            
            $sUsuario->setIdUsuario($idUsuario);
            $sUsuario->setNomeCampo('departamento_iddepartamento');
            $sUsuario->setValorCampo($idDepartamento);
            $sUsuario->alterar('tMenu1_2_1.php');
            
            if ($sUsuario->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=departamento&codigo={$sUsuario->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('idCoordenacao', $atualizar)) {
            //atualize o campo cargo
            if(empty($idCoordenacao)){
                $idCoordenacao = 'null';
            }
            
            $sUsuario->setIdUsuario($idUsuario);
            $sUsuario->setNomeCampo('coordenacao_idcoordenacao');
            $sUsuario->setValorCampo($idCoordenacao);
            $sUsuario->alterar('tMenu1_2_1.php');
            
            if ($sUsuario->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=coordenacao&codigo={$sUsuario->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('idSetor', $atualizar)) {
            //atualize o campo cargo
            if(empty($idSetor)){
                $idSetor = 'null';
            }
            
            $sUsuario->setIdUsuario($idUsuario);
            $sUsuario->setNomeCampo('setor_idsetor');
            $sUsuario->setValorCampo($idSetor);
            $sUsuario->alterar('tMenu1_2_1.php');
            
            if ($sUsuario->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=setor&codigo={$sUsuario->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('situacao', $atualizar)) {
            //atualize o campo situacao
            $sUsuario->setIdUsuario($idUsuario);
            $sUsuario->setNomeCampo('situacao');
            $sUsuario->setValorCampo($situacao);
            $sUsuario->alterar('tMenu1_2_1.php');
            
            if ($sUsuario->mConexao->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_2_1&id={$idUsuario}&campo=situacao&codigo={$sUsuario->getSNotificacao()->getCodigo()}");
            }
        }
    }
}else{
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
    $sHistorico->inserir('tMenu1_1_1.php', $tratarDados);
}
?>