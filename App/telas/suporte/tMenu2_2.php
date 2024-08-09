<?php

use App\sistema\acesso\{
    sTratamentoDados,
    sUsuario,
    sConfiguracao
};
use App\sistema\suporte\{
    sProtocolo,
    sEtapa,
    sCategoria,
    sEquipamento,
    sMarca,
    sModelo,
    sAmbiente,
    sLocal,
    sPrioridade
};

//consulta os dados para apresentar na tabela
$sProtocolo = new sProtocolo();
$sProtocolo->consultar('tMenu2_2.php');
?>
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Etapa 1 - Acompanhar Suporte</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table name="tabelaMenu2_2" id="tabelaMenu2_2" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Protocolo n.º</th>
                    <th>Data e Hora</th>
                    <th>Solicitante</th>
                    <th>Telefone</th>
                    <th>Patrimônio</th>
                    <th>Categoria/ Marca/ Modelo</th>
                    <th>Descrição</th>
                    <?php
                    if ($_SESSION['credencial']['nivelPermissao'] > 1) {
                        echo <<<HTML
                    <th>Ambiente</th>
HTML;
                    }
                    ?>
                    <th>Local</th>
                    <?php
                    if ($_SESSION['credencial']['nivelPermissao'] > 1) {
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
                        //armazena o id do solicitante para criptografia
                        $seguranca = base64_encode($value['usuario_idusuario']);
                        
                        //se não tiver permissão visualiza somente os chamados abertos pelo próprio usuário
                        if ($_SESSION['credencial']['nivelPermissao'] < 2 &&
                            $_SESSION['credencial']['idUsuario'] == $value['usuario_idusuario']) {
                            
                            //tratar os dados para imprimir na tabela dinâmica
                            //campo data e hora da abertura
                            $sTratamentoData = new sTratamentoDados($value['dataHoraAbertura']);
                            $dataTratada = $sTratamentoData->tratarData();

                            //campo protocolo
                            $ano = date("Y", strtotime(str_replace('-', '/', $value['dataHoraAbertura'])));
                            $protocolo = str_pad($value['idprotocolo'], 5, 0, STR_PAD_LEFT);
                            $protocolo = $ano . $protocolo;

                            //campo do requerente ou solicitante
                            $nomeRequerente = $value['nomeDoRequerente'] . ' ' . $value['sobrenomeDoRequerente'];
                            $sUsuario = new sUsuario();
                            $sUsuario->setNomeCampo('idusuario');
                            $sUsuario->setValorCampo($value['usuario_idusuario']);
                            $sUsuario->consultar('tMenu2_2.php');
                            $nomeSolicitante = $sUsuario->getNome() . ' ' . $sUsuario->getSobrenome();
                            if ($nomeSolicitante == $nomeRequerente) {
                                $requerente = false;
                                $nome = $nomeSolicitante;
                            } else {
                                $requerente = true;
                                $nome = $nomeRequerente . '<br />por <i>' . $nomeSolicitante . '</i>';
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

                            foreach ($sEtapa->mConexao->getRetorno() as $key => $value) {
                                $idEquipamento = $value['equipamento_idequipamento'];
                                $descricao = $value['descricao'];
                                $idLocal = $value['local_idlocal'];
                                $idPrioridade = $value['prioridade_idprioridade'];
                            }

                            //dados do equipamento                        
                            $sEquipamento = new sEquipamento();
                            $sEquipamento->setNomeCampo('idequipamento');
                            $sEquipamento->setValorCampo($idEquipamento);
                            $sEquipamento->consultar('tMenu2_2.php');

                            foreach ($sEquipamento->mConexao->getRetorno() as $key => $value) {
                                $patrimonio = $value['patrimonio'];
                                $idCategoria = $value['categoria_idcategoria'];
                                $idModelo = $value['modelo_idmodelo'];
                                $idAmbiente = $value['ambiente_idambiente'];
                            }

                            //campo categoria
                            $sCategoria = new sCategoria();
                            $sCategoria->setNomeCampo('idcategoria');
                            $sCategoria->setValorCampo($idCategoria);
                            $sCategoria->consultar('tMenu2_2.php');

                            foreach ($sCategoria->mConexao->getRetorno() as $key => $value) {
                                $categoria = $value['nomenclatura'];
                            }

                            //campo modelo
                            $sModelo = new sModelo();
                            $sModelo->setNomeCampo('idmodelo');
                            $sModelo->setValorCampo($idModelo);
                            $sModelo->consultar('tMenu2_2.php');

                            foreach ($sModelo->mConexao->getRetorno() as $key => $value) {
                                $modelo = $value['nomenclatura'];
                                $idMarca = $value['marca_idmarca'];
                            }

                            //campo marca
                            $sMarca = new sMarca();
                            $sMarca->setNomeCampo('idmarca');
                            $sMarca->setValorCampo($idMarca);
                            $sMarca->consultar('tMenu2_2.php');

                            foreach ($sMarca->mConexao->getRetorno() as $key => $value) {
                                $marca = $value['nomenclatura'];
                            }

                            //campo ambiente
                            $sAmbiente = new sAmbiente();
                            $sAmbiente->setNomeCampo('idambiente');
                            $sAmbiente->setValorCampo($idAmbiente);
                            $sAmbiente->consultar('tMenu2_2.php');

                            foreach ($sAmbiente->mConexao->getRetorno() as $key => $value) {
                                $ambiente = $value['nomenclatura'];
                            }

                            //campo local
                            $sLocal = new sLocal();
                            $sLocal->setNomeCampo('idlocal');
                            $sLocal->setValorCampo($idLocal);
                            $sLocal->consultar('tMenu2_2.php');

                            foreach ($sLocal->mConexao->getRetorno() as $key => $value) {
                                $local = $value['nomenclatura'];
                            }

                            //campo prioridade
                            $sPrioridade = new sPrioridade();
                            $sPrioridade->setNomeCampo('idprioridade');
                            $sPrioridade->setValorCampo($idPrioridade);
                            $sPrioridade->consultar('tMenu2_2.php');

                            foreach ($sPrioridade->mConexao->getRetorno() as $key => $value) {
                                $prioridade = $value['nomenclatura'];
                            }

                            //instancia as configurações do sistema
                            $sConfiguracao = new sConfiguracao();
                            $diretorio = $sConfiguracao->getDiretorioVisualizacaoAcesso();

                            //altera a cor das marcações da prioridade
                            $sTratamentoPrioridade = new sTratamentoDados($prioridade);
                            $dadosPrioridade = $sTratamentoPrioridade->corPrioridade();
                            $posicao = $dadosPrioridade[0];
                            $cor = $dadosPrioridade[1];
                            
                            //cria uma hash para o id do protocolo
                            $idProtocoloCriptografado = base64_encode($idProtocolo);
                            
                            echo <<<HTML
                        <tr>
                            <td>{$protocolo}</td>
                            <td>{$dataTratada}</td>
                            <td>{$nome}</td>
                            <td>{$telefoneTratado}</td>
                            <td>{$patrimonio}</td>
                            <td>
                                {$categoria}<br />
                                {$marca}<br />
                                {$modelo}<br />
                            </td>
                            <td>{$descricao}</td>
HTML;
                            if ($_SESSION['credencial']['nivelPermissao'] > 1) {
                                echo <<<HTML
                            <td>{$ambiente}</td>                            
HTML;
                            }
                            echo <<<HTML
                            <td>{$local}</td>
HTML;
                            if ($_SESSION['credencial']['nivelPermissao'] > 1) {
                                echo <<<HTML
                            <td>
                                <i class="nav-icon fas fa-flag text-{$cor}"></i> {$posicao} - {$prioridade}
                            </td>
HTML;
                            }
                            echo <<<HTML
                            <td>
                                <i class="fas fa-search mr-1"></i>
                                <a href="{$diretorio}tPainel.php?menu=2_2_1&id={$idProtocoloCritptografado}&seguranca={$seguranca}">
                                    Visualizar
                                </a><br />
                                <!--
                                <i class="fas fa-hands-helping mr-1"></i>
                                Em Andamento<br />
                                -->
                            </td>
                        </tr>
HTML;
                        } else if($_SESSION['credencial']['nivelPermissao'] > 1) {
                            //tratar os dados para imprimir na tabela dinâmica
                            //campo data e hora da abertura
                            $sTratamentoData = new sTratamentoDados($value['dataHoraAbertura']);
                            $dataTratada = $sTratamentoData->tratarData();

                            //campo protocolo
                            $ano = date("Y", strtotime(str_replace('-', '/', $value['dataHoraAbertura'])));
                            $protocolo = str_pad($value['idprotocolo'], 5, 0, STR_PAD_LEFT);
                            $protocolo = $ano . $protocolo;

                            //campo do requerente ou solicitante
                            $nomeRequerente = $value['nomeDoRequerente'] . ' ' . $value['sobrenomeDoRequerente'];
                            $sUsuario = new sUsuario();
                            $sUsuario->setNomeCampo('idusuario');
                            $sUsuario->setValorCampo($value['usuario_idusuario']);
                            $sUsuario->consultar('tMenu2_2.php');
                            $nomeSolicitante = $sUsuario->getNome() . ' ' . $sUsuario->getSobrenome();
                            if ($nomeSolicitante == $nomeRequerente) {
                                $requerente = false;
                                $nome = $nomeSolicitante;
                            } else {
                                $requerente = true;
                                $nome = $nomeRequerente . '<br />por <i>' . $nomeSolicitante . '</i>';
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
                            
                            //cria uma hash para o id do protocolo
                            $idProtocoloCriptografado = base64_encode($idProtocolo);

                            //var_dump($sEtapa->mConexao->getRetorno());
                            foreach ($sEtapa->mConexao->getRetorno() as $key => $value) {
                                $idEquipamento = $value['equipamento_idequipamento'];
                                $descricao = $value['descricao'];
                                $idLocal = $value['local_idlocal'];
                                $idPrioridade = $value['prioridade_idprioridade'];
                            }

                            //dados do equipamento                        
                            $sEquipamento = new sEquipamento();
                            $sEquipamento->setNomeCampo('idequipamento');
                            $sEquipamento->setValorCampo($idEquipamento);
                            $sEquipamento->consultar('tMenu2_2.php');

                            foreach ($sEquipamento->mConexao->getRetorno() as $key => $value) {
                                $patrimonio = $value['patrimonio'];
                                $idCategoria = $value['categoria_idcategoria'];
                                $idModelo = $value['modelo_idmodelo'];
                                $idAmbiente = $value['ambiente_idambiente'];
                            }

                            //campo categoria
                            $sCategoria = new sCategoria();
                            $sCategoria->setNomeCampo('idcategoria');
                            $sCategoria->setValorCampo($idCategoria);
                            $sCategoria->consultar('tMenu2_2.php');

                            foreach ($sCategoria->mConexao->getRetorno() as $key => $value) {
                                $categoria = $value['nomenclatura'];
                            }

                            //campo modelo
                            $sModelo = new sModelo();
                            $sModelo->setNomeCampo('idmodelo');
                            $sModelo->setValorCampo($idModelo);
                            $sModelo->consultar('tMenu2_2.php');

                            foreach ($sModelo->mConexao->getRetorno() as $key => $value) {
                                $modelo = $value['nomenclatura'];
                                $idMarca = $value['marca_idmarca'];
                            }

                            //campo marca
                            $sMarca = new sMarca();
                            $sMarca->setNomeCampo('idmarca');
                            $sMarca->setValorCampo($idMarca);
                            $sMarca->consultar('tMenu2_2.php');

                            foreach ($sMarca->mConexao->getRetorno() as $key => $value) {
                                $marca = $value['nomenclatura'];
                            }

                            //campo ambiente
                            $sAmbiente = new sAmbiente();
                            $sAmbiente->setNomeCampo('idambiente');
                            $sAmbiente->setValorCampo($idAmbiente);
                            $sAmbiente->consultar('tMenu2_2.php');

                            foreach ($sAmbiente->mConexao->getRetorno() as $key => $value) {
                                $ambiente = $value['nomenclatura'];
                            }

                            //campo local
                            $sLocal = new sLocal();
                            $sLocal->setNomeCampo('idlocal');
                            $sLocal->setValorCampo($idLocal);
                            $sLocal->consultar('tMenu2_2.php');

                            foreach ($sLocal->mConexao->getRetorno() as $key => $value) {
                                $local = $value['nomenclatura'];
                            }

                            //campo prioridade
                            $sPrioridade = new sPrioridade();
                            $sPrioridade->setNomeCampo('idprioridade');
                            $sPrioridade->setValorCampo($idPrioridade);
                            $sPrioridade->consultar('tMenu2_2.php');

                            foreach ($sPrioridade->mConexao->getRetorno() as $key => $value) {
                                $prioridade = $value['nomenclatura'];
                            }

                            //instancia as configurações do sistema
                            $sConfiguracao = new sConfiguracao();
                            $diretorio = $sConfiguracao->getDiretorioVisualizacaoAcesso();

                            //altera a cor das marcações da prioridade
                            $sTratamentoPrioridade = new sTratamentoDados($prioridade);
                            $dadosPrioridade = $sTratamentoPrioridade->corPrioridade();
                            $posicao = $dadosPrioridade[0];
                            $cor = $dadosPrioridade[1];

                            echo <<<HTML
                        <tr>
                            <td>{$protocolo}</td>
                            <td>{$dataTratada}</td>
                            <td>{$nome}</td>
                            <td>{$telefoneTratado}</td>
                            <td>{$patrimonio}</td>
                            <td>
                                {$categoria}<br />
                                {$marca}<br />
                                {$modelo}<br />
                            </td>
                            <td>{$descricao}</td>
HTML;
                            if ($_SESSION['credencial']['nivelPermissao'] > 1) {
                                echo <<<HTML
                            <td>{$ambiente}</td>                            
HTML;
                            }
                            echo <<<HTML
                            <td>{$local}</td>
HTML;
                            if ($_SESSION['credencial']['nivelPermissao'] > 1) {
                                echo <<<HTML
                            <td>
                                <i class="nav-icon fas fa-flag text-{$cor}"></i> {$posicao} - {$prioridade}
                            </td>
HTML;
                            }
                            echo <<<HTML
                            <td>
                                <i class="fas fa-search mr-1"></i>
                                <a href="{$diretorio}tPainel.php?menu=2_2_1&protocolo={$idProtocoloCriptografado}&seguranca={$seguranca}">
                                    Visualizar
                                </a><br />
                                <!--
                                <i class="fas fa-receipt mr-1"></i>
                                <a href="#">
                                    Atribuir
                                </a><br />
                                <i class="fas fa-hands-helping mr-1"></i>
                                Em Andamento<br />
                                -->
                            </td>
                        </tr>
HTML;
                        }
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
                    <th>Patrimônio</th>
                    <th>Categoria/ Marca/ Modelo</th>
                    <th>Descrição</th>
                    <?php
                    if ($_SESSION['credencial']['nivelPermissao'] > 1) {
                    echo <<<HTML
                    <th>Ambiente</th>
HTML;
                    }
                    ?>
                    <th>Local</th>
                    <?php
                    if ($_SESSION['credencial']['nivelPermissao'] > 1) {
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