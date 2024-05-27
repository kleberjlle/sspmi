<?php
echo $nome = $_POST['nome'];
echo $sobrenome = $_POST['sobrenome'];
echo $sexo = $_POST['sexo'];
echo $telefonePessoal = $_POST['telefonePessoal'];
echo $whatsAppPessoal = $_POST['whatsAppPessoal'];
echo $emailPessoal = $_POST['emailPessoal'];
echo $secretaria = $_POST['secretaria'];
echo $departamentoUnidade = $_POST['departamentoUnidade'];
echo $cargoFuncao = $_POST['cargoFuncao'];
echo $telefoneCorporativo = $_POST['telefoneCorporativo'];
echo $whatsAppCorporativo = $_POST['whatsAppCorporativo'];
echo $emailCorporativo = $_POST['emailCorporativo'];


if( $emailPessoal == 'tecnico@gmail.com' ||
    $emailPessoal == 'usuario@gmail.com' ||
    $emailPessoal == 'diretor@gmail.com'){
    header('Location: ../../telas/acesso/tAcessar.php?notificacao=A3');
}else{
    header('Location: ../../telas/acesso/tAcessar.php?notificacao=S3');
}