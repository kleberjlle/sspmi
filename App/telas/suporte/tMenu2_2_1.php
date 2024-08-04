<?php

use App\sistema\acesso\{
    sTratamentoDados,
    sConfiguracao
};
use App\sistema\suporte\{
    sProtocolo,
};

if (isset($_GET)) {
    //verifica se o id do usuário via GET é o mesmo da sessão
    if ($_GET['idUsuario'] != $_SESSION['credencial']['idUsuario'] && $_SESSION['credencial']['nivelPermissao'] < 2) {
        //solicitar saída com tentativa de violação
        $sSair = new sSair();
        $sSair->verificar('0');
    }
    $idProtocolo = $_GET['id'];
}

//consulta os dados para apresentar na tabela
$sProtocolo = new sProtocolo();
$sProtocolo->setNomeCampo('idprotocolo');
$sProtocolo->setValorCampo($idProtocolo);
$sProtocolo->consultar('tMenu2_2_2.php');

$sConfiguracao = new sConfiguracao();

if ($sProtocolo->getValidador()) {
    foreach ($sProtocolo->mConexao->getRetorno() as $value) {
        //tratamento da data de abertura
        $sTratamentoDataAbertura = new sTratamentoDados($value['dataHoraAbertura']);
        $dataAberturaTratada = $sTratamentoDataAbertura->tratarData();

        //campo protocolo
        $ano = date("Y", strtotime(str_replace('-', '/', $value['dataHoraAbertura'])));
        $protocolo = str_pad($value['idprotocolo'], 5, 0, STR_PAD_LEFT);
        $protocolo = $ano . $protocolo;

        //tratamento da data de encerramento
        if (!is_null($value['dataHoraEncerramento'])) {
            $sTratamentoDataEncerramento = new sTratamentoDados($value['dataHoraEncerramento']);
            $dataEncerramentoTratada = $sTratamentoDataEncerramento->tratarData();
        } else {
            $dataEncerramentoTratada = '--/--/---- --:--:--';
        }
    }
} else {
    //notificar erro 
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Image -->
            <div class="card card-orange card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="<?php echo $sConfiguracao->getDiretorioPrincipal() ?>vendor/almasaeed2010/adminlte/dist/img/user2-160x160.jpg" alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center">João Fictício</h3>
                    <p class="text-muted text-center">aberto por <i>Kleber Pereira de Almeida</i></p>
                    <ul class="list-group list-group-unbordered mb-4">
                        <li class="list-group-item">
                            <i class="fas fa-venus-mars mr-1"></i><b> Sexo</b><a class="float-right">Masculino</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-building mr-1"></i><b> Secretaria</b><a class="float-right">Administração</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-house-user mr-1"></i><b> Departamento/ Unidade</b><a class="float-right">Tecnologia da Informação</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-house-user mr-1"></i><b> Coordenação</b> <a class="float-right">Informática e Sistemas</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-house-user mr-1"></i><b> Setor</b> <a class="float-right">Informática</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-map-marked-alt mr-1"></i><b> Endereço</b> <a class="float-right">Rua 960 Mariana Michels Borges, 201</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-briefcase mr-1"></i><b> Cargo/ Função</b> <a class="float-right">Técnico de Informática II</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-phone mr-1"></i><b> Telefone Corporativo</b> <a class="float-right">(47) 3443-8832</a><br />
                            <a class="float-right">(47) 3443-8864</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fab fa-whatsapp mr-1"></i><b> Whatsapp Corporativo</b> <a class="float-right">(47) 9 8827-2029</a><br />
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-envelope-open-text mr-1"></i><b> Email Corporativo</b> <a class="float-right">suporte@itapoa.sc.gov.br</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-phone mr-1"></i><b> Telefone Pessoal</b> <a class="float-right">(47) 9 9611-5955</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fab fa-whatsapp mr-1"></i><b> Whatsapp Pessoal</b> <a class="float-right">(47) 9 9611-5955</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-envelope-open-text mr-1"></i><b> Email Pessoal</b> <a class="float-right">kleberjlle@gmail.com</a>
                        </li>
                    </ul>
                </div>
                <form action="tPainel.php" method="get">
                    <input type="hidden" name="menu" value="1_1_1">
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Alterar</button>
                    </div>
                </form>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col 
        <div class="col-md-4">
            <div class="card card-orange card-outline">
                <div class="card-header">
                    <h3 class="card-title">Bem</h3>
                    <!-- /.card-tools 
                </div>
                <div class="card-body box-profile">
                    <ul class="list-group list-group-unbordered mb-4">
                        <li class="list-group-item">
                            <i class="fas fa-barcode mr-1"></i><b> Patrimônio</b><a class="float-right">28000</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-laptop mr-1"></i><b> Categoria</b><a class="float-right">Computador</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-tag mr-1"></i><b> Marca</b> <a class="float-right">Dell</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-tags mr-1"></i><b> Modelo</b> <a class="float-right">OptPlex Micro 7010</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-qrcode mr-1"></i><b> Service Tag</b> <a class="float-right">5VPMLY3</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-barcode mr-1"></i><b> Número de Série</b> <a class="float-right">N/A</a><br />
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-bolt mr-1"></i><b> Tensão de Entrada</b> <a class="float-right">19.5V</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-plug mr-1"></i><b> Corrente de Entrada</b> <a class="float-right">3.34A</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fab fa-windows mr-1"></i><b> Sistema Operacional</b> <a class="float-right">Windows 11 Professional</a>
                        </li>
                    </ul>
                </div>
                <?php
                if ($_SESSION['permissao'] > 1) {
                    echo <<<HTML
                    <form action="../../sistema/suporte/sAlterarEquipamento.php" method="post">
                        <input type="hidden" name="pagina" value="2_2_1">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Alterar</button>
                        </div>
                    </form>
HTML;
                }
                ?>

                <!-- /.card-body
            </div>
        </div>
        <?php
        
        foreach ($sProtocolo->mConexao->getRetorno() as $key => $value) {
            
            
            
        //altera a cor das marcações da prioridade
        switch ($prioridade) {
            case 'Normal':
                $cor = 'text-blue';
                $posicao = 1;
                break;
            case 'Alta':
                $cor = 'text-green';
                $posicao = 2;
                break;
            case 'Urgente':
                $cor = 'text-yellow';
                $posicao = 3;
                break;
            case 'Muito Urgente':
                $cor = 'text-orange';
                $posicao = 4;
                break;
            case 'Emergente':
                $cor = 'text-red';
                $posicao = 5;
                break;
            default:
                break;
        }
        
        
        echo <<<HTML
        <div class="col-md-4">
            <div class="card card-orange card-outline collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Protocolo n.º: 20230001 - Etapa 1 (atual)</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools 
                </div>
                <!-- /.card-header 
                <div class="card-body box-profile">
                    <ul class="list-group list-group-unbordered mb-4">
                        <li class="list-group-item">
                            <i class="fas fa-route mr-1"></i><b> Etapa</b><a class="float-right">1</a>
                        </li>
                        <li class="list-group-item">
                            <i class="far fa-flag text-orange mr-1"></i><b> Prioridade</b><a class="float-right text-orange">Muito Urgente</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-clock mr-1"></i><b> Data e Hora - Solicitação</b><a class="float-right">22/12/2023 9:03</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-clock mr-1"></i><b> Data e Hora - Etapa 1</b><a class="float-right">23/12/2023 10:15</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-broadcast-tower mr-1"></i><b> Acesso Remoto</b> <a class="float-right">N/A</a>
                        </li>
                        <li class="list-group-item">
                            <i class="far fa-images mr-1"></i><b> Print</b>
                            <a class="float-right">
                                <img src="http://localhost/SSPMI/App/telas/suporte/img/2023000101.png" width="150px" height="100px" alt="..." data-toggle="modal" data-target="#modal-xl">
                                <img src="https://placehold.it/150x100" alt="...">
                            </a>
                        </li>
                        <li class="list-group-item">
                            <i class="far fa-file-alt mr-1"></i><b> Descrição</b> <a class="float-right">Sem conexão</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-project-diagram mr-1"></i><b> Local</b> <a class="float-right">Bancada 4</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-map-marked-alt mr-1"></i><b> Ambiente</b> <a class="float-right">Interno</a>
                        </li>
                        <li class="list-group-item">
                            <i class="far fa-id-card mr-1"></i><b> Responsável</b> <a class="float-right">Kleber</a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas far fa-file-alt mr-1"></i><b> Solução</b> <a class="float-right">--</a>
                        </li>
                        <!-- /.card-body
                    </ul>
                </div>
                <!-- /.card-body 


                <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-left" form="alterarSuporte">Alterar</button>                    
                    <button type="submit" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal2">Finalizar Suporte</button>
                    <form action="../../sistema/suporte/sAlterarSuporte.php" id="alterarSuporte" method="post">
                        <input type="hidden" name="pagina" value="2_2_1">
                    </form>
                    <form action="../../sistema/suporte/sFinalizarSuporte.php" id="finalizarSuporte" method="post">
                        <input type="hidden" name="pagina" value="2_2_1">
                    </form>
                </div>
            </div>
            <!-- /.card 
        </div>
HTML;
        }
        ?>
        
    </div>
    <!-- /.row 
</div>
<!-- /.container-fluid 
<div class="modal fade" id="modal-xl">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Imagem 1</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p><img src="http://localhost/SSPMI/App/telas/suporte/img/2023000101.png" width="1024px" height="640px" alt="..."></p>
            </div>            
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
-->
<!-- /.container-fluid -->
<div class="modal fade" id="modal2">
    <div class="modal-dialog modal-xl card-orange card-outline">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Finalizar Suporte</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-sm-6">
                    <!-- textarea -->
                    <div class="form-group">
                        <label>Solução</label>
                        <textarea class="form-control" rows="3" required="" placeholder="Ex.: Alterado endereço de Gateway para 192.168.0.243"></textarea>
                    </div>
                </div>
            </div>
            <form action="../../sistema/suporte/sFinalizarSuporte.php" id="finalizarSuporte" method="post">
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary float-left" form="finalizarSuporte">Finalizar</button>
                </div>
            </form>
        </div>

    </div>

</div>