<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Etapa 2 - Equipamento</h3>
                </div>
                <!-- /.card-header -->
                <form action="../../sistema/suporte/sSolicitarSuporte.php" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">                            
                            <div class="form-group col-md-1">
                                <label for="dataHora">Patrimônio</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                                <input type="text" class="form-control" id="patrimonio" placeholder="Ex.: 18000">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Equipamento</label>
                                    <select class="form-control" id="equipamento" name="equipamento">
                                        <option value="" selected="" disabled="">--</option>
                                        <option value="administracao">Computador</option>
                                        <option value="desenvolvimento">Impressora</option>
                                        <option value="assistencia">Mouse</option>
                                        <option value="controladoria">Monitor</option>
                                        <option value="agricultura">Notebook</option>                                        
                                        <option value="chefiaDeGabinete">Teclado</option>
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
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
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