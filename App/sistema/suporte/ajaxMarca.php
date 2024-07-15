<?php

session_start();
require_once '../../../vendor/autoload.php';

use App\sistema\suporte\{
    sMarca
};

$sMarca = new sMarca($_POST['idCategoria']);
$sMarca->consultar('ajaxMarca.php');

if ($sMarca->mConexao->getValidador()) {
    foreach ($sMarca->mConexao->getRetorno() as $value) {
        $_SESSION['credencial']['idCategoria'] == $value['categoria_idcategoria'] ? $atributo = ' selected' : $atributo = '';
        echo '<option value="' . $value['idmarca'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
    }
    echo '<option value="0">--</option>';
} else {
    echo '<option value="" selected>--</option>';
}
?>