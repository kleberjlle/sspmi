<?php

session_start();

require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sSair,
};

//verifica se tem credencial para acessar o sistema
if (!isset($_SESSION['credencial'])) {
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}

if (isset($_POST['formulario'])) {    
    //verifica se é para abrir o chamado com os dados do solicitante ou do representante
    isset($_POST['meusDados']) ? $meusDados = $_POST['meusDados'] : $meusDados = false;
    
    //verifica de qual formulário os dados vieram
    if($_POST['formulario'] == 'f1'){
        //verifica se serão passados os dados do solicitante ou do requerente
        if($meusDados){
            echo 'dados do solicitante';
        }else{
            echo 'dados do requerente';
        }
    }
    
} else {
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}
