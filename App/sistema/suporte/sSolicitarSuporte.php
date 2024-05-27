<?php
if($_POST['pagina'] == 'menu2_1'){
    header('Location: ../../telas/acesso/tPainel.php?menu=2_1_1');
}else if($_POST['pagina'] == 'menu2_1_1'){
    if($_POST['equipamento']){
        header('Location: ../../telas/acesso/tPainel.php?menu=2_1_2');
    }else{
        header('Location: ../../telas/acesso/tPainel.php?menu=0&notificacao=S1');
    }
}else if($_POST['pagina'] == 'menu2_1_2'){    
    header('Location: ../../telas/acesso/tPainel.php?menu=0&notificacao=S1');
}

