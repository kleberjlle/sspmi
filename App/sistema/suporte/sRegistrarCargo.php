<?php
if($_POST['pagina'] == 'menu5_1'){
    header('Location: ../../telas/acesso/tPainel.php?menu=0&notificacao=S4');
}else{
    header('Location: ../../telas/acesso/tPainel.php?menu=0&notificacao=E4');
}