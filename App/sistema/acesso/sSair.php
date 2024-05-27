<?php
session_start();
session_destroy();
header('Location: ../../telas/acesso/tAcessar.php');

?>