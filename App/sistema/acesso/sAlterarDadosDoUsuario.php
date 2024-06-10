<?php
session_start();
require_once '../../../vendor/autoload.php';
use App\sistema\acesso\{
    sSair,
    sConfiguracao,
    sNotificacao,
    sHistorico,
    sUsuario,
    sTelefone,
    sEmail
};
//verifica se tem credencial para acessar o sistema
if(!isset($_SESSION['credencial'])){
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}

if(isset($_POST['pagina'])){
    if($_POST['pagina'] != 'tMenu1_1_1.php'){
        //solicitar saída com tentativa de violação
        $sSair = new sSair();
        $sSair->verificar('0');
    }
    $sTelefoneUsuario = new sTelefone(0, 0, '0');
    
    $idUsuario = $_SESSION['credencial']['idUsuario'];
    $pagina = $_POST['pagina'];
    $acao = $_POST['acao'];
    //$imagem = $_POST['imagem']; próxima build
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $sexo = $_POST['sexo'];
    $telefoneUsuario = $sTelefoneUsuario->tratarTelefone($_POST['telefoneUsuario']);
    isset($_POST['whatsAppUsuario']) ? $whatsAppUsuario = true : $whatsAppUsuario = false;
    $emailUsuario = $_POST['emailUsuario'];
    isset($_POST['permissao']) ? $permissao = $_POST['permissao'] : $permissao = $_SESSION['credencial']['idPermissao'];
    isset($_POST['situacao']) ? $situacao = true : $situacao = false;
    $atualizar = array();
    
    
    //etapa1 - verificar campos alterados
    if($_SESSION['credencial']['nome'] != $nome){
        //insere dados na tabela histórico
        $valorCampoAnterior = $_SESSION['credencial']['nome'];        
        alimentaHistorico($pagina, $acao, 'nome', $valorCampoAnterior, $nome, $idUsuario);
        $sUsuarioNome = new sUsuario();
        $sUsuarioNome->verificarNome($nome);
        
        //etapa2 - validação do conteúdo
        if(!$sUsuarioNome->getValidador()){
            $sConfiguracao = new sConfiguracao();      
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=nome&codigo={$sUsuarioNome->getSNotificacao()->getCodigo()}");
        }else{
            //etapa3 - atualizar os dados
            $atualizar['nome'] = $nome;
        }
    }
    
    if($_SESSION['credencial']['sobrenome'] != $sobrenome){
        //insere dados na tabela histórico
        $valorCampoAnterior = $_SESSION['credencial']['sobrenome'];        
        alimentaHistorico($pagina, $acao, 'sobrenome', $valorCampoAnterior, $sobrenome, $idUsuario);
        $sUsuarioSobrenome = new sUsuario();
        $sUsuarioSobrenome->verificarSobrenome($sobrenome);
        
        //etapa2 - validação do conteúdo
        if(!$sUsuarioSobrenome->getValidador()){
            $sConfiguracao = new sConfiguracao();      
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=sobrenome&codigo={$sUsuarioSobrenome->getSNotificacao()->getCodigo()}");
        }else{
            //etapa3 - atualizar os dados
            $atualizar['sobrenome'] = $sobrenome;
        }
    }
    
    if($_SESSION['credencial']['sexo'] != $sexo){
        $_POST['sexo'] == 'Masculino' ? $sexo = 'M' : $sexo = 'F';
        //insere dados na tabela histórico
        $_SESSION['credencial']['sexo'] == 'Masculino' ? $valorCampoAnterior = 'M' : $valorCampoAnterior = 'F';        
        alimentaHistorico($pagina, $acao, 'sexo', $valorCampoAnterior, $sexo, $idUsuario);
        
        //etapa3 - atualizar os dados
        $atualizar['sexo'] = $sexo;
        
    }
    
    if($_SESSION['credencial']['telefoneUsuario'] != $telefoneUsuario){
        //insere dados na tabela histórico
        $valorCampoAnterior = $_SESSION['credencial']['telefoneUsuario'];
        alimentaHistorico($pagina, $acao, 'telefoneUsuario', $valorCampoAnterior, $nome, $idUsuario);
        
        //etapa2 - validação do conteúdo
        $sTelefoneUsuario->verificarTelefone($telefoneUsuario);
        if(!$sTelefoneUsuario->getValidador()){
            $sConfiguracao = new sConfiguracao();      
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=telefone&codigo={$sTelefoneUsuario->getSNotificacao()->getCodigo()}");
        }else{
            //etapa3 - atualizar os dados
            $atualizar['telefoneUsuario'] = $telefoneUsuario;
        }
    }
    
    if($_SESSION['credencial']['whatsAppUsuario'] != $whatsAppUsuario){
        //insere dados na tabela histórico
        $valorCampoAnterior = $_SESSION['credencial']['whatsAppUsuario'];
        alimentaHistorico($pagina, $acao, 'whatsApp', $valorCampoAnterior, $whatsAppUsuario, $idUsuario);
                
        //etapa3 - atualizar os dados
        $atualizar['whatsAppUsuario'] = $whatsAppUsuario;
    }
    
    if($_SESSION['credencial']['emailUsuario'] != $emailUsuario){
        //insere dados na tabela histórico
        $valorCampoAnterior = $_SESSION['credencial']['emailUsuario'];
        alimentaHistorico($pagina, $acao, 'emailUsuario', $valorCampoAnterior, $emailUsuario, $idUsuario);
        $sEmail = new sEmail($emailUsuario, 'tMenu1_1_1.php');
        $sEmail->verificar('tMenu1_1_1.php');
        
        //etapa2 - validação de conteúdo
        if(!$sEmail->getValidador()){
            $sConfiguracao = new sConfiguracao();      
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=email&codigo={$sEmail->getSNotificacao()->getCodigo()}");
        }else{
            //etapa3 - atualizar os dados
            $atualizar['emailUsuario'] = $emailUsuario;
        }
    }
    
    if($_SESSION['credencial']['idPermissao'] != $permissao){
        //insere dados na tabela histórico
        $valorCampoAnterior = $_SESSION['credencial']['permissao'];
        alimentaHistorico($pagina, $acao, 'permissao', $valorCampoAnterior, $permissao, $idUsuario);
        
        //etapa3 - atualizar os dados
        $atualizar['permissao'] = $permissao;
        
    }
    
    if($_SESSION['credencial']['situacao'] != $situacao){
        //insere dados na tabela histórico
        $valorCampoAnterior = $_SESSION['credencial']['situacao'];
        alimentaHistorico($pagina, $acao, 'situacao', $valorCampoAnterior, $situacao, $idUsuario);
                
        //etapa3 - atualizar os dados
        $atualizar['situacao'] = $situacao;    
    }
    
    if(empty($atualizar)){
        //se não tem campo para validar
        $sConfiguracao = new sConfiguracao();      
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1");
    }else{
        //se tem campos para atualizar
        var_dump($atualizar);
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

    if($sHistorico->mConexao->getValidador()){
        $sConfiguracao = new sConfiguracao();      
        //header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=1_1_1&campo=todos&codigo={$sHistorico->getSNotificacao()->getCodigo()}");
    }
}
?>