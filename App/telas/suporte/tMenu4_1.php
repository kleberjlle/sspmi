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
                        <div class="form-group col-md-12">
                            <label for="secretaria">Nomenclatura</label>
                            <input type="text" class="form-control" name="secretaria" placeholder="Ex.: Administração" form="secretaria" required="">
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="endereco">Endereço</label>
                            <input type="text" class="form-control" name="endereco" placeholder="Ex.: Rua 960, Mariana Michels Borges, 201" form="endereco" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Ambiente</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                            <select class="form-control" id="ambiente" name="ambiente" form="secretaria" required="">
                                <option value="" selected="" disabled="">--</option>
                                <option value="interno">Interno</option>
                                <option value="externo">Externo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" name="telefone" placeholder="Ex.: 47 3443-8832" form="secretaria">
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="whatsApp">WhatsApp</label>
                            <input type="text" class="form-control" name="whatsApp" placeholder="Ex.: 47 9 9999-9999" form="secretaria">
                        </div>
                    </div>
                </div>
                <form action="../../sistema/suporte/sRegistrarLocal.php" method="post" id="secretaria" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" value="secretaria" name="opcao" form="secretaria">
                        <input type="hidden" value="menu4_1" name="pagina" form="secretaria">
                        <button type="submit" class="btn btn-primary">Registrar</button>
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
                                    <option value="administracao">Administração</option>
                                    <option value="infraestrutura">Infraestrutura</option>
                                    <option value="ouvidoria">Ouvidoria</option>
                                    <option value="turismo">Turismo</option>
                                </select>
                            </div>
                        </div>  
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="departamentoUnidade">Nomenclatura</label>
                            <input type="text" class="form-control" name="departamentoUnidade" placeholder="Ex.: Tecnologia da Informação" form="departamentoUnidade" required="">
                            <input type="hidden" value="departamentoUnidade" name="opcao" form="departamentoUnidade">
                            <input type="hidden" value="menu4_1" name="pagina" form="departamentoUnidade">
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="endereco">Endereço</label>
                            <input type="text" class="form-control" name="endereco" placeholder="Ex.: Rua 960, Mariana Michels Borges, 201" form="endereco" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Ambiente</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                            <select class="form-control" id="ambiente" name="ambiente" form="departamentoUnidade" required="">
                                <option value="" selected="" disabled="">--</option>
                                <option value="interno">Interno</option>
                                <option value="externo">Externo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" name="telefone" placeholder="Ex.: 47 3443-8832" form="departamentoUnidade">
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="whatsApp">WhatsApp</label>
                            <input type="text" class="form-control" name="whatsApp" placeholder="Ex.: 47 9 9999-9999" form="departamentoUnidade">
                        </div>
                    </div>
                </div>
                <form action="../../sistema/suporte/sRegistrarLocal.php" id="departamentoUnidade" method="post" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
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
                                    <option value="administracao">Administração</option>
                                    <option value="infraestrutura">Infraestrutura</option>
                                    <option value="ouvidoria">Ouvidoria</option>
                                    <option value="turismo">Turismo</option>
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
                                    <option value="recursosHumanos">Recursos Humanos</option>
                                    <option value="tecnologiaDaInformacao">Tecnologia da Informação</option>
                                    <option value="frotas">Frotas</option>
                                    <option value="patrimonio">Patrimônio</option>
                                    <option value="licitacoesECompras">Licitações e Compras</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="coordenacao">Nomenclatura</label>
                            <input type="text" class="form-control" name="coordenacao" placeholder="Ex.: Informática" form="coordenacao" required="">
                            <input type="hidden" value="coordenacao" name="opcao" form="coordenacao">
                            <input type="hidden" value="menu4_1" name="pagina" form="coordenacao">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Ambiente</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                            <select class="form-control" id="ambiente" name="ambiente" form="coordenacao" required="">
                                <option value="" selected="" disabled="">--</option>
                                <option value="interno">Interno</option>
                                <option value="externo">Externo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" name="telefone" placeholder="Ex.: 47 3443-8832" form="coordenacao">
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="whatsApp">WhatsApp</label>
                            <input type="text" class="form-control" name="whatsApp" placeholder="Ex.: 47 9 9999-9999" form="coordenacao">
                        </div>
                    </div>
                </div>
                <form action="../../sistema/suporte/sRegistrarLocal.php" id="coordenacao" method="post" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
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
                                    <option value="administracao">Administração</option>
                                    <option value="infraestrutura">Infraestrutura</option>
                                    <option value="ouvidoria">Ouvidoria</option>
                                    <option value="turismo">Turismo</option>
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
                                    <option value="recursosHumanos">Recursos Humanos</option>
                                    <option value="tecnologiaDaInformacao">Tecnologia da Informação</option>
                                    <option value="frotas">Frotas</option>
                                    <option value="patrimonio">Patrimônio</option>
                                    <option value="licitacoesECompras">Licitações e Compras</option>
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
                                    <option value="informaticaESistemas">Informática e Sistemas</option>
                                    <option value="pessoalERecursosHumanos">Pessoal e Recursos Humanos</option>
                                    <option value="comprasEAlmoxarifado">Compras e Almoxarifado</option>
                                    <option value="contratosELicitacoes">Contratos e Licitações</option>
                                    <option value="patrimonioPublico">Patrimônio Público</option>
                                </select>
                            </div>
                        </div>  
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="setor">Nomenclatura</label>
                            <input type="text" class="form-control" name="setor" placeholder="Ex.: Informática" form="setor" required="">
                            <input type="hidden" value="setor" name="opcao" form="setor">
                            <input type="hidden" value="menu4_1" name="pagina" form="setor">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Ambiente</label> <a href="../acesso/tFAQ.php" target="_blank"><i class="fas fa-info-circle text-primary mr-1"></i></a>
                            <select class="form-control" id="ambiente" name="ambiente" form="setor" required="">
                                <option value="" selected="" disabled="">--</option>
                                <option value="interno">Interno</option>
                                <option value="externo">Externo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" name="telefone" placeholder="Ex.: 47 3443-8832" form="setor">
                        </div>
                    </div>
                    <div class="row">                      
                        <div class="form-group col-md-12">
                            <label for="whatsApp">WhatsApp</label>
                            <input type="text" class="form-control" name="whatsApp" placeholder="Ex.: 47 9 9999-9999" form="setor">
                        </div>
                    </div>
                </div>
                <form action="../../sistema/suporte/sRegistrarLocal.php" id="setor" method="post" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>        
        <!-- /.card -->
    </div>
    <div class="row">
        <div class="col-lg-12 col-12">
            <?php
            require_once '../../sistema/acesso/sNotificacao.php';

            if (isset($codigo)) {
                $mensagem = explode('|', $codigo);
                echo <<<HTML
                <div class="col-mb-3">
                    <div class="card card-outline card-{$mensagem[0]}">
                        <div class="card-header">
                            <h3 class="card-title">{$mensagem[1]}</h3>
                        </div>
                        <div class="card-body">
                            {$mensagem[2]}
                        </div>
                    </div>
                </div>
HTML;
            }
            ?>
        </div>
    </div>
</div>