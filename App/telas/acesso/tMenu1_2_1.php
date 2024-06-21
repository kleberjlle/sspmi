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

//verifica se está recebendo $_GET['id'] ou $_GET['campo']
if (isset($_GET['id']) ||
    isset($_GET['campo']) ||
    isset($_GET['codigo'])) {
    if (isset($_GET['id'])) {
        $idUsuario = $_GET['id'];
    } else if (isset($_GET['campo'])) {
        $idUsuario = $_GET['id'];
        $sNotificacao = new sNotificacao($_GET['codigo']);
        switch ($_GET['campo']) {
            case 'nome':
                if ($_GET['codigo'] == 'S1') {
                    $alertaNome = ' is-valid';
                } else {
                    $alertaNome = ' is-warning';
                }
                break;
            case 'sobrenome':
                if ($_GET['codigo'] == 'S1') {
                    $alertaNome = ' is-valid';
                } else {
                    $alertaSobrenome = ' is-warning';
                }
                break;
            case 'sexo':
                if ($_GET['codigo'] == 'S1') {
                    $alertaSexo = ' is-valid';
                } else {
                    $alertaSexo = ' is-warning';
                }
                break;
            case 'telefone':
                if ($_GET['codigo'] == 'S1') {
                    $alertaTelefone = ' is-valid';
                } else {
                    $alertaTelefone = ' is-warning';
                }
                break;
            case 'email':
                if ($_GET['codigo'] == 'S1') {
                    $alertaEmail = ' is-valid';
                } else {
                    $alertaEmail = ' is-warning';
                }
                break;
            case 'permissao':
                if ($_GET['codigo'] == 'S1') {
                    $alertaPermissao = ' is-valid';
                } else {
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
    } else {
        //solicitar saída com tentativa de violação
        $sSair = new sSair();
        $sSair->verificar('0');
    }
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
$idCargo = $sUsuario->getIdCargo();
$idPermissao = $sUsuario->getIdPermissao();
if ($idTelefone != 0) {
    $sTelefone = new sTelefone($idTelefone, 0, 'usuario');
    $sTelefone->consultar('tMenu1_2_1.php');
    $telefone = $sTelefone->getNumero();
    $telefoneTratado = $sTelefone->tratarTelefone($telefone);
    if ($sTelefone->getWhatsApp()) {
        $whatsApp = true;
    } else {
        $whatsApp = false;
    }
} else {
    $telefoneTratado = '';
    $whatsApp = false;
}

$sEmail = new sEmail($sUsuario->getIdEmail(), 'email');
$sEmail->consultar('tMenu1_2_1.php');
$email = $sEmail->getNomenclatura();

$sCargo = new sCargo($idCargo);
$sCargo->consultar('tMenu1_2_1.php');

$sPermissao = new sPermissao($idPermissao);
$sPermissao->consultar('tMenu1_2_1.php');

$sSecretaria = new sSecretaria($sUsuario->getIdSecretaria()); //id zero apenas para construir o objeto
$sSecretaria->consultar('tMenu1_2_1.php');

if ($sUsuario->getIdDepartamento() != 0) {
    $sDepartamento = new sDepartamento($sUsuario->getIdDepartamento()); //id zero apenas para construir o objeto
    $sDepartamento->consultar('tMenu1_2_1.php');
} else {
    $idDepartamento = '0';
    $departamento = '--';
}

if ($sUsuario->getIdCoordenacao() != 0) {
    $sCoordenacao = new sCoordenacao($sUsuario->getIdCoordenacao()); //id zero apenas para construir o objeto
    $sCoordenacao->consultar('tMenu1_2_1.php');
} else {
    $idCoordenacao = 0;
    $coordenacao = '--';
}

if ($sUsuario->getIdSetor() != 0) {
    $sSetor = new sSetor($sUsuario->getIdSetor()); //id zero apenas para construir o objeto
    $sSetor->consultar('tMenu1_2_1.php');
} else {
    $idSetor = 0;
    $setor = '--';
}

$situacao = $sUsuario->getSituacao();
//retorno de campo inválidos para notificação
if (isset($_GET['campo'])) {
    $sNotificacao = new sNotificacao($_GET['codigo']);
    switch ($_GET['campo']) {
        case 'nome':
            if ($_GET['codigo'] == 'S1') {
                $alertaNome = ' is-valid';
            } else {
                $alertaNome = ' is-warning';
            }
            break;
        case 'sobrenome':
            if ($_GET['codigo'] == 'S1') {
                $alertaNome = ' is-valid';
            } else {
                $alertaSobrenome = ' is-warning';
            }
            break;
        case 'sexo':
            if ($_GET['codigo'] == 'S1') {
                $alertaSexo = ' is-valid';
            } else {
                $alertaSexo = ' is-warning';
            }
            break;
        case 'telefone':
            if ($_GET['codigo'] == 'S1') {
                $alertaTelefone = ' is-valid';
            } else {
                $alertaTelefone = ' is-warning';
            }
            break;
        case 'email':
            if ($_GET['codigo'] == 'S1') {
                $alertaEmail = ' is-valid';
            } else {
                $alertaEmail = ' is-warning';
            }
            break;
        case 'permissao':
            if ($_GET['codigo'] == 'S1') {
                $alertaPermissao = ' is-valid';
            } else {
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
                                    <img class="profile-user-img img-fluid img-circle" src="<?php //echo $sConfiguracao->getDiretorioPrincipal();       ?>vendor/almasaeed2010/adminlte/dist/img/user2-160x160.jpg" alt="User profile picture">
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
                                        <option value="M" <?php echo $sexo == 'M' ? 'selected=""' : ''; ?>>Masculino</option>
                                        <option value="F" <?php echo $sexo == 'F' ? 'selected=""' : ''; ?>>Feminino</option>
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
                                        <input class="custom-control-input" type="checkbox" name="whatsAppUsuario" id="whatsAppUsuario" <?php echo $whatsApp ? 'checked=""' : ''; ?>>
                                        <label class="custom-control-label" for="whatsAppUsuario"><?php echo $whatsApp ? 'Sim' : 'Não'; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="emailUsuario">Email Pessoal</label>
                                <input class="form-control<?php echo isset($alertaEmail) ? $alertaEmail : ''; ?>" type="email" name="emailUsuario" id="emailUsuario" value="<?php echo $email; ?>" required="">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cargo/ Função</label>
                                    <select class="form-control" name="cargo" id="cargo">
<?php
foreach ($sCargo->mConexao->getRetorno() as $value) {
    $idCargo == $value['idcargo'] ? $atributo = ' selected' : $atributo = '';
    echo '<option value="' . $value['idcargo'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
}
?>
                                    </select>
                                </div>
                            </div>  
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Permissão</label>
                                    <select class="form-control" name="permissao" id="permissao">
<?php
foreach ($sPermissao->mConexao->getRetorno() as $key => $value) {
    $idPermissao == $value['idpermissao'] ? $atributo = ' selected' : $atributo = '';
    echo '<option value="' . $value['idpermissao'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
}
?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Secretaria</label>
                                    <select class="form-control" name="secretaria" id="secretaria">
<?php
foreach ($sSecretaria->mConexao->getRetorno() as $value) {
    $idSecretaria == $value['idsecretaria'] ? $atributo = ' selected' : $atributo = '';
    echo '<option value="' . $value['idsecretaria'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
}
?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Departamento/ Unidade</label>
                                    <select class="form-control" name="departamento" id="departamento">
<?php
if (!is_numeric($idDepartamento)) {
    foreach ($sDepartamento->mConexao->getRetorno() as $value) {
        $idDepartamento == $value['iddepartamento'] ? $atributo = ' selected' : $atributo = '';
        echo '<option value="' . $value['iddepartamento'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
    }
} else {
    echo '<option value="0" selected="">--</option>';
}
?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Coordenação</label>
                                    <select class="form-control" name="coordenacao" id="coordenacao">
<?php
if (!is_numeric($idCoordenacao)) {
    foreach ($sCoordenacao->mConexao->getRetorno() as $value) {
        $idCoordenacao == $value['idcoordenacao'] ? $atributo = ' selected' : $atributo = '';
        echo '<option value="' . $value['idcoordenacao'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
    }
} else {
    echo '<option value="0" selected="">--</option>';
}
?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Setor</label>
                                    <select class="form-control" name="setor" id="setor">
<?php
if (!is_numeric($idSetor)) {
    foreach ($sSetor->mConexao->getRetorno() as $value) {
        $idSetor == $value['idsetor'] ? $atributo = ' selected' : $atributo = '';
        echo '<option value="' . $value['idsetor'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
    }
} else {
    echo '<option value="0" selected="">--</option>';
}
?>
                                    </select>
                                </div>
                            </div>    
                        </div>                            
                        <div class="row">                               
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Situação</label>
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input class="custom-control-input" type="checkbox" name="situacao" id="situacao" <?php echo $situacao ? 'checked=""' : ''; ?>>
                                        <label class="custom-control-label" for="situacao"><?php echo $situacao ? 'Conta Ativa' : 'Conta Inativa'; ?></label>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
<?php
if (isset($tipo) &&
        isset($titulo) &&
        isset($email)) {
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
                        <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $idUsuario; ?>">
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
<script>
    $(document).ready(function () {
        //traz os departamentos de acordo com a secretaria selecionada   
        $('#secretaria').on('change', function () {
            var idSecretaria = $(this).val();

            //mostra somente os departamentos da secretaria escolhida
            $.ajax({
                url: 'https://itapoa.app.br/App/sistema/acesso/ajaxDepartamento.php',
                type: 'POST',
                data: {
                    'idSecretaria': idSecretaria
                },
                success: function (html) {
                    $('#departamento').html(html);
                }
            });

            //mostra somente as coordenações de acordo com a secretaria selecionada
            var idSecretaria = $(this).val();
            //mostra as coordenações do departamento escolhido
            $.ajax({
                url: 'https://itapoa.app.br/App/sistema/acesso/ajaxCoordenacao.php',
                type: 'POST',
                data: {
                    'idSecretaria': idSecretaria
                },
                success: function (html) {
                    $('#coordenacao').html(html);
                }
            });

            //mostra somente as coordenações de acordo com a secretaria selecionada
            var idSecretaria = $(this).val();
            //mostra as coordenações do departamento escolhido
            $.ajax({
                url: 'https://itapoa.app.br/App/sistema/acesso/ajaxSetor.php',
                type: 'POST',
                data: {
                    'idSecretaria': idSecretaria
                },
                success: function (html) {
                    $('#setor').html(html);
                }
            });
        });
    });
</script>