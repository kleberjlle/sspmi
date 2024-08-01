<?php
require_once '../../sistema/acesso/sNotificacao.php';

//verifica a opção de menu
isset($_GET['menu']) ? $menu = $_GET['menu'] : $menu = "0";
//verifica se há retorno de notificações
if (isset($_GET['notificacao'])) {
    $notificacao = $_GET['notificacao'];
    $codigo = notificacao($notificacao);
}
?>
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <!--registro secretaria-->
        <div class="col-md-3">
            <!-- general form elements -->
            <div class="card card-outline card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Secretaria</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- form start -->                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Secretaria</label>
                                <select class="form-control" name="secretaria" required="" form="secretaria">
                                    <option value="" selected="" disabled="">--</option>
                                    <option value="Administração">Administração</option>
                                    <option value="Infraestrutura">Infraestrutura</option>
                                    <option value="Ouvidoria">Ouvidoria</option>
                                    <option value="Turismo">Turismo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Ambiente</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                            <select class="form-control" id="ambiente" name="ambiente" form="secretaria" required="">
                                <option value="interno" selected="">Interno</option>
                                <option value="externo">Externo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" name="telefone" value="47 3443-8832" form="secretaria">
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="whatsApp">WhatsApp</label>
                            <input type="text" class="form-control" name="whatsApp" value="47 9 9999-9999" form="secretaria">
                        </div>
                    </div>
                </div>
                <form action="#" method="post" id="secretaria" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" value="menu4_2" name="pagina" form="secretaria">
                        <input type="hidden" value="secretaria" name="opcao" form="secretaria">
                        <button type="submit" class="btn btn-primary">alterar</button>
                    </div>
                </form>
            </div>
        </div>
        <!--registro deaprtamento/ unidade-->
        <div class="col-md-3">
            <!-- general form elements -->
            <div class="card card-outline card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Departamento/ Unidade</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- form start -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Secretaria</label>
                                <select class="form-control" name="secretaria" required="" form="departamentoUnidade">
                                    <option value="" selected="" disabled="">--</option>
                                    <option value="Administração">Administração</option>
                                    <option value="Infraestrutura">Infraestrutura</option>
                                    <option value="Ouvidoria">Ouvidoria</option>
                                    <option value="Turismo">Turismo</option>
                                </select>
                            </div>
                        </div>  
                    </div>
                    <div class="row">                      
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Departamento/ Unidade</label>
                                <select class="form-control" name="departamentoUnidade" required="" form="departamentoUnidade">
                                    <option value="" selected="" disabled="">--</option>
                                    <option value="Recursos Humanos">Recursos Humanos</option>
                                    <option value="Tecnologia da Informação">Tecnologia da Informação</option>
                                    <option value="Frotas">Frotas</option>
                                    <option value="Patrimônio">Patrimônio</option>
                                    <option value="Licitações e Compras">Licitações e Compras</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Ambiente</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                            <select class="form-control" id="ambiente" name="ambiente" form="departamentoUnidade" required="">
                                <option value="interno" selected="">Interno</option>
                                <option value="externo">Externo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" name="telefone" value="47 3443-8832" form="departamentoUnidade">
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="whatsApp">WhatsApp</label>
                            <input type="text" class="form-control" name="whatsApp" value="47 9 9999-9999" form="departamentoUnidade">
                        </div>
                    </div>
                </div>
                <form action="#" id="departamentoUnidade" method="post" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" value="menu4_2" name="pagina" form="departamentoUnidade">
                        <input type="hidden" value="departamentoUnidade" name="opcao" form="departamentoUnidade">
                        <button type="submit" class="btn btn-primary">Alterar</button>
                    </div>
                </form>
            </div>
        </div>
        <!--registro coordenação-->
        <div class="col-md-3">
            <!-- general form elements -->
            <div class="card card-outline card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Coordenação</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- form start -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Secretaria</label>
                                <select class="form-control" name="secretaria" required="" form="coordenacao">
                                    <option value="" selected="" disabled="">--</option>
                                    <option value="Administração">Administração</option>
                                    <option value="Infraestrutura">Infraestrutura</option>
                                    <option value="Ouvidoria">Ouvidoria</option>
                                    <option value="Turismo">Turismo</option>
                                </select>
                            </div>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Departamento/ Unidade</label>
                                <select class="form-control" name="departamentoUnidade" required="" form="coordenacao">
                                    <option value="" selected="" disabled="">--</option>
                                    <option value="Recursos Humanos">Recursos Humanos</option>
                                    <option value="Tecnologia da Informação">Tecnologia da Informação</option>
                                    <option value="Frotas">Frotas</option>
                                    <option value="Patrimônio">Patrimônio</option>
                                    <option value="Licitacões e Compras">Licitações e Compras</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">                      
                         <div class="col-md-12">
                            <div class="form-group">
                                <label>Coordenação</label>
                                <select class="form-control" name="coordenacao" required="" form="coordenacao">
                                    <option value="" selected="" >--</option>
                                    <option value="Informática e Sistemas">Informática e Sistemas</option>
                                    <option value="Pessoal e Recursos Humanos">Pessoal e Recursos Humanos</option>
                                    <option value="Compras e Almoxarifado">Compras e Almoxarifado</option>
                                    <option value="Contratos e Licitacões">Contratos e Licitações</option>
                                    <option value="Patrimônio Público">Patrimônio Público</option>
                                </select>
                            </div>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Ambiente</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                            <select class="form-control" id="ambiente" name="ambiente" form="coordenacao" required="">
                                <option value="interno">Interno</option>
                                <option value="externo">Externo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" name="telefone" value="47 3443-8832" form="coordenacao">
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="whatsApp">WhatsApp</label>
                            <input type="text" class="form-control" name="whatsApp" value="47 9 9999-9999" form="coordenacao">
                        </div>
                    </div>
                </div>
                <form action="#" id="coordenacao" method="post" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" value="menu4_2" name="pagina" form="coordenacao">
                        <input type="hidden" value="coordenacao" name="opcao" form="coordenacao">
                        <button type="submit" class="btn btn-primary">Alterar</button>
                    </div>
                </form>
            </div>
        </div>
        <!--registro setor-->
        <div class="col-md-3">
            <!-- general form elements -->
            <div class="card card-outline card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Setor</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- form start -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Secretaria</label>
                                <select class="form-control" name="secretaria" required="" form="setor">
                                    <option value="" selected="" disabled="">--</option>
                                    <option value="Administracão">Administração</option>
                                    <option value="Infraestrutura">Infraestrutura</option>
                                    <option value="Ouvidoria">Ouvidoria</option>
                                    <option value="Turismo">Turismo</option>
                                </select>
                            </div>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Departamento/ Unidade</label>
                                <select class="form-control" name="departamentoUnidade" required="" form="setor">
                                    <option value="" selected="" disabled="">--</option>
                                    <option value="Recursos Humanos">Recursos Humanos</option>
                                    <option value="Tecnologia da Informacão">Tecnologia da Informação</option>
                                    <option value="Frotas">Frotas</option>
                                    <option value="Patrimônio">Patrimônio</option>
                                    <option value="Licitacões e Compras">Licitações e Compras</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Coordenação</label>
                                <select class="form-control" name="coordenacao" required="" form="setor">
                                    <option value="" selected="" >--</option>
                                    <option value="Informática e Sistemas">Informática e Sistemas</option>
                                    <option value="Pessoal e Recursos Humanos">Pessoal e Recursos Humanos</option>
                                    <option value="Compras e Almoxarifado">Compras e Almoxarifado</option>
                                    <option value="Contratos e Licitacões">Contratos e Licitações</option>
                                    <option value="Patrimônio Público">Patrimônio Público</option>
                                </select>
                            </div>
                        </div>  
                    </div>
                    <div class="row">                      
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Setor</label>
                                <select class="form-control" name="setor" required="" form="setor">
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
                        <div class="form-group col-md-12">
                            <label>Ambiente</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                            <select class="form-control" id="ambiente" name="ambiente" form="setor" required="">
                                <option value="interno">Interno</option>
                                <option value="externo">Externo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" name="telefone" value="47 3443-8832" form="setor">
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="whatsApp">WhatsApp</label>
                            <input type="text" class="form-control" name="whatsApp" value="47 9 9999-9999" form="setor">
                        </div>
                    </div>
                </div>
                <form action="#" id="setor" method="post" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" value="menu4_2" name="pagina" form="setor">
                        <input type="hidden" value="setor" name="opcao" form="setor">
                        <button type="submit" class="btn btn-primary">Alterar</button>
                    </div>
                </form>
            </div>
        </div>        
        <!-- /.card -->
    </div>
</div>