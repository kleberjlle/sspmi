<?php
session_start();

require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sSair,
    sConfiguracao,
    sHistorico,
    sCargo
};

//verifica se tem credencial para acessar o sistema
if (!isset($_SESSION['credencial'])) {
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}

if (isset($_POST['pagina'])) {
    $cargo = $_POST['nomenclatura'];

    $sCargo = new sCargo(0);
    $sCargo->consultar('tMenu5_1.php');
    
    $minuscula = mb_strtolower($cargo);
    $palavras = explode(" ",$minuscula);
    
    $palavrasTratadas = '';
    $j = count($palavras) - 1;
    for ($i = 0; $i < count($palavras); $i++) {
        if (strlen($palavras[$i]) < 3) {
            $palavrasTratadas .= $palavras[$i].' ';
        } else {
            if($j == $i){
                $palavrasTratadas .= ucfirst($palavras[$i]);
            }else{
                $palavrasTratadas .= ucfirst($palavras[$i]).' ';
            }            
        }
    }
    
    foreach ($sCargo->mConexao->getRetorno() as $linha) {
        if($linha['nomenclatura'] == $palavrasTratadas){
            $teste = true;
        }
    }
    echo isset($teste) ? 'possui registro' : 'ainda não possui registro';
}
?>