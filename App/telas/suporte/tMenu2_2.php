<?php
use App\sistema\acesso\{
    sTratamentoDados,
    sUsuario
};

use App\sistema\suporte\{
    sProtocolo,
    sEtapa,
    sCategoria,
    sEquipamento
};

//consulta os dados para apresentar na tabela
$sProtocolo = new sProtocolo();
$sProtocolo->consultar('tMenu2_2.php');
?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Etapa1 - Acompanhar Suporte</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tabelaMenu1_2" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Protocolo n.º</th>
                    <th>Data e Hora</th>
                    <th>Solicitante</th>
                    <th>Telefone</th>
                    <th>Identificação</th>
                    <th>Categoria/ Marca/ Modelo</th>
                    <th>Descrição</th>
                    <th>Ambiente</th>
                    <th>Local</th>
                    <?php    
                    if($_SESSION['credencial']['permissao'] > 1){
                    echo <<<HTML
                        <th>Prioridade</th>
HTML;
                        }
                        ?>
                    <th>Atribuir/ Visualizar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($sProtocolo->getValidador()) {
                    foreach ($sProtocolo->mConexao->getRetorno() as $key => $value) {
                        //tratar os dados para imprimir na tabela dinâmica
                        //campo data e hora da abertura
                        $sTratamentoData = new sTratamentoDados($value['dataHoraAbertura']);
                        $dataTratada = $sTratamentoData->tratarData();
                        
                        //campo protocolo
                        $ano = date("Y", strtotime(str_replace('-', '/', $value['dataHoraAbertura'])));                        
                        $protocolo = str_pad($value['idprotocolo'], 5, 0, STR_PAD_LEFT);        
                        $protocolo = $ano.$protocolo;
                        
                        //campo do requerente ou solicitante
                        $nomeRequerente = $value['nomeDoRequerente'].' '.$value['sobrenomeDoRequerente'];
                        $sUsuario = new sUsuario();
                        $sUsuario->setNomeCampo('idusuario');
                        $sUsuario->setValorCampo($value['usuario_idusuario']);
                        $sUsuario->consultar('tMenu2_2.php');
                        $nomeSolicitante = $sUsuario->getNome().' '.$sUsuario->getSobrenome();
                        if($nomeSolicitante == $nomeRequerente){
                            $requerente = false;
                            $nome = $nomeSolicitante;
                        }else{
                            $requerente = true;
                            $nome = $nomeRequerente.'<br />por <i>'.$nomeSolicitante.'</i>';                            
                        }
                        
                        //campo telefone
                        $sTratamentoTelefone = new sTratamentoDados($value['telefoneDoRequerente']);
                        $telefoneTratado = $sTratamentoTelefone->tratarTelefone();
                        
                        //campos da tabela etapa
                        //se não estiver etapa para um protocolo não será impressa gerará um erro
                        //verifique se há algum protocolo sem etapa vinculada
                        $idProtocolo = $value['idprotocolo'];
                        $sEtapa = new sEtapa();
                        $sEtapa->setNomeCampo('protocolo_idprotocolo');
                        $sEtapa->setValorCampo($idProtocolo);
                        $sEtapa->consultar('tMenu2_2.php');
                                               
                        
                        //var_dump($sEtapa->mConexao->getRetorno());
                        foreach ($sEtapa->mConexao->getRetorno() as $key => $value) {
                            $idEquipamento = $value['equipamento_idequipamento'];
                        }
                        
                        //campo patrimônio                        
                        $sEquipamento = new sEquipamento();
                        $sEquipamento->setNomeCampo('idequipamento');
                        $sEquipamento->setValorCampo($idEquipamento);
                        $sEquipamento->consultar('tMenu2_2.php');
                        
                        foreach ($sEquipamento->mConexao->getRetorno() as $key => $value) {
                            $patrimonio = $value['patrimonio'];
                            $idCategoria = $value['categoria_idcategoria'];
                            $idModelo = $value['modelo_idmodelo'];
                        }
                        
                        //campo categoria
                        $sCategoria = new sCategoria();
                        $sCategoria->consultar('tMenu2_2.php');
                        
                        echo <<<HTML
                        <tr>
                            <td>$protocolo</td>
                            <td>$dataTratada</td>
                            <td>$nome</td>
                            <td>$telefoneTratado</td>
                            <td>$patrimonio</td>
                            <td>Computador Dell OptPlex Micro 7010</td>
                            <td>Sem conexão</td>
                            <td>Interno</td>
                            <td>Prateleira</td>
HTML;
                            if($_SESSION['credencial']['permissao'] > 1){
                            echo <<<HTML
                            <td>
                                <i class="nav-icon fas fa-flag text-orange"></i><br />
                                Muito Urgente
                            </td>
HTML;
                            }
                            echo <<<HTML
                            <td>
                                <a href="tPainel.php?menu=2_2_1&id=1">
                                    <i class="fas fa-search mr-1"></i>
                                </a>
                            </td>
                        </tr>
HTML;               
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Protocolo n.º</th>
                    <th>Data e Hora</th>
                    <th>Solicitante</th>
                    <th>Telefone</th>
                    <th>Identificação</th>
                    <th>Categoria/ Marca/ Modelo</th>
                    <th>Descrição</th>
                    <th>Ambiente</th>
                    <th>Local</th>
                    <?php    
                    if($_SESSION['credencial']['permissao'] > 1){
                    echo <<<HTML
                        <th>Prioridade</th>
HTML;
                        }
                        ?>
                    <th>Atribuir/ Visualizar</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>