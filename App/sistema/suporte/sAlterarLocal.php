<?php
if($_POST['pagina'] == 'menu4_2'){
    switch ($_POST['opcao']) {
        case 'secretaria':
            $nomenclatura = $_POST['secretaria'];
            header('Location: ../../telas/acesso/tPainel.php?menu=4_2_1&opcao=Secretaria&nomenclatura='.$nomenclatura);
            break;
        case 'departamentoUnidade':
            $nomenclatura = $_POST['departamentoUnidade'];
            header('Location: ../../telas/acesso/tPainel.php?menu=4_2_1&opcao=Departamento Unidade&nomenclatura='.$nomenclatura);
            break;
        case 'coordenacao':
            $nomenclatura = $_POST['coordenacao'];
            header('Location: ../../telas/acesso/tPainel.php?menu=4_2_1&opcao=Coordenacao&nomenclatura='.$nomenclatura);
            break;
        case 'setor':
            $nomenclatura = $_POST['setor'];
            header('Location: ../../telas/acesso/tPainel.php?menu=4_2_1&opcao=Setor&nomenclatura='.$nomenclatura);
            break;
        default:
            header('Location: ../../telas/acesso/tPainel.php?menu=4_2_1&notificacao=E4');
            break;
    }    
}else if($_POST['pagina'] == 'menu4_2_1'){
    header('Location: ../../telas/acesso/tPainel.php?menu=0&notificacao=S4');
}else{
    header('Location: ../../telas/acesso/tPainel.php?menu=0&notificacao=E4');
}