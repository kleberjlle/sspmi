<?php
require_once '../../../vendor/autoload.php';

//habilita segurança do cookie
$lifetime = strtotime('+6 hours', 0);
session_set_cookie_params(['httponly' => true, 'lifetime' => $lifetime]);
//altera tempo de acesso 60s*60m*6h = 21600
ini_set('session.gc_maxlifetime', 21600);

use App\sistema\acesso\{
    sConfiguracao,
    sHistorico,
    sEmail,
    sSenha,
    sUsuario,
    sSair,
    sNotificacao    
};

//Objetos instanciados
$sConfiguracao = new sConfiguracao();
if(isset($_GET['validador'])){
    if(!$_GET['validador']){
        $sSair = new sSair();
        $sSair->notificar($_GET['validador']);
        
        //cria as variáveis da notificação
        $tipo = $sSair->sNotificacao->getTipo();
        $titulo = $sSair->sNotificacao->getTitulo();
        $mensagem = $sSair->sNotificacao->getMensagem();  
    }   
}

//se o sistema estiver em manutenção prevista
if(isset($_GET['seguranca'])){
    //cria as variáveis da notificação
    $sNotificacao = new sNotificacao('I1');
    $tipo = $sNotificacao->getTipo();
    $titulo = $sNotificacao->getTitulo();
    $mensagem = $sNotificacao->getMensagem();  
}

//se a senha foi alterada com sucesso
if(isset($_GET['codigo'])){
    $codigo = $_GET['codigo'];
    //cria as variáveis da notificação
    $sNotificacao = new sNotificacao($codigo);
    $tipo = $sNotificacao->getTipo();
    $titulo = $sNotificacao->getTitulo();
    $mensagem = $sNotificacao->getMensagem();  
}

//Dados do form enviados via POST
if(isset($_POST) && !empty($_POST)){
    $email = $_POST['email'];
    $senha = $_POST['senha'];    
    
    $sEmail = new sEmail('', '');
    $sEmail->setNomeCampo('nomenclatura');
    $sEmail->setValorCampo($email);
    $sEmail->consultar('tAcessar.php');
    
    foreach ($sEmail->mConexao->getRetorno() as $value) {
        $idEmail = $value['idemail'];
    }
        
    $sSenha = new sSenha($email);
    $sSenha->criptografar($senha);
    
    //Etapa 1 - registrar histórico
    //coletar dados do navegador
    
    //instancia sHistorico para alimentar a tabela de log
    $tratarDados = [
        'pagina' => basename($_SERVER['PHP_SELF']),
        'acao' => $_POST['acao'],
        'campo' => 'email',
        'valorCampoAtual' => $_POST['email'],
        'valorCampoAnterior' => null,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'navegador' => $_SERVER['HTTP_USER_AGENT'],
        'sistemaOperacional' => php_uname(),
        'nomeDoDispositivo' => gethostname(),
        'idUsuario' => null
    ];
    $sHistorico = new sHistorico();
    $sHistorico->inserir('tAcessar.php', $tratarDados);
    
    $tratarDados = [
        'pagina' => basename($_SERVER['PHP_SELF']),
        'acao' => $_POST['acao'],
        'campo' => 'senha',
        'valorCampoAtual' => $sSenha->getSenhaCriptografada(),
        'valorCampoAnterior' => null,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'navegador' => $_SERVER['HTTP_USER_AGENT'],
        'sistemaOperacional' => php_uname(),
        'nomeDoDispositivo' => gethostname(),
        'idUsuario' => null
    ];
    $sHistorico = new sHistorico();
    $sHistorico->inserir('tAcessar.php', $tratarDados);
       
    //Etapa2 - validar o campo e-mail
    $sEmail->verificar('tAcessar.php');
    
    //Etapa3 - validar o campo senha
    
    if( $sEmail->getValidador()){
        $sSenha->setEmail($email);
        $sSenha->setSenha($senha);
        $sSenha->verificar('tAcessar.php');
        if($sSenha->getValidador()){                
            $sUsuario = new sUsuario();
            $sUsuario->setNomeCampo('idemail');
            $sUsuario->setValorCampo($idEmail);        
            $sUsuario->consultar('tAcessar.php');
            if($sUsuario->getValidador()){     
                //Etapa4 - criar credencial de acesso para o usuário e redirecionar o acesso
                $sUsuario->acessar(basename($_SERVER['PHP_SELF']));                        
            }else{
                //cria as variáveis da notificação
                $tipo = $sUsuario->sNotificacao->getTipo();
                $titulo = $sUsuario->sNotificacao->getTitulo();
                $mensagem = $sUsuario->sNotificacao->getMensagem();
            }
        }else{
            //cria as variáveis da notificação
            $tipo = $sSenha->sNotificacao->getTipo();
            $titulo = $sSenha->sNotificacao->getTitulo();
            $mensagem = $sSenha->sNotificacao->getMensagem();
        }
    }else{
        //cria as variáveis da notificação
        $tipo = $sEmail->sNotificacao->getTipo();
        $titulo = $sEmail->sNotificacao->getTitulo();
        $mensagem = $sEmail->sNotificacao->getMensagem();
    }
        
    //QA - início da área de testes
    /*verificar o que tem no objeto
    /*
    echo "<pre>";
    var_dump($sNotificacao);
    echo "</pre>";
    * 
    */
    //QA - fim da área de testes
}

?>
<!DOCTYPE html>
<html lang="<?php echo $sConfiguracao->getLang(); ?>">
    <head>
        <meta charset="<?php echo $sConfiguracao->getCharset(); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sConfiguracao->getTitle(); ?></title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo $sConfiguracao->getDiretorioPrincipal()?>vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="<?php echo $sConfiguracao->getDiretorioPrincipal()?>vendor/almasaeed2010/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo $sConfiguracao->getDiretorioPrincipal()?>vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <?php echo $sConfiguracao->getLoginLogo(); ?>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <form action="<?php echo $sConfiguracao->getDiretorioVisualizacaoAcesso();?>tAcessar.php" method="post" enctype="multipart/form-data">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required="">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-12">
                                <input type="hidden" id="acao" name="acao" value="consultar">
                                <button type="submit" class="btn btn-primary btn-block">Acessar</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    <p class="mb-1">
                        <a href="<?php echo $sConfiguracao->getDiretorioVisualizacaoAcesso(); ?>tEsqueciMinhaSenha.php">Esqueci minha senha</a>
                    </p>
                    <p class="mb-0">
                        <a href="<?php echo $sConfiguracao->getDiretorioVisualizacaoAcesso(); ?>tSolicitarAcesso.php" class="text-center">Solicitar acesso</a>
                    </p>

                </div>
                <!-- /.login-card-body -->
            </div>
            <?php
            if( isset($tipo) && 
                isset($titulo) &&
                isset($mensagem)){
                    echo <<<HTML
                    <div class="col-mb-3">
                        <div class="card card-outline card-{$tipo}">
                            <div class="card-header">
                                <h3 class="card-title">{$titulo}</h3>
                            </div>
                            <div class="card-body">
                                {$mensagem}
                            </div>
                        </div>
                    </div>
HTML;
            }       
            ?>
        </div>

        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="<?php echo $sConfiguracao->getDiretorioPrincipal(); ?>vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="<?php echo $sConfiguracao->getDiretorioPrincipal(); ?>vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo $sConfiguracao->getDiretorioPrincipal(); ?>vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
    </body>
</html>