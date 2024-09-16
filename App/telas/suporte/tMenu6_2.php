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
    echo '<p>';
    echo 'ID: '.$linha['idhistorico'].'<br />';
    echo 'PÁGINA: '.$linha['pagina'].'<br />';
    echo 'AÇÃO: '.$linha['acao'].'<br />';
    echo 'CAMPO: '.$linha['campo'].'<br />';
    echo 'VALOR ATUAL: '.$linha['valorAtual'].'<br />';
    echo 'VALOR ANTERIOR: '.$linha['valorAnterior'].'<br />';
    echo 'DATA E HORA: '.$linha['dataHora'].'<br />';
    echo 'IP: '.$linha['ip'].'<br />';
    echo 'NAVEGADOR: '.$linha['navegador'].'<br />';
    echo 'SISTEMA OPERACIONAL: '.$linha['sistemaOperacional'].'<br />';
    echo 'NOME DO DISPOSITIVO: '.$linha['nomeDoDispositivo'].'<br />';
    echo 'ID DO USUÁRIO: '.$linha['idusuario'].'<br />';
    echo '</p>';
}