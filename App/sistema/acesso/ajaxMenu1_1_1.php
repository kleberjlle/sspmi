<?php
session_start();
require_once '../../../vendor/autoload.php';

use App\sistema\acesso\sDepartamento;

$sDepartamento = new sDepartamento($_POST['id']);
$sDepartamento->consultar('ajaxMenu1_1_1.php');


foreach ($sDepartamento->mConexao->getRetorno() as $value) {
    //$_SESSION['credencial']['idDepartamento'] == $value['iddepartamento'] ? $atributo = ' selected' : $atributo = '';
    echo '<option value="' . $value['iddepartamento'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
}

?>