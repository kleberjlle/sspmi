<?php
session_start();
$_SESSION['email'] = $_POST['email'];
if( $_SESSION['email'] == 'tecnico@gmail.com' ||
    $_SESSION['email'] == 'usuario@gmail.com' ||
    $_SESSION['diretor@gmail.com']){
    header('Location: ../../telas/acesso/tAcessar.php?notificacao=S2');
}else{
    header('Location: ../../telas/acesso/tRecuperarAcesso.php?notificacao=A2');
}