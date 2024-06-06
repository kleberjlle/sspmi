<?php
session_start();
require_once '../../../vendor/autoload.php';
use App\sistema\acesso\{
    sDepartamento,
    sCoordenacao,
    sSetor,
};

if (isset($_POST['campo'])) {
    if($_POST['campo'] == 'departamento'){
        $sDepartamento = new sDepartamento($_POST['idSecretaria']);
        $sDepartamento->consultar('ajaxMenu1_1_1.php');

        foreach ($sDepartamento->mConexao->getRetorno() as $value) {
            $_SESSION['credencial']['idSecretaria'] == $value['idsecretaria'] ? $atributo = ' selected' : $atributo = '';
            echo '<option value="' . $value['iddepartamento'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
        }
    }

    if($_POST['campo'] == 'coordenacao'){
        if($_POST['campo'] == 'departamento'){
            $sCoordenacao = new sCoordenacao($_POST['idCoordenacao']);
            $sCoordenacao->consultar('ajaxMenu1_1_1.php');

            foreach ($sCoordenacao->mConexao->getRetorno() as $value) {
                $_SESSION['credencial']['idSecretaria'] == $value['idsecretaria'] ? $atributo = ' selected' : $atributo = '';
                echo '<option value="' . $value['idcoordenacao'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
            }
        }
    }
}
?>