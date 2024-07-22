<?php
//verifica se são os dados do solicitante ou do requerente
isset($_POST['meusDados']) ? $meusDados = $_POST['meusDados'] : $meusDados = false;

if($meusDados){
    $idUsuario = $_SESSION['credencial']['idUsuario'];
    $nome = $_SESSION['credencial']['nome'];
    $sobrenome = $_SESSION['credencial']['sobrenome'];
    $telefone = $_SESSION['credencial']['telefoneUsuario'];
    $whatsApp = $_SESSION['credencial']['whatsAppUsuario'];
    $email = $_SESSION['credencial']['emailUsuario'];
}
?>

<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Etapa 2 - Descrição</h3>
                </div>
                <!-- form start -->                
                    <div class="card-body">
                        <div class="row">                     
                            <div class="form-group col-md-2">
                                <label for="dataHora">Acesso remoto</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                                <input type="text" class="form-control" id="acessoRemoto" name="acessoRemoto" placeholder="Ex.: 1505389456" required="" form="f2">
                            </div>
                            <!-- próxima build
                            <div class="form-group col-md-3">
                                <label for="print">Print</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="print">
                                        <label class="custom-file-label" for="print">Caminho do diretório</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Enviar</span>
                                    </div>
                                </div>
                            </div>
                            -->
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label>Descrição</label>
                                    <textarea class="form-control" rows="3" placeholder="Descrição..." required=""></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group">                                    
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" id="equipamento" checked="" name="equipamento" value="1">
                                        <label class="custom-control-label" for="equipamento">Possuo identificação do equipamento</label>
                                        <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>Prioridade</label>
                                    <select class="form-control" id="prioridade" name="prioridade" required="">
                                        <?php
                                        if ($_SESSION['permissao'] == 4 || $_SESSION['permissao'] == 5) {
                                            echo <<<HTML
                                        <option value="emergencia">Emergência</option>
                                        <option value="muitoUrgente" selected="">Muito Urgente</option>
                                        <option value="urgente">Urgente</option>
                                        <option value="alta">Alta</option>
                                        <option value="normal" selected="">Normal</option>
HTML;
                                        }
                                        if ($_SESSION['permissao'] == 3) {
                                            echo <<<HTML
                                        <option value="muitoUrgente" selected="">Muito Urgente</option>
                                        <option value="urgente">Urgente</option>
                                        <option value="alta">Alta</option>
                                        <option value="normal" selected="">Normal</option>
HTML;
                                        }
                                        if ($_SESSION['permissao'] == 2) {
                                            echo <<<HTML
                                        <option value="urgente">Urgente</option>
                                        <option value="alta">Alta</option>
                                        <option value="normal" selected="">Normal</option>
HTML;
                                        }
                                        if ($_SESSION['permissao'] == 1) {
                                            echo <<<HTML
                                        <option value="alta">Alta</option>
                                        <option value="normal" selected="">Normal</option>
HTML;
                                        }
                                        ?>                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <form action="<?php echo $sConfiguracao->getDiretorioVisualizacaoAcesso(); ?>sSolicitarSuporte.php" method="post" enctype="multipart/form-data" name="f1" id="f1">
                    <input type="hidden" value="f2" name="formulario" form="f2">
                    <input type="hidden" value="inserir" name="acaoF2" form="f2">
                    <input type="hidden" value="menu2_1_1" name="paginaF2" form="f2">
                    <input type="hidden" value="<?php echo $idUsuario ?>" name="idUsuario" form="f2">
                    <input type="hidden" value="<?php echo $nome ?>" name="nome" form="f2">
                    <input type="hidden" value="<?php echo $sobrenome ?>" name="sobrenome" form="f2">
                    <input type="hidden" value="<?php echo $telefone ?>" name="telefone" form="f2">
                    <input type="hidden" value="<?php echo $whatsApp ?>" name="whatsApp" form="f2">
                    <input type="hidden" value="<?php echo $email ?>" name="email" form="f2">
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Próximo</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </div>    
</div>