<?php

session_start();
require_once '../../../vendor/autoload.php';

use App\sistema\suporte\{
    sModelo
};

$sModelo = new sModelo($_POST['idCategoria']);
$sModelo->consultar('ajaxModelo.php');

$sModelo->consultar($pagina);

if ($sModelo->mConexao->getValidador()) {
    foreach ($sModelo->mConexao->getRetorno() as $value) {
        echo '<option value="' . $value['modelo_idmodelo'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
    }
} else {
    echo '<option value="" selected>--</option>';
}
?>