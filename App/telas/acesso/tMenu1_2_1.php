<?php

use App\sistema\acesso\{
    sConfiguracao,
    sUsuario,
    sSecretaria,
    sDepartamento,
    sCoordenacao,
    sSetor,
    sCargo,
    sPermissao,
    sNotificacao,
    sTelefone,
    sEmail
};

//QA - início da área de testes
/* verificar o que tem no objeto

  echo "<pre>";
  var_dump($_SESSION['credencial']);
  echo "</pre>";

  // */
//QA - fim da área de testes

//verifica se tem o método GET['id']
if(!isset($_GET['id'])){
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}else{
    $idUsuario = $_GET['id'];
}

$sConfiguracao = new sConfiguracao();

$sUsuario = new sUsuario();
$sUsuario->setNomeCampo('idusuario');
$sUsuario->setValorCampo($idUsuario);
$sUsuario->consultar('tMenu1_2_1.php');
$nome = $sUsuario->getNome();
$sobrenome = $sUsuario->getSobrenome();
$sexo = $sUsuario->getSexo();
$idTelefone = $sUsuario->getTelefone();
if($idTelefone != 0){
    $sTelefone = new sTelefone($idTelefone, 0, 'usuario');     
    $sTelefone->consultar('tMenu1_2_1.php');
    $telefone = $sTelefone->getNumero();
    $telefoneTratado = $sTelefone->tratarTelefone($telefone);
    if($sTelefone->getWhatsApp()){
        $whatsApp = true;
    }else{
        $whatsApp = false;
    }
}else{
    $telefoneTratado = '';
    $whatsApp = false;
}

$sEmail = new sEmail($sUsuario->getIdEmail(), 'email');
$sEmail->consultar('tMenu1_2_1.php');
$email = $sEmail->getNomenclatura();

$sSecretaria = new sSecretaria($sUsuario->getIdSecretaria()); //id zero apenas para construir o objeto
$sSecretaria->consultar('tMenu1_2_1.php');

if($sUsuario->getIdDepartamento() != 0){
    $sDepartamento = new sDepartamento($sUsuario->getIdDepartamento()); //id zero apenas para construir o objeto
    $sDepartamento->consultar('tMenu1_2_1.php');
}

if($sUsuario->getIdCoordenacao() != 0){
    $sCoordenacao = new sCoordenacao($sUsuario->getIdCoordenacao()); //id zero apenas para construir o objeto
    $sCoordenacao->consultar('tMenu1_2_1.php');
}

if($sUsuario->getIdSetor() != 0){
    $sSetor = new sSetor($sUsuario->getIdSetor()); //id zero apenas para construir o objeto
    $sSetor->consultar('tMenu1_2_1.php');
}
//retorno de campo inválidos para notificação
if(isset($_GET['campo'])){
    $sNotificacao = new sNotificacao($_GET['codigo']);
    switch ($_GET['campo']) {
        case 'nome':
            if($_GET['codigo'] == 'S1'){
                $alertaNome = ' is-valid';
            }else{
                $alertaNome = ' is-warning';
            }            
            break;
        case 'sobrenome':
            if($_GET['codigo'] == 'S1'){
                $alertaNome = ' is-valid';
            }else{
                $alertaSobrenome = ' is-warning';
            }  
            break;
        case 'sexo':
            if($_GET['codigo'] == 'S1'){
                $alertaSexo = ' is-valid';
            }else{
                $alertaSexo = ' is-warning';
            }  
            break;
        case 'telefone':
            if($_GET['codigo'] == 'S1'){
                $alertaTelefone = ' is-valid';
            }else{
                $alertaTelefone = ' is-warning';
            }  
            break;
        case 'email':
            if($_GET['codigo'] == 'S1'){
                $alertaEmail = ' is-valid';
            }else{
                $alertaEmail = ' is-warning';
            }  
            break;
        case 'permissao':
            if($_GET['codigo'] == 'S1'){
                $alertaPermissao = ' is-valid';
            }else{
                $alertaPermissao = ' is-warning';
            }  
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
                <form name="form1_tMenu1_2_1" id="form1_tMenu1_2_1" action="<?php echo $sConfiguracao->getDiretorioControleAcesso(); ?>sAlterarDadosOutrosUsuarios.php" method="post" enctype="multipart/form-data">
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
                                <input type="text" class="form-control<?php echo isset($alertaNome) ? $alertaNome : ''; ?>" name="nome" id="nome" value="<?php echo $nome; ?>" required="">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="sobrenome">Sobrenome</label>
                                <input class="form-control<?php echo isset($alertaSobrenome) ? $alertaSobrenome : ''; ?>" type="text" name="sobrenome" id="sobrenome" value="<?php echo $sobrenome; ?>" required="">
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>Sexo</label>
                                    <select class="form-control<?php echo isset($alertaSexo) ? $alertaSexo : ''; ?>" name="sexo" id="sexo" required="">
                                        <option value="Masculino" <?php echo $sexo == 'M' ? 'selected=""' : ''; ?>>Masculino</option>
                                        <option value="Feminino" <?php echo $sexo == 'F' ? 'selected=""' : ''; ?>>Feminino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="telefoneUsuario">Telefone Pessoal</label>
                                <input class="form-control<?php echo isset($alertaTelefone) ? $alertaTelefone : ''; ?>" type="text" name="telefoneUsuario" id="telefoneUsuario" value="<?php echo $telefoneTratado; ?>" data-inputmask='"mask": "(99) 9 9999-9999"' data-mask inputmode="text">
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>WhatsApp</label>
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input class="custom-control-input" type="checkbox" name="whatsAppUsuario" id="whatsAppUsuario" <?php echo $whatsApp ? 'checked=""' : '';?>>
                                        <label class="custom-control-label" for="whatsAppUsuario"><?php echo $whatsApp ? 'Sim' : 'Não'; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="emailUsuario">Email Pessoal</label>
                                <input class="form-control<?php echo isset($alertaEmail) ? $alertaEmail : ''; ?>" type="email" name="emailUsuario" id="emailUsuario" value="<?php echo $email; ?>" required="">
                            </div>
                        </div>
                    </div>
                    <?php
                    if( isset($tipo) && 
                        isset($titulo) && 
                        isset($email)){
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
                        <input type="hidden" name="pagina" id="pagina" value="tMenu1_2_1.php">
                        <input type="hidden" name="acao" id="acao" value="alterar">
                        <button class="btn btn-primary" type="submit">Alterar</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>