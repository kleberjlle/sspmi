<?php

session_start();
require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sSair,
    sConfiguracao,
    sHistorico,
    sUsuario,
    sTelefone,
    sEmail
};

//verifica se tem credencial para acessar o sistema
if (!isset($_SESSION['credencial'])) {
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}

if (isset($_POST['pagina'])) {
    if ($_POST['pagina'] != 'tMenu1_1_1.php') {
        //solicitar saída com tentativa de violação
        $sSair = new sSair();
        $sSair->verificar('0');
    }

    
    $sTelefoneUsuario = new sTelefone($_SESSION['credencial']['idTelefoneUsuario'], 0, 'tMenu1_1_1.php');
    $sWhatsAppUsuario = new sTelefone($_SESSION['credencial']['idTelefoneUsuario'], 0, 'tMenu1_1_1.php');
    $idUsuario = $_SESSION['credencial']['idUsuario'];
    $pagina = $_POST['pagina'];
    $acao = $_POST['acao'];
    //$imagem = $_POST['imagem']; próxima build
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $sexo = $_POST['sexo'];
    $telefoneUsuario = $sTelefoneUsuario->tratarTelefone($_POST['telefoneUsuario']);
    isset($_POST['whatsAppUsuario']) ? $whatsAppUsuario = 1 : $whatsAppUsuario = 0;
    $emailUsuario = $_POST['emailUsuario'];
    isset($_POST['permissao']) ? $permissao = $_POST['permissao'] : $permissao = $_SESSION['credencial']['idPermissao'];
    isset($_POST['situacao']) ? $situacao = 'Ativo' : $situacao = 'Inativo';
    $atualizar = [];
    $alteracao = false;

    //etapa1 - verificar campos alterados
    if ($_SESSION['credencial']['nome'] != $nome) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $_SESSION['credencial']['nome'];
        alimentaHistorico($pagina, $acao, 'nome', $valorCampoAnterior, $nome, $idUsuario);
        $sUsuarioNome = new sUsuario();
        $sUsuarioNome->verificarNome($nome);

        //etapa2 - validação do conteúdo
        if (!$sUsuarioNome->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=nome&codigo={$sUsuarioNome->getSNotificacao()->getCodigo()}");
        } else {
            //etapa3 - atualizar os dados
            $alteracao = true;
            $atualizar['nome'] = $nome;
        }
    }

    if ($_SESSION['credencial']['sobrenome'] != $sobrenome) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $_SESSION['credencial']['sobrenome'];
        alimentaHistorico($pagina, $acao, 'sobrenome', $valorCampoAnterior, $sobrenome, $idUsuario);
        $sUsuarioSobrenome = new sUsuario();
        $sUsuarioSobrenome->verificarSobrenome($sobrenome);
        
        //etapa2 - validação do conteúdo
        if (!$sUsuarioSobrenome->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=sobrenome&codigo={$sUsuarioSobrenome->getSNotificacao()->getCodigo()}");
        } else {
            //etapa3 - atualizar os dados
            $alteracao = true;
            $atualizar['sobrenome'] = $sobrenome;
        }
    }

    if ($_SESSION['credencial']['sexo'] != $sexo) {
        $_POST['sexo'] == 'Masculino' ? $sexo = 'M' : $sexo = 'F';
        //insere dados na tabela histórico
        $_SESSION['credencial']['sexo'] == 'Masculino' ? $valorCampoAnterior = 'M' : $valorCampoAnterior = 'F';
        alimentaHistorico($pagina, $acao, 'sexo', $valorCampoAnterior, $sexo, $idUsuario);
        
        $sUsuarioSexo = new sUsuario();

        //etapa3 - atualizar os dados
        $alteracao = true;
        $atualizar['sexo'] = $sexo;
    }

    if ($_SESSION['credencial']['telefoneUsuario'] != $telefoneUsuario) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $_SESSION['credencial']['telefoneUsuario'];
        alimentaHistorico($pagina, $acao, 'telefoneUsuario', $valorCampoAnterior, $telefoneUsuario, $idUsuario);
        
        //etapa2 - validação do conteúdo
        $sTelefoneUsuario->verificarTelefone($telefoneUsuario);
        if (!$sTelefoneUsuario->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=telefone&codigo={$sTelefoneUsuario->getSNotificacao()->getCodigo()}");
        } else {
            //etapa3 - atualizar os dados
            $alteracao = true;
            $atualizar['telefoneUsuario'] = $telefoneUsuario;
        }
    }

    if ($_SESSION['credencial']['whatsAppUsuario'] != $whatsAppUsuario) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $_SESSION['credencial']['whatsAppUsuario'];
        alimentaHistorico($pagina, $acao, 'whatsApp', $valorCampoAnterior, $whatsAppUsuario, $idUsuario);

        //etapa3 - atualizar os dados
        $alteracao = true;
        $atualizar['whatsAppUsuario'] = $whatsAppUsuario;
    }

    if ($_SESSION['credencial']['emailUsuario'] != $emailUsuario) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $_SESSION['credencial']['emailUsuario'];
        alimentaHistorico($pagina, $acao, 'nomenclatura', $valorCampoAnterior, $emailUsuario, $idUsuario);
        
        //etapa2 - validação de conteúdo
        $sEmailUsuario = new sEmail($emailUsuario, 'tMenu1_1_1.php');
        $sEmailUsuario->verificar('tMenu1_1_1.php');
        
        if (!$sEmailUsuario->getValidador()) {
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=email&codigo={$sEmailUsuario->getSNotificacao()->getCodigo()}");
        } else {
            //etapa3 - atualizar os dados
            $alteracao = true;
            $atualizar['emailUsuario'] = $emailUsuario;
        }
    }

    if ($_SESSION['credencial']['idPermissao'] != $permissao) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $_SESSION['credencial']['permissao'];
        alimentaHistorico($pagina, $acao, 'permissao', $valorCampoAnterior, $permissao, $idUsuario);

        //etapa3 - atualizar os dados
        $alteracao = true;
        $atualizar['permissao'] = $permissao;
    }

    if ($_SESSION['credencial']['situacao'] != $situacao) {
        //insere dados na tabela histórico
        $valorCampoAnterior = $_SESSION['credencial']['situacao'];
        alimentaHistorico($pagina, $acao, 'situacao', $valorCampoAnterior, $situacao, $idUsuario);

        //etapa3 - atualizar os dados
        $alteracao = true;
        $atualizar['situacao'] = $situacao;
    }
    
    //QA - início da área de testes
    /* verificar o que tem no objeto

      echo "<pre>";
      echo var_dump($_SESSION['credencial']);
      echo "</pre>";

      // */
    //QA - fim da área de testes
    
    if (!$alteracao) {
        //se não tem campo para validar
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1");
    }else{        
        //se tem campos para atualizar
        if (array_key_exists('nome', $atualizar)) {
            //atualize o campo nome
            $sUsuarioNome->setIdUsuario($idUsuario);
            $sUsuarioNome->setNomeCampo('nome');
            $sUsuarioNome->setValorCampo($nome);
            $sUsuarioNome->alterar('tMenu1_1_1.php');
            //atualize a sessão nome
            $_SESSION['credencial']['nome'] = $nome;
            
            if ($sUsuarioNome->mConexao->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=todos&codigo={$sUsuarioNome->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('sobrenome', $atualizar)) {
            //atualize o campo nome
            $sUsuarioSobrenome->setIdUsuario($idUsuario);
            $sUsuarioSobrenome->setNomeCampo('sobrenome');
            $sUsuarioSobrenome->setValorCampo($sobrenome);
            $sUsuarioSobrenome->alterar('tMenu1_1_1.php');
            
            //atualize a sessão nome
            $_SESSION['credencial']['sobrenome'] = $sobrenome;
            
            if ($sUsuarioSobrenome->mConexao->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=todos&codigo={$sUsuarioSobrenome->getSNotificacao()->getCodigo()}");
            }
        }
        
        if (array_key_exists('sexo', $atualizar)) {
            //atualize o campo nome
            $sUsuarioSexo->setIdUsuario($idUsuario);
            $sUsuarioSexo->setNomeCampo('sexo');
            $sUsuarioSexo->setValorCampo($sexo);
            $sUsuarioSexo->alterar('tMenu1_1_1.php');
            
            //atualize a sessão nome
            $sexo == 'M' ? $sexo = 'Masculino' : $sexo = 'Feminino';
            $_SESSION['credencial']['sexo'] = $sexo;
            
            if ($sUsuarioSexo->mConexao->getValidador()) {
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=todos&codigo={$sUsuarioSexo->getSNotificacao()->getCodigo()}");
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
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=todos&codigo={$sTelefoneUsuario->getSNotificacao()->getCodigo()}");
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
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=todos&codigo={$sWhatsAppUsuario->getSNotificacao()->getCodigo()}");
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
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=todos&codigo={$sEmailUsuario->getSNotificacao()->getCodigo()}");
            }
        }
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
    $sHistorico->inserir('tMenu1_1_1.php', $tratarDados);
}
?>