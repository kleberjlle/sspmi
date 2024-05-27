<?php
require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{sConfiguracao,sHistorico,sEmail,sSenha};

//Objetos instanciados
$sConfiguracao = new sConfiguracao();

//Dados do form enviados via POST
if(isset($_POST) && !empty($_POST)){
    //instancia sSenha para criptografar o conteúdo recebido via POST
    $sEmail = new sEmail($_POST['email']);
    $sSenha = new sSenha($_POST['senha']);
    
    //Etapa 1 - registrar histórico
    //instancia sHistorico para alimentar a tabela de log
    $sHistorico1 = new sHistorico(basename($_SERVER['PHP_SELF']), $_POST['acao'], 'email', $_POST['email'], null, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], php_uname(), gethostname(), null);
    $sHistorico2 = new sHistorico(basename($_SERVER['PHP_SELF']), $_POST['acao'], 'senha', $sSenha->getSenha(), null, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], php_uname(), gethostname(), null);
       
    //Etapa2 - validar o campo e-mail
    $sEmail->verificar(basename($_SERVER['PHP_SELF']));
    
    //Etapa3 - validar o campo senha
    //$sSenha->verificar();    
    
    
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
        <meta charset="<?php echo $sConfiguracao->getCharset; ?>">
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
                                <input type="hidden" id="acao" name="acao" value="acesso">
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
            if(isset($sEmail)){
                if(!$sEmail->mConexao->getValidador()){
                    echo <<<HTML
                    <div class="col-mb-3">
                        <div class="card card-outline card-{$sEmail->mConexao->sNotificacao->getTipo()}">
                            <div class="card-header">
                                <h3 class="card-title">{$sEmail->mConexao->sNotificacao->getTitulo()}</h3>
                            </div>
                            <div class="card-body">
                                {$sEmail->mConexao->sNotificacao->getMensagem()}
                            </div>
                        </div>
                    </div>
HTML;
            }
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