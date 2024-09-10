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
    sEmail,
    sTratamentoDados
};

if (isset($_GET['seguranca']) ||
    isset($_GET['campo']) ||
    isset($_GET['codigo'])) {
    if (isset($_GET['seguranca'])) {
        $idUsuario = $_GET['seguranca'];
    } else if (isset($_GET['campo'])) {
        $idUsuario = $_GET['seguranca'];
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
            case 'secretaria':
                if ($_GET['codigo'] == 'S1') {
                    $alertaSecretaria = ' is-valid';
                } else {
                    $alertaSecretaria = ' is-warning';
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
$idUsuario = base64_decode($idUsuario);

$sConfiguracao = new sConfiguracao();

$sUsuario = new sUsuario();
$sUsuario->setIdUsuario($idUsuario);
$sUsuario->consultar('tMenu1_2_1.php');

foreach ($sUsuario->mConexao->getRetorno() as $value) {
    $nome = $value['nome'];
    $sobrenome = $value['sobrenome'];
    $sexo = $value['sexo'];
    $idTelefone = $value['telefone_idtelefone'];
    $idEmail = $value['email_idemail'];
    $idCargo = $value['cargo_idcargo'];
    $idPermissao = $value['permissao_idpermissao'];
    $idSecretaria = $value['secretaria_idsecretaria'];
    $idDepartamento = $value['departamento_iddepartamento'];
    $idCoordenacao = $value['coordenacao_idcoordenacao'];
    $idSetor = $value['setor_idsetor'];
    $situacao = $value['situacao'];
}

//busca dados do telefone
$sTelefone = new sTelefone($idTelefone, 0, 'usuario');
$sTelefone->consultar('tMenu1_2_1.php');

//trata o número do telefone
$sTratamentoTelefone = new sTratamentoDados($sTelefone->getNumero());
$telefoneTratado = $sTratamentoTelefone->tratarTelefone();
$whatsApp = $sTelefone->getWhatsApp();

//busca dados do e-mail
$sEmail = new sEmail($idEmail, 'email');
$sEmail->consultar('tMenu1_2_1.php');
$email = $sEmail->getNomenclatura();

//busca os dados do cargo
$sCargo = new sCargo($idCargo);
$sCargo->consultar('tMenu1_2_1.php');

//busca os dados da permissão
$sPermissao = new sPermissao($idPermissao);
$sPermissao->consultar('tMenu1_2_1.php');

//busca os dados da secretaria
$sSecretaria = new sSecretaria($idSecretaria);
$sSecretaria->consultar('tMenu1_2_1.php');

//busca os dados do departamento
$sDepartamento = new sDepartamento($idDepartamento);
$sDepartamento->consultar('tMenu1_2_1.php');

//busca os dados do departamento
$sCoordenacao = new sCoordenacao($idCoordenacao);
$sCoordenacao->consultar('tMenu1_2_1.php');

//busca os dados do departamento
$sSetor = new sSetor($idSetor);
$sSetor->consultar('tMenu1_2_1.php');

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
                $alertaSobrenome = ' is-valid';
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
        case 'cargo':
            if ($_GET['codigo'] == 'S1') {
                $alertaCargo = ' is-valid';
            } else {
                $alertaCargo = ' is-warning';
            }
            break;
        case 'permissao':
            if ($_GET['codigo'] == 'S1') {
                $alertaPermissao = ' is-valid';
            } else {
                $alertaPermissao = ' is-warning';
            }
            break;
        case 'secretaria':
            if ($_GET['codigo'] == 'S1') {
                $alertaSecretaria = ' is-valid';
            } else {
                $alertaSecretaria = ' is-warning';
            }
            break;
        case 'departamento':
            if ($_GET['codigo'] == 'S1') {
                $alertaDepartamento = ' is-valid';
            } else {
                $alertaDepartamento = ' is-warning';
            }
            break;
        case 'coordenacao':
            if ($_GET['codigo'] == 'S1') {
                $alertaCoordenacao = ' is-valid';
            } else {
                $alertaCoordenacao = ' is-warning';
            }
            break;
        case 'setor':
            if ($_GET['codigo'] == 'S1') {
                $alertaSetor = ' is-valid';
            } else {
                $alertaSetor = ' is-warning';
            }
            break;
        default:
            break;
    }

    //cria as variáveis da notificação
    $tipo = $sNotificacao->getTipo();
    $titulo = $sNotificacao->getTitulo();
    $mensagem = $sNotificacao->getMensagem();
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
                <form name="f1" id="f1" action="<?php echo $sConfiguracao->getDiretorioControleAcesso(); ?>sAlterarDadosOutrosUsuarios.php" method="post" enctype="multipart/form-data">
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
                            <div class="form-group col-md-2">
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
                            <div class="form-group col-md-1">
                                <label for="telefone">Telefone</label>
                                <input class="form-control<?php echo isset($alertaTelefone) ? $alertaTelefone : ''; ?>" type="text" name="telefone" id="telefone" value="<?php echo $telefoneTratado; ?>" data-inputmask='"mask": "(99) 9 9999-9999"' data-mask inputmode="text">
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>WhatsApp</label>
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input class="custom-control-input" type="checkbox" name="whatsApp" id="whatsApp" <?php echo $whatsApp ? 'checked=""' : ''; ?>>
                                        <label class="custom-control-label" for="whatsApp"><?php echo $whatsApp ? 'Sim' : 'Não'; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="email">Email</label>
                                <input class="form-control<?php echo isset($alertaEmail) ? $alertaEmail : ''; ?>" type="email" name="email" id="email" value="<?php echo $email; ?>" required="">
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Permissão</label>
                                    <select class="form-control<?php echo isset($alertaPermissao) ? $alertaPermissao : ''; ?>" name="permissao" id="permissao">
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
                                    <select class="form-control<?php echo isset($alertaSecretaria) ? $alertaSecretaria : ''; ?>" name="secretaria" id="secretaria">
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
                                    <select class="form-control<?php echo isset($alertaDepartamento) ? $alertaDepartamento : ''; ?>" name="departamento" id="departamento">
                                        <?php
                                        if (!is_numeric($idDepartamento)) {
                                            foreach ($sDepartamento->mConexao->getRetorno() as $value) {
                                                $idDepartamento == $value['iddepartamento'] ? $atributo = ' selected' : $atributo = '';
                                                echo '<option value="' . $value['iddepartamento'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Coordenação</label>
                                    <select class="form-control<?php echo isset($alertaCoordenacao) ? $alertaCoordenacao : ''; ?>" name="coordenacao" id="coordenacao">
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
                                    <select class="form-control<?php echo isset($alertaSetor) ? $alertaSetor : ''; ?>" name="setor" id="setor">
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
                            isset($mensagem)) {
                            if (isset($alertaSistema)) {
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