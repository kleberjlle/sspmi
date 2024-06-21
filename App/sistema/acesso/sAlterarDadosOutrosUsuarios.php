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
    sCargo
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
    
    //etapa1 - receber valores
    $idUsuarioSolicitante = $_SESSION['credencial']['idUsuario'];
    $idUsuario = $_POST['idUsuario'];
    $pagina = $_POST['pagina'];
    $acao = $_POST['acao'];
    //$imagem = $_POST['imagem']; próxima build
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $sexo = $_POST['sexo'];
    $telefone = $_POST['telefoneUsuario'];
    isset($_POST['whatsAppUsuario']) ? $whatsApp = 1 : $whatsApp = 0;
    $email = $_POST['emailUsuario'];
    $idCargo = $_POST['cargo'];
    $idPermissao = $_POST['permissao'];
    $idSecretaria = $_POST['secretaria'];
    $idDepartamento = $_POST['departamento'];
    $idCoordenacao = $_POST['coordenacao'];
    $idSetor = $_POST['setor'];
    isset($_POST['situacao']) ? $situacao = 1 : $situacao = 0;
    $atualizar = [];
    $alteracao = false;
    
    //etapa2 - buscando dados anteriores do usuário para posterior comparação com os dados passados
    $sUsuario = new sUsuario();
    $sUsuario->setNomeCampo('idusuario');
    $sUsuario->setValorCampo($idUsuario);
    $sUsuario->consultar('tMenu1_2_1.php');
    
    $sTelefone = new sTelefone($sUsuario->getTelefone(), 0, 'usuario');
    $sTelefone->consultar('tMenu1_2_1.php');
    $telefoneTratado = $sTelefone->tratarTelefone($telefone);
    
    $sEmail = new sEmail($sUsuario->getIdEmail(), 'email');
    $sEmail->consultar('tMenu1_2_1.php');
    
    $sCargo = new sCargo($idCargo);
    $sCargo->consultar('tMenu1_2_1.php');
        
    //etapa3 - verificar campos alterados
    if ($sUsuario->getNome() != $nome) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $sUsuario->getNome();
        alimentaHistorico($pagina, $acao, 'nome', $valorCampoAnterior, $nome, $idUsuarioSolicitante);
        
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

        //etapa4 - atualizar os dados
        $alteracao = true;
        $atualizar['secretaria'] = $idSecretaria;
    }
    
    if ($sUsuario->getIdDepartamento() != $idDepartamento && $idDepartamento != 0) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $sUsuario->getIdDepartamento();
        alimentaHistorico($pagina, $acao, 'departamento_iddepartamento', $valorCampoAnterior, $idDepartamento, $idUsuarioSolicitante);

        //etapa4 - atualizar os dados
        $alteracao = true;
        $atualizar['departamento'] = $idDepartamento;
    }
    
    if ($sUsuario->getIdCoordenacao() != $idCoordenacao && $idCoordenacao != 0) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $sUsuario->getIdCoordenacao();
        alimentaHistorico($pagina, $acao, 'coordenacao_idcoordenacao', $valorCampoAnterior, $idCoordenacao, $idUsuarioSolicitante);

        //etapa4 - atualizar os dados
        $alteracao = true;
        $atualizar['coordenacao'] = $idCoordenacao;
    }
    
    if ($sUsuario->getIdSetor() != $idSetor && $idSetor != 0) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $sUsuario->getIdSetor();
        alimentaHistorico($pagina, $acao, 'setor_idsetor', $valorCampoAnterior, $idSetor, $idUsuarioSolicitante);

        //etapa4 - atualizar os dados
        $alteracao = true;
        $atualizar['setor'] = $idSetor;
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
            //atualize o campo nome
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
            //atualize o campo nome
            $sSexoUsuario->setIdUsuario($idUsuario);
            $sSexoUsuario->setNomeCampo('sexo');
            $sSexoUsuario->setValorCampo($sexo);
            $sSexoUsuario->alterar('tMenu1_1_1.php');
            
            //atualize a sessão nome
            $sexo == 'M' ? $sexo = 'Masculino' : $sexo = 'Feminino';
            $_SESSION['credencial']['sexo'] = $sexo;
            
            if ($sSexoUsuario->mConexao->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=sexo&codigo={$sSexoUsuario->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('telefoneUsuario', $atualizar)) {
            //atualize o campo nome
            $sTelefoneUsuario->setNomeCampo('numero');
            $sTelefoneUsuario->setValorCampo($telefoneUsuario);
            $sTelefoneUsuario->alterar('tMenu1_1_1.php');
            
            //atualize a sessão nome
            $_SESSION['credencial']['telefoneUsuario'] = $telefoneUsuario;
            
            if ($sTelefoneUsuario->mConexao->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=telefone&codigo={$sTelefoneUsuario->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('whatsAppUsuario', $atualizar)) {
            //atualize o campo nome
            $sWhatsAppUsuario->setNomeCampo('whatsApp');
            $sWhatsAppUsuario->setValorCampo($whatsAppUsuario);
            $sWhatsAppUsuario->alterar('tMenu1_1_1.php');
            
            //atualize a sessão nome
            $_SESSION['credencial']['whatsAppUsuario'] = $whatsAppUsuario;
            
            if ($sWhatsAppUsuario->mConexao->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=whatsApp&codigo={$sWhatsAppUsuario->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('emailUsuario', $atualizar)) {
            //atualize o campo nome
            $sEmailUsuario->setIdEmail($_SESSION['credencial']['idEmailUsuario']);
            $sEmailUsuario->setNomeCampo('nomenclatura');
            $sEmailUsuario->setValorCampo($emailUsuario);
            $sEmailUsuario->alterar('tMenu1_1_1.php');
            
            //atualize a sessão nome
            $_SESSION['credencial']['emailUsuario'] = $emailUsuario;
            
            if ($sEmailUsuario->mConexao->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=email&codigo={$sEmailUsuario->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('idPermissao', $atualizar)) {
            //atualize o campo nome            
            $sPermissaoUsuario->setIdUsuario($idUsuario);
            $sPermissaoUsuario->setNomeCampo('permissao_idpermissao');
            $sPermissaoUsuario->setValorCampo($idPermissao);
            $sPermissaoUsuario->alterar('tMenu1_1_1.php');
            
            //atualize a sessão nome
            $_SESSION['credencial']['idPermissao'] = $idPermissao;
            //fazer consulta para retornar nomenclatura correta
            
            if ($sPermissaoUsuario->mConexao->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=permissao&codigo={$sPermissaoUsuario->getSNotificacao()->getCodigo()}");
            }
        }
        
        /* área para uso futuro
        if (array_key_exists('situacao', $atualizar)) {
            //atualize o campo nome            
            $sSituacaoUsuario->setIdUsuario($idUsuario);
            $sSituacaoUsuario->setNomeCampo('situacao');
            $sSituacaoUsuario->setValorCampo($situacao);
            $sSituacaoUsuario->alterar('tMenu1_1_1.php');
            
            var_dump($situacao);
            exit();
            //atualize a sessão nome
            $situacao == 1 ? $situacao = 'Ativo' : $situacao = 'Inativo';
            $_SESSION['credencial']['situacao'] = $situacao;
            //fazer consulta para retornar nomenclatura correta
            
            if ($sSituacaoUsuario->mConexao->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=situacao&codigo={$sSituacaoUsuario->getSNotificacao()->getCodigo()}");
            }
        }
         * 
         */
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