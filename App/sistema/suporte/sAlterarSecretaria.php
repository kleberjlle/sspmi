<?php
session_start();

require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sSair,
    sConfiguracao,
    sHistorico,
    sCargo,
    sTratamentoDados,
    sSecretaria,
    sEmail,
    sTelefone
};

use App\sistema\suporte\{
    sAmbiente
};

//verifica se tem credencial para acessar o sistema
if (!isset($_SESSION['credencial'])) {
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}

if (isset($_POST['pagina'])) {
    $idUsuario = $_SESSION['credencial']['idUsuario'];
    $pagina = $_POST['pagina'];
    $acao = $_POST['acao'];
    $idSecretaria = $_POST['idSecretaria'];
    $idSecretariaCriptografada = base64_encode($idSecretaria);
    isset($_POST['secretaria']) ? $secretaria = $_POST['secretaria'] : $secretaria = 0;
    isset($_POST['endereco']) ? $endereco = $_POST['endereco'] : $endereco = 0;
    isset($_POST['email']) ? $email = $_POST['email'] : $email = 0;
    $idAmbiente = $_POST['idAmbiente'];
    isset($_POST['telefone']) ? $telefone = $_POST['telefone'] : $telefone = 0;
    isset($_POST['whatsApp']) ? $whatsApp = 1 : $whatsApp = 0;
    
    //obter dados anteriores da secretaria
    $sSecretaria = new sSecretaria(0);
    $sSecretaria->setNomeCampo('idsecretaria');
    $sSecretaria->setValorCampo($idSecretaria);
    $sSecretaria->consultar($pagina);
    
    foreach ($sSecretaria->mConexao->getRetorno() as $value) {
        $secretariaAnterior = $value['nomenclatura'];
        $enderecoAnterior = $value['endereco'];
        $idAmbienteAnterior = $value['ambiente_idambiente'];
    }    
    
    //verifica se a secretaria já possui email
    $sEmail = new sEmail('', '');
    $sEmail->setNomeCampo('secretaria_idsecretaria');
    $sEmail->setValorCampo($idSecretaria);
    $sEmail->consultar($pagina);
    
    //caso tenha email registrado então retorne o id do email
    if($sEmail->getValidador()){
        foreach ($sEmail->mConexao->getRetorno() as $value) {
            $idEmail = $value['email_idemail'];
        }
        
        //consulta os dados do e-mail anterior
        $sEmail->setNomeCampo('idemail');
        $sEmail->setValorCampo($idEmail);
        $sEmail->consultar('tMenu4_2_1_1.php-2');
        
        foreach ($sEmail->mConexao->getRetorno() as $value) {
            $emailAnterior = $value['nomenclatura'];
        }
    }    
    
    //busca os dados do ambiente
    $sAmbiente = new sAmbiente('', '');
    $sAmbiente->setNomeCampo('idambiente');
    $sAmbiente->setValorCampo($idAmbiente);
    $sAmbiente->consultar($pagina);
    
    foreach ($sAmbiente->mConexao->getRetorno() as $value) {
        $idAmbienteAnterior = $value['idambiente'];
    }
    
    //verifica se a secretaria já possui telefone
    $sTelefone = new sTelefone(0, 0, '');
    $sTelefone->setNomeCampo('secretaria_idsecretaria');
    $sTelefone->setValorCampo($idSecretaria);
    $sTelefone->consultar($pagina);
    
    //caso tenha telefone registrado então retorne o id do telefone
    if($sTelefone->getValidador()){
        foreach ($sTelefone->mConexao->getRetorno() as $value) {
            $idTelefone = $value['telefone_idtelefone'];
        }
        
        //consulta os dados do e-mail anterior
        $sTelefone->setNomeCampo('idtelefone');
        $sTelefone->setValorCampo($idTelefone);
        $sTelefone->consultar('tMenu4_2_1_1.php-2');
        
        foreach ($sTelefone->mConexao->getRetorno() as $value) {
            $telefoneAnterior = $value['numero'];
            $whatsAppAnterior = $value['whatsApp'];
        }
        
        //Insere os caracteres especiais para realizar a comparação
        $sTratamentoTelefone = new sTratamentoDados($telefoneAnterior);
        $telefoneAnterior = $sTratamentoTelefone->tratarTelefone();
    }
    
    //alimenta histórico
    if($secretaria != $secretariaAnterior){
        alimentaHistorico($pagina, $acao, 'secretaria', $secretariaAnterior, $secretaria, $idUsuario);
    }    
    if(isset($enderecoAnterior)){
        if($endereco != $enderecoAnterior){
            alimentaHistorico($pagina, $acao, 'endereco', $enderecoAnterior, $endereco, $idUsuario);
        }
    }else{
        if($endereco){
            alimentaHistorico($pagina, $acao, 'endereco', '', $endereco, $idUsuario);
        }
    }
    if($idAmbiente != $idAmbienteAnterior){
        alimentaHistorico($pagina, $acao, 'ambiente', $idAmbienteAnterior, $idAmbiente, $idUsuario);
    }
    if(isset($emailAnterior)){
        if($email != $emailAnterior){
            alimentaHistorico($pagina, $acao, 'email', $emailAnterior, $email, $idUsuario);
        }
    }else{
        if($email){
            alimentaHistorico($pagina, $acao, 'email', '', $email, $idUsuario);
        }
    }
    if(isset($telefoneAnterior)){
        if($telefone != $telefoneAnterior){
            alimentaHistorico($pagina, $acao, 'telefone', $telefoneAnterior, $telefone, $idUsuario);
        }
    }else{
        if($telefone){
            alimentaHistorico($pagina, $acao, 'telefone', '', $telefone, $idUsuario);
        }
    }
    if(isset($whatsAppAnterior)){
        if($whatsApp != $whatsAppAnterior){
            alimentaHistorico($pagina, $acao, 'whatsApp', $whatsAppAnterior, $whatsApp, $idUsuario);
        }
    }else{
        if($whatsApp){
            alimentaHistorico($pagina, $acao, 'whatsApp', '', $whatsApp, $idUsuario);
        }
    }
    
    
    //se não for preenchido o campo secretaria, retorne com mensagem de erro
    if(!$secretaria){
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=4_2_1_1&pagina=tMenu4_2_1.php&seguranca={$idSecretariaCriptografada}&formulario=f1&campo=secretaria&codigo=A10");
        exit(); 
    }else{
        //altera a nomenclatura da secretaria
        if($secretaria != $secretariaAnterior){
            $sSecretaria = new sSecretaria(0);
            $sSecretaria->setNomeCampo('nomenclatura');
            $sSecretaria->setValorCampo($secretaria);
            $sSecretaria->setIdSecretaria($idSecretaria);
            $sSecretaria->alterar($pagina);
        }
    }
    
    //se não for preenchido o campo endereco, retorne com mensagem de erro
    if(!$endereco){
        $sConfiguracao = new sConfiguracao();
        header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=4_2_1_1&pagina=tMenu4_2_1.php&seguranca={$idSecretariaCriptografada}&formulario=f1&campo=endereco&codigo=A10");
        exit(); 
    }else{
        //altera o endereco da secretaria
        if($endereco != $enderecoAnterior){
            $sSecretaria = new sSecretaria(0);
            $sSecretaria->setNomeCampo('endereco');
            $sSecretaria->setValorCampo($endereco);
            $sSecretaria->setIdSecretaria($idSecretaria);
            $sSecretaria->alterar($pagina);
        }
    }
    
    //se for passado um endereço de email diferente
    if(isset($emailAnterior)){
        if($email != $emailAnterior){
            //verifica se o email é válido
            $sTratamentoEmail = new sTratamentoDados($email);
            $emailTratado = $sTratamentoEmail->tratarEmail();

            //se o email for válido, verifica se já não existe um registro 
            if($emailTratado || $email == ''){
                if(empty($email)){
                    $email = 'null';
                }
                $sEmail->setNomeCampo('nomenclatura');
                $sEmail->setValorCampo($email);
                $sEmail->consultar('tMenu4_2_1_1.php-2');
                
                if($sEmail->getValidador()){
                    $sConfiguracao = new sConfiguracao();
                    header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=4_2_1_1&pagina=tMenu4_2_1.php&seguranca={$idSecretariaCriptografada}&formulario=f1&campo=email&codigo=A12");
                    exit();
                }else{
                    $sEmail->setNomeCampo('nomenclatura');
                    $sEmail->setValorCampo($email);
                    $sEmail->setIdEmail($idEmail);
                    $sEmail->alterar($pagina);
                }
            }else{
                $sConfiguracao = new sConfiguracao();
                header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=4_2_1_1&pagina=tMenu4_2_1.php&seguranca={$idSecretariaCriptografada}&formulario=f1&campo=email&codigo=A2");
                exit(); 
            }
        }
    }else{
        //caso não tenha e-mail registrado para alteração, registre um novo na tabela email       
        $tratarDados = [
            'nomenclatura' => $email
        ];
        $sEmail->inserir($pagina, $tratarDados);
        
        //se obteve o registro do último e-mail inserido, registre-o na tabela email_has_secretaria
        if($sEmail->mConexao->getRegistro()){
            //registre também na tabela email_has_secretaria    
            $sEmail->setNomeCampo('secretaria');
            $tratarDados = [
                'idemail' => $sEmail->mConexao->getRegistro(),
                'idsecretaria' => $idSecretaria
            ];
            $sEmail->inserir('tMenu4_2_1_1-email_has_secretaria.php', $tratarDados);
        }else{
            //retorne mensagem de erro sem registrar o e-mail
            $sConfiguracao = new sConfiguracao();
            header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=4_2_1_1&pagina=tMenu4_2_1.php&seguranca={$idSecretariaCriptografada}&formulario=f1&campo=email&codigo=E5");
            exit(); 
        }
        
    }
    
    //retorne com as alterações realizadas
    $sConfiguracao = new sConfiguracao();
    header("Location: {$sConfiguracao->getDiretorioVisualizacaoAcesso()}tPainel.php?menu=4_2_1_1&pagina=tMenu4_2_1.php&seguranca={$idSecretariaCriptografada}&formulario=f1&campo=email&codigo=S1");
    exit();

    
    
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
    $sHistorico->inserir($pagina, $tratarDados);
}
?>