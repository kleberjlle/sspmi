<?php


?>
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Etapa 3 - Equipamento</h3>
                </div>
                <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">                            
                            <div class="form-group col-md-2">
                                <label for="patrimonio">Patrimônio</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                                <input class="form-control" type="text" name="patrimonio" id="patrimonio" placeholder="Ex.: 18000">
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>Categoria</label>
                                    <select class="form-control <?php echo isset($alertaCategoriaF1) ? $alertaCategoriaF1 : ''; ?>" name="categoriaF3" id="categoriaF3" form="f3" required="">
                                    <option value="0" selected="">--</option>
                                    <?php
                                    if ($sCategoria->getValidador()) {
                                        foreach ($sCategoria->mConexao->getRetorno() as $value) {
                                            echo '<option value="' . $value['idcategoria'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="protocolo">Data e Hora</label>
                                <h6 id="dataHora"></h6>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="menu2_1_2" name="pagina">                    
                    <div class="card-body">                        
                        <table id="tabelaMenu2_1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Patrimônio</th>
                                    <th>Bem</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Service Tag</th>
                                    <th>Escolher</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>28500</td>
                                    <td>Computador</td>
                                    <td>Dell</td>
                                    <td>OptPlex Micro 7010</td>
                                    <td>5VPMLY3</td>
                                    <td>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="1" value="1" name="selecao">
                                            <label for="1" class="custom-control-label"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>28000</td>
                                    <td>Monitor</td>
                                    <td>LG</td>
                                    <td>24BL550J-BI.AWZNFSZ</td>
                                    <td>N/A</td>
                                    <td>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="2" value="2" name="selecao">
                                            <label for="2" class="custom-control-label"></label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Patrimônio/ Selb</th>
                                    <th>Bem</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Service Tag</th>
                                    <th>Escolher</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <form action="<?php echo $sConfiguracao->getDiretorioVisualizacaoAcesso(); ?>tPainel.php?menu=2_1_2" method="post" enctype="multipart/form-data" name="f2" id="f2">
                    <input type="hidden" value="f2" name="formulario" id="formulario" form="f2">
                    <input type="hidden" value="inserir" name="acaoF2" id="inserir" form="f2">
                    <input type="hidden" value="menu2_1_1" name="paginaF2" id="menu2_1_1" form="f2">
                    <input type="hidden" value="<?php echo $idUsuario ?>" name="idUsuarioF2" id="idUsusarioF2" form="f2">
                    <input type="hidden" value="<?php echo $nome ?>" name="nomeF2" id="nomeF2" form="f2">
                    <input type="hidden" value="<?php echo $sobrenome ?>" name="sobrenomeF2" id="sobrenomeF2" form="f2">
                    <input type="hidden" value="<?php echo $telefone ?>" name="telefoneF2" id="telefoneF2" form="f2">
                    <input type="hidden" value="<?php echo $whatsApp ?>" name="whatsAppF2" id="whatsAppF2" form="f2">
                    <input type="hidden" value="<?php echo $email ?>" name="emailF2" id="emailF2" form="f2">
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Próximo</button>
                    </div>
                </form>
                <!-- /.card -->
            </div>
        </div>
    </div>
</div>
<script>
    var timeDisplay = document.getElementById("dataHora");

    function refreshTime() {
        var dateString = new Date().toLocaleString("en-US", {timeZone: "America/Sao_Paulo"});
        var formattedString = dateString.replace(", ", " ");
        timeDisplay.innerHTML = formattedString;
    }
    setInterval(refreshTime, 1000);
</script>