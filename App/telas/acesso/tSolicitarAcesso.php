<?php
require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sConfiguracao,
    sSecretaria
};

$sConfiguracao = new sConfiguracao();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sConfiguracao->getTitle(); ?></title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo $sConfiguracao->getDiretorioPrincipal(); ?>vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="<?php echo $sConfiguracao->getDiretorioPrincipal(); ?>vendor/almasaeed2010/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo $sConfiguracao->getDiretorioPrincipal(); ?>vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
    </head>
    <body class="hold-transition register-page">
        <div class="register-box">
            <div class="login-logo">
                <?php echo $sConfiguracao->getLoginLogo(); ?>
            </div>

            <div class="card">
                <div class="card-body register-card-body">
                    <p class="login-box-msg">Solicitar Conta</p>

                    <form action="<?php echo $sConfiguracao->getDiretorioControleAcesso(); ?>sSolicitarConta.php" method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Nome" name="nome" required="">
                            <input type="text" class="form-control" placeholder="Sobrenome" name="sobrenome" required="">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-control" name="sexo" required="">
                                <option value="" selected="" disabled="">Sexo</option>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-venus-mars"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Telefone pessoal" name="telefonePessoal">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" value="Permito comunicação via WhatsApp" disabled>
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <input type="checkbox">
                                </span>
                            </div>                            
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email pessoal" name="emailPessoal" required="">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>                            
                        <div class="input-group mb-3">
                            <select class="form-control" name="secretaria" required>
                                <option value="" selected="" disabled="">Secretaria</option>
                                <?php
                                $sSecretaria = new sSecretaria(0);
                                $sSecretaria->consultar('tSolicitarAcesso.php');
                                
                                foreach ($sSecretaria->mConexao->getRetorno() as $key => $value) {
                                    echo '<option value="$value['idsecretaria']">$value['nomenclatura']</option>';                                    
                                }
                            ?>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-building"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-control" name="departamentoUnidade" required="">
                                <option value="" selected="" disabled="">Departamento/ Unidade</option>
                                <option value="licitacoes">Licitações, Contratos e Compras</option>
                                <option value="patrimonio">Patrimônio e Frotas</option>
                                <option value="rh">Recursos Humanos</option>
                                <option value="tecnologia">Tecnologia da Informação</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-house-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-control" name="coordenacao" required="">
                                <option value="" selected="" disabled="">Coordenação</option>
                                <option value="licitacoes">Contratos</option>
                                <option value="patrimonio">Patrimônio e Frotas</option>
                                <option value="rh">Recursos Humanos</option>
                                <option value="tecnologia">Informática e Sistemas</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-house-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-control" name="coordenacao" required="">
                                <option value="" selected="" disabled="">Setor</option>
                                <option value="licitacoes">Contratos</option>
                                <option value="patrimonio">Patrimônio e Frotas</option>
                                <option value="rh">Recursos Humanos</option>
                                <option value="tecnologia">Informática e Sistemas</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-house-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-control" name="cargoFuncao" required="">
                                <option value="" selected="" disabled="">Cargo/ Função</option>
                                <option value="diretor">Diretor</option>
                                <option value="coordenador">Coordenador</option>
                                <option value="agenteAdministrativo">Agente Administrativo</option>
                                <option value="tecnicoDeInformatica">Técnico de Informática</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-briefcase"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="termosDeUso" name="termosDeUso" value="aceito" required="">
                                    <label for="termosDeUso">
                                        Eu aceito os <a href="tTermosDeUso.php">termos de uso</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Solicitar</button>
                            </div>
                        </div>
                    </form>
                    <a href="tAcessar.php" class="text-center">Já possuo conta</a>
                </div>
                <!-- /.form-box -->
            </div><!-- /.card -->
        </div>
        <!-- /.register-box -->

        <!-- jQuery -->
        <script src="<?php echo $sConfiguracao->getDiretorioPrincipal(); ?>vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="<?php echo $sConfiguracao->getDiretorioPrincipal(); ?>vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo $sConfiguracao->getDiretorioPrincipal(); ?>vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
        <!--input Customs-->
        <script src="<?php echo $sConfiguracao->getDiretorioPrincipal(); ?>vendor/almasaeed2010/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
        <script>
            $(function () {
                bsCustomFileInput.init();
            });
        </script>
    </body>
</html>