<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Etapa 1 - Solicitante</h3>
                </div>
                <!-- form start -->
                <form action="../../sistema/suporte/sSolicitarSuporte.php" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="hidden" value="menu2_1" name="pagina">
                                        <input type="checkbox" class="custom-control-input" id="meusDados" checked="checked" name="meusDados" value="1" onclick="habilitar();">
                                        <label class="custom-control-label" for="meusDados">Utilizar meus dados para a solicitação do suporte</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Secretaria</label>
                                    <select class="form-control" id="secretaria" required="" disabled="">
                                        <option value="" selected="" disabled="">--</option>
                                        <option value="administracao">Administração</option>
                                        <option value="agricultura">Agricultura e Pesca</option>
                                        <option value="assistencia">Assistência Social</option>
                                        <option value="chefiaDeGabinete">Chefia de Gabinete do Prefeito</option>
                                        <option value="controladoria">Controladoria Interna</option>
                                        <option value="desenvolvimento">Desenvolvimento Social e Econômico</option>
                                        <option value="educacao">Educação</option>
                                        <option value="esporte">Esporte e Lazer</option>
                                        <option value="fazenda">Fazenda</option>
                                        <option value="infraestrutura">Infraestrutura</option>
                                        <option value="meioAmbiente">Meio Ambiente</option>
                                        <option value="planejamento">Planejamento Urbano</option>
                                        <option value="procuradoria">Procuradoria Jurídica</option>
                                        <option value="saude">Saúde</option>
                                        <option value="segurancaPublica">Segurança Pública e Trânsito</option>
                                        <option value="turismo">Turismo e Cultura</option>
                                        <option value="ouvidoria">Ouvidoria</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Departamento/ Unidade</label>
                                    <select class="form-control" id="departamentoUnidade" required="" disabled="">
                                        <option value="" selected="" disabled="">--</option>
                                        <option value="licitacao">Licitações, Contratos e Compras</option>
                                        <option value="patrimonio">Patrimônio e Frotas</option>
                                        <option value="rh">Recursos Humanos</option>
                                        <option value="tecnologia">Tecnologia da Informação</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Coordenação</label>
                                    <select class="form-control" name="coordenacao" id="coordenacao" required="" disabled="">
                                        <option value="" selected="" >--</option>
                                        <option value="Informática e Sistemas">Informática e Sistemas</option>
                                        <option value="Pessoal e Recursos Humanos">Pessoal e Recursos Humanos</option>
                                        <option value="Compras e Almoxarifado">Compras e Almoxarifado</option>
                                        <option value="Contratos e Licitacões">Contratos e Licitações</option>
                                        <option value="Patrimônio Público">Patrimônio Público</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Setor</label>
                                    <select class="form-control" name="setor" id="setor" required="" disabled="">
                                        <option value="" selected="">--</option>
                                        <option value="Informática">Informática</option>
                                        <option value="Captacão e Recursos">Captação de Recursos</option>
                                        <option value="Gestão de Convênios">Gestão de Convênios</option>
                                        <option value="Pessoal">Pessoal</option>
                                        <option value="Recursos Humanos">Recursos Humanos</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-1">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required="" disabled="">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="sobrenome">Sobrenome</label>
                                <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome" required="" disabled="">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="telefonePessoal">Telefone</label>
                                <input type="text" class="form-control" id="telefonePessoal" name="telefonePessoal" placeholder="(XX) X XXXX-XXXX" required="" disabled="">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="whatsappPessoal">WhatsApp</label>
                                <input type="text" class="form-control" id="whatsappPessoal" name="whatsappPessoal" placeholder="(XX) X XXXX-XXXX" disabled="">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="emailPessoal">Email</label>
                                <input type="text" class="form-control" id="emailPessoal" name="emailPessoal" placeholder="Email" disabled="">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Próxima</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
    function habilitar() {
        if (document.getElementById('meusDados').checked) {
            document.getElementById('secretaria').disabled = true;
            document.getElementById('departamentoUnidade').disabled = true;
            document.getElementById('coordenacao').disabled = true;
            document.getElementById('setor').disabled = true;
            document.getElementById('nome').disabled = true;
            document.getElementById('sobrenome').disabled = true;
            document.getElementById('telefonePessoal').disabled = true;
            document.getElementById('whatsappPessoal').disabled = true;
            document.getElementById('emailPessoal').disabled = true;
        } else {
            document.getElementById('secretaria').disabled = false;
            document.getElementById('departamentoUnidade').disabled = false;
            document.getElementById('coordenacao').disabled = false;
            document.getElementById('setor').disabled = false;
            document.getElementById('nome').disabled = false;
            document.getElementById('sobrenome').disabled = false;
            document.getElementById('telefonePessoal').disabled = false;
            document.getElementById('whatsappPessoal').disabled = false;
            document.getElementById('emailPessoal').disabled = false;
        }
    }
</script>