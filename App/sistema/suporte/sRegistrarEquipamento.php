<?php
if($_POST['pagina'] == 'menu3_1'){
    $opcao = $_POST['opcao'];
    switch ($opcao) {
        case 'equipamento':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_1_1');
            break;
        case 'categoria':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_1&notificacao=S4');
            break;
        case 'marca':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_1&notificacao=S4');
            break;
        case 'modelo':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_1&notificacao=S4');
            break;
        case 'tensaoDeEntrada':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_1&notificacao=S4');
            break;
        case 'correnteDeEntrada':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_1&notificacao=S4');
            break;
        case 'sistemaOperacional':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_1&notificacao=S4');
            break;
        default:
            header('Location: ../../telas/acesso/tPainel.php?menu=3_1&notificacao=E1');
            break;
    }
}else if($_POST['pagina'] == 'menu3_1_1'){
    $opcao = $_POST['opcao'];
    switch ($opcao) {
        case 'responsavel':
            header('Location: ../../telas/acesso/tPainel.php?menu=0&notificacao=S4');
            break;
        case 'secretaria':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_1_1&notificacao=S4');
            break;
        case 'departamentoUnidade':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_1_1&notificacao=S4');
            break;
        case 'coordenacao':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_1_1&notificacao=S4');
            break;
        case 'setor':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_1_1&notificacao=S4');
            break;
        default:
            header('Location: ../../telas/acesso/tPainel.php?menu=3_1&notificacao=E1');
            break;
    }
}else if($_POST['pagina'] == 'menu3_2_1'){
    $opcao = $_POST['opcao'];
    switch ($opcao) {
        case 'categoria':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_2_1&notificacao=S4');
            break;
        case 'marca':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_2_1&notificacao=S4');
            break;
        case 'modelo':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_2_1&notificacao=S4');
            break;
        case 'tensaoDeEntrada':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_2_1&notificacao=S4');
            break;
        case 'correnteDeEntrada':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_2_1&notificacao=S4');
            break;
        case 'sistemaOperacional':
            header('Location: ../../telas/acesso/tPainel.php?menu=3_2_1&notificacao=S4');
            break;
        default:
            header('Location: ../../telas/acesso/tPainel.php?menu=3_2_1&notificacao=E1');
            break;
    }
}else if($_POST['pagina'] == 'menu3_2'){
    header('Location: ../../telas/acesso/tPainel.php?menu=0&notificacao=S1');
}
