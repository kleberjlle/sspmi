<?php

session_start();
require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sDepartamento,
    sCoordenacao,
    sSetor,
};

if ($_POST['campo'] == 'departamento') {
    $sDepartamento = new sDepartamento($_POST['idSecretaria']);
    $sDepartamento->consultar('ajaxMenu1_1_1.php');

    foreach ($sDepartamento->mConexao->getRetorno() as $value) {
        $_SESSION['credencial']['idSecretaria'] == $value['idsecretaria'] ? $atributo = ' selected' : $atributo = '';
        echo '<option value="' . $value['iddepartamento'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
    }
}

if ($_POST['campo'] == 'coordenacao') {
    $sCoordenacao = new sCoordenacao($_POST['idSecretaria']);
    $sCoordenacao->consultar('ajaxMenu1_1_1.php');

    foreach ($sCoordenacao->mConexao->getRetorno() as $value) {
        $_SESSION['credencial']['idSecretaria'] == $value['departamento_secretaria_idsecretaria'] ? $atributo = ' selected' : $atributo = '';
        echo '<option value="' . $value['idcoordenacao'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
    }
}
?>