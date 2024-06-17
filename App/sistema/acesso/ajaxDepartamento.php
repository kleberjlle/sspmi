<?php

session_start();
require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sDepartamento
};

$sDepartamento = new sDepartamento($_POST['idSecretaria']);
$sDepartamento->consultar('ajaxDepartamento.php');

if ($sDepartamento->mConexao->getValidador()) {
    foreach ($sDepartamento->mConexao->getRetorno() as $value) {
        $_SESSION['credencial']['idSecretaria'] == $value['secretaria_idsecretaria'] ? $atributo = ' selected' : $atributo = '';
        echo '<option value="' . $value['iddepartamento'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
    }
    echo '<option value="0">--</option>';
} else {
    echo '<option value="" selected>--</option>';
}
?>