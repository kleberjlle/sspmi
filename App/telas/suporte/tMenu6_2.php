<?php

require_once '../../../vendor/autoload.php';

use App\sistema\acesso\{
    sSair,
    sConfiguracao,
    sHistorico
};

//verifica se tem credencial para acessar o sistema
if (!isset($_SESSION['credencial'])) {
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}

$sHistorico = new sHistorico();
$sHistorico->consultar('tMenu6_2.php');

foreach ($sHistorico->mConexao->getRetorno() as $linha) {
    echo $linha['idhistorico'].' | '.$linha['pagina'].' | '.$linha['acao'].' | '.$linha['campo'].' | '.$linha['valorAtual'].' | '.$linha['valorAnterior'].' | '.$linha['dataHora'].' | '.$linha['ip'].' | '.$linha['navegador'].' | '.$linha['sistemaOperacional'].' | '.$linha['nomeDoDispositivo'].' | '.$linha['idusuario'].'<br />';
}