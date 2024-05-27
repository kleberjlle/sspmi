<?php
if($_POST['pagina'] == 'menu4_1'){
    $opcao = $_POST['opcao'];
    switch ($opcao) {
        case 'secretaria':
            header('Location: ../../telas/acesso/tPainel.php?menu=4_1&notificacao=S4');
            break;
        case 'departamentoUnidade':
            header('Location: ../../telas/acesso/tPainel.php?menu=4_1&notificacao=S4');
            break;
        case 'coordenacao':
            header('Location: ../../telas/acesso/tPainel.php?menu=4_1&notificacao=S4');
            break;
        case 'setor':
            header('Location: ../../telas/acesso/tPainel.php?menu=4_1&notificacao=S4');
            break;
        default:
            header('Location: ../../telas/acesso/tPainel.php?menu=4_1&notificacao=E1');
            break;
    }
}