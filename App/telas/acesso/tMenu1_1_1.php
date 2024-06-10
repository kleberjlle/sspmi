<?php

use App\sistema\acesso\{
    sConfiguracao,
    sSecretaria,
    sCargo,
    sPermissao,
    sNotificacao
};

//QA - início da área de testes
/* verificar o que tem no objeto

  echo "<pre>";
  var_dump($_SESSION['credencial']);
  echo "</pre>";

  // */
//QA - fim da área de testes

$sConfiguracao = new sConfiguracao();

$sSecretaria = new sSecretaria(0); //id zero apenas para construir o objeto
$sSecretaria->consultar('tMenu1_1_1.php');

$sCargo = new sCargo($_SESSION['credencial']['idCargo']);
$sCargo->consultar('tMenu1_1_1.php');

$sPermissao = new sPermissao($_SESSION['credencial']['idPermissao']);
$sPermissao->consultar('tMenu1_1_1.php');

//retorno de campo inválidos para notificação
if(isset($_GET['campo'])){
    $sNotificacao = new sNotificacao($_GET['codigo']);
    switch ($_GET['campo']) {
        case 'nome':
            $alertaNome = true;
            break;
        case 'sobrenome':
            $alertaSobrenome = true;
            break;
        case 'telefone':
            $alertaTelefone = true;
            break;
        case 'email':
            $alertaEmail = true;
            break;
        case 'todos':
            $alertaSucesso = true;
            break;
        default:
            break;
    }
    
    //cria as variáveis da notificação
    $tipo = $sNotificacao->getTipo();
    $titulo = $sNotificacao->getTitulo();
    $email = $sNotificacao->getMensagem();
}
?>
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Etapa 2 - Alterar</h3>
                </div>
                <!-- form start -->
                <form name="form1_tMenu1_1_1" id="form1_tMenu1_1_1" action="<?php echo $sConfiguracao->getDiretorioControleAcesso(); ?>sAlterarDadosDoUsuario.php" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <!--
                            //próxima build
                            <div class="form-group col-md-1">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="<?php //echo $sConfiguracao->getDiretorioPrincipal();   ?>vendor/almasaeed2010/adminlte/dist/img/user2-160x160.jpg" alt="User profile picture">
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="imagem">Alterar Imagem</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="imagem" disabled="">
                                        <label class="custom-file-label" for="imagem"></label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Enviar</span>
                                    </div>
                                </div>
                            </div>
                            -->
                            <div class="form-group col-md-1">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control<?php echo isset($alertaNome) ? ' is-warning' : ''; ?>" name="nome" id="nome" value="<?php echo $_SESSION['credencial']['nome']; ?>" required="">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="sobrenome">Sobrenome</label>
                                <input class="form-control<?php echo isset($alertaSobrenome) ? ' is-warning' : ''; ?>" type="text" name="sobrenome" id="sobrenome" value="<?php echo $_SESSION['credencial']['sobrenome']; ?>" required="">
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>Sexo</label>
                                    <select class="form-control" name="sexo" id="sexo" required="">
                                        <option value="Masculino" <?php echo $_SESSION['credencial']['sexo'] == 'Masculino' ? 'selected=\"\"' : ''; ?>>Masculino</option>
                                        <option value="Feminino" <?php echo $_SESSION['credencial']['sexo'] == 'Feminino' ? 'selected=\"\"' : ''; ?>>Feminino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="telefoneUsuario">Telefone Pessoal</label>
                                <input class="form-control<?php echo isset($alertaTelefone) ? ' is-warning' : ''; ?>" type="text" name="telefoneUsuario" id="telefoneUsuario" value="<?php echo $_SESSION['credencial']['telefoneUsuario']; ?>" data-inputmask='"mask": "(99) 9 9999-9999"' data-mask inputmode="text">
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>WhatsApp</label>
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input class="custom-control-input" type="checkbox" name="whatsAppUsuario" id="whatsAppUsuario" <?php echo $_SESSION['credencial']['whatsAppUsuario'] ? 'checked=""' : '';?>>
                                        <label class="custom-control-label" for="whatsAppUsuario"><?php echo $_SESSION['credencial']['whatsAppUsuario'] ? 'Sim' : 'Não'; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="emailUsuario">Email Pessoal</label>
                                <input class="form-control<?php echo isset($alertaEmail) ? ' is-warning' : ''; ?>" type="email" name="emailUsuario" id="emailUsuario" value="<?php echo $_SESSION['credencial']['emailUsuario']; ?>" required="">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Permissão</label>
                                    <select class="form-control" name="permissao" id="permissao" <?php echo $_SESSION['credencial']['nivelPermissao'] > 4 ? '' : 'disabled=""'; ?> required="">
                                        <?php  
                                            foreach ($sPermissao->mConexao->getRetorno() as $key => $value) {
                                                $_SESSION['credencial']['idPermissao'] == $value['idpermissao'] ? $atributo = ' selected' : $atributo = '';
                                                echo '<option value="' . $value['idpermissao'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                            }                                       
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Situação</label>
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input class="custom-control-input" type="checkbox" name="situacao" id="situacao" <?php echo $_SESSION['credencial']['situacao'] == 'Ativo' ? 'checked=""' : ''; ?><?php echo $_SESSION['credencial']['nivelPermissao'] > 2 ? '' : 'disabled=""'; ?>>
                                        <label class="custom-control-label" for="situacao"><?php echo $_SESSION['credencial']['situacao'] == 'Ativo' ? 'Conta Ativa' : 'Conta Inativa'; ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if(isset($tipo) && isset($titulo) && isset($email)){
                    echo <<<HTML
                    <div class="col-mb-3">
                        <div class="card card-outline card-{$tipo}">
                            <div class="card-header">
                                <h3 class="card-title">{$titulo}</h3>
                            </div>
                            <div class="card-body">
                                {$email}
                            </div>
                        </div>
                    </div>
HTML;
                    }       
                    ?>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" name="pagina" id="pagina" value="tMenu1_1_1.php">
                        <input type="hidden" name="acao" id="acao" value="alterar">
                        <button class="btn btn-primary" type="submit">Alterar</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>