<?php
if($_POST['pagina'] == 'menu5_2'){
    $nomenclatura = $_POST['nomenclatura'];
    header('Location: ../../telas/acesso/tPainel.php?menu=5_2_1&opcao='.$nomenclatura);
}else if($_POST['pagina'] == 'menu5_2_1'){
    header('Location: ../../telas/acesso/tPainel.php?menu=0&notificacao=S4');
}else{
    header('Location: ../../telas/acesso/tPainel.php?menu=0&notificacao=E4');
}