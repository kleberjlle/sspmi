<?php
use App\sistema\acesso\{sConfiguracao};

$sConfiguracao = new sConfiguracao();
?>

<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Etapa 2 - Alterar</h3>
                </div>
                <!-- form start -->
                <form action="<?php echo $sConfiguracao->getDiretorioPrincipal(); ?>sistema/acesso/sAlterarDadosDoUsuario.php">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-1">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="<?php echo $sConfiguracao->getDiretorioPrincipal(); ?>vendor/almasaeed2010/adminlte/dist/img/user2-160x160.jpg" alt="User profile picture">
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="imagem">Alterar Imagem</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="imagem">
                                        <label class="custom-file-label" for="imagem"></label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Enviar</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" value="<?php echo $_SESSION['credencial']['nome']; ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="sobrenome">Sobrenome</label>
                                <input type="text" class="form-control" id="sobrenome" value="<?php echo $_SESSION['credencial']['sobrenome']; ?>">
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>Sexo</label>
                                    <select class="form-control">
                                        <option <?php echo $_SESSION['credencial']['sexo'] == 'Masculino' ? 'selected=\"\"' : ''; ?>>Masculino</option>
                                        <option <?php echo $_SESSION['credencial']['sexo'] == 'Feminino' ? 'selected=\"\"' : ''; ?>>Feminino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="telefonePessoal">Telefone Pessoal</label>
                                <input type="text" class="form-control" id="telefonePessoal" value="<?php echo $_SESSION['credencial']['telefoneUsuario']; ?>">
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>WhatsApp</label>
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" id="meusDados" checked="checked" name="meusDados" value="1" <?php echo $_SESSION['credencial']['whatsAppUsuario'] ? '' : 'disabled=\"\"'; ?>>
                                        <label class="custom-control-label" for="meusDados">Sim</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="emailPessoal">Email Pessoal</label>
                                <input type="text" class="form-control" id="emailPessoal" value="<?php echo $_SESSION['credencial']['emailUsuario']; ?>" <?php echo $_SESSION['credencial']['nivelPermissao'] > 4 ? '' : 'disabled=\"\"'; ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Secretaria</label>
                                    <select class="form-control" <?php echo $_SESSION['credencial']['nivelPermissao'] > 2 ? '' : 'disabled=\"\"'; ?>>
                                        <option <?php echo $_SESSION['credencial']['secretaria'] == 'Administração' ? 'selected=\"\"' : ''; ?>>Administração</option>
                                        <option <?php echo $_SESSION['credencial']['secretaria'] == 'Agricultura e Pesca' ? 'selected=\"\"' : ''; ?>>Agricultura e Pesca</option>
                                        <option<?php echo $_SESSION['credencial']['secretaria'] == 'Assistência Social' ? 'selected=\"\"' : ''; ?>>Assistência Social</option>
                                        <option<?php echo $_SESSION['credencial']['secretaria'] == 'Chefia de Gabinete do Prefeito' ? 'selected=\"\"' : ''; ?>>Chefia de Gabinete do Prefeito</option>
                                        <option<?php echo $_SESSION['credencial']['secretaria'] == 'Controladoria Interna' ? 'selected=\"\"' : ''; ?>>Controladoria Interna</option>
                                        <option<?php echo $_SESSION['credencial']['secretaria'] == 'Desenvolvimento Social e Econômico' ? 'selected=\"\"' : ''; ?>>Desenvolvimento Social e Econômico</option>
                                        <option<?php echo $_SESSION['credencial']['secretaria'] == 'Educação' ? 'selected=\"\"' : ''; ?>>Educação</option>
                                        <option<?php echo $_SESSION['credencial']['secretaria'] == 'Esporte e Lazer' ? 'selected=\"\"' : ''; ?>>Esporte e Lazer</option>
                                        <option<?php echo $_SESSION['credencial']['secretaria'] == 'Fazenda' ? 'selected=\"\"' : ''; ?>>Fazenda</option>
                                        <option<?php echo $_SESSION['credencial']['secretaria'] == 'Infraestrutura' ? 'selected=\"\"' : ''; ?>>Infraestrutura</option>
                                        <option<?php echo $_SESSION['credencial']['secretaria'] == 'Meio Ambiente' ? 'selected=\"\"' : ''; ?>>Meio Ambiente</option>
                                        <option<?php echo $_SESSION['credencial']['secretaria'] == 'Planejamento Urbano' ? 'selected=\"\"' : ''; ?>>Planejamento Urbano</option>
                                        <option<?php echo $_SESSION['credencial']['secretaria'] == 'Procuradoria-Geral do Município' ? 'selected=\"\"' : ''; ?>>Procuradoria-Geral do Município</option>
                                        <option<?php echo $_SESSION['credencial']['secretaria'] == 'Saúde' ? 'selected=\"\"' : ''; ?>>Saúde</option>
                                        <option<?php echo $_SESSION['credencial']['secretaria'] == 'Segurança Pública e Trânsito' ? 'selected=\"\"' : ''; ?>>Segurança Pública e Trânsito</option>
                                        <option<?php echo $_SESSION['credencial']['secretaria'] == 'Turismo e Cultura' ? 'selected=\"\"' : ''; ?>>Turismo e Cultura</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Departamento/ Unidade</label>
                                    <select class="form-control" <?php echo $_SESSION['permissao'] > 2 ? '' : 'disabled=\"\"'; ?>>
                                        <option>Licitações, Contratos e Compras</option>
                                        <option>Patrimônio e Frotas</option>
                                        <option>Recursos Humanos</option>
                                        <option selected="">Tecnologia da Informação</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cargo/ Função</label>
                                    <select class="form-control" <?php echo $_SESSION['credencial']['nivelPermissao'] > 2 ? '' : 'disabled=\"\"'; ?>>
                                        <option>Diretor</option>
                                        <option>Coordenador</option>
                                        <option>Agente Administrativo</option>
                                        <option selected="">Técnico de Informática</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="telefoneSetor">Telefone Setor</label>
                                <input type="text" class="form-control" id="telefoneCorporativo" value="<?php echo $_SESSION['credencial']['telefoneSetor'] ?>" <?php echo $_SESSION['credencial']['nivelPermissao'] > 2 ? '' : 'disabled=\"\"'; ?>>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="whatsappCorporativo">WhatsApp Corporativo</label>
                                <input type="text" class="form-control" id="whatsappCorporativo" value="(47) 9 8827-2029" <?php echo $_SESSION['permissao'] > 2 ? '' : 'disabled=\"\"'; ?>>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="emailCorporativo">Email Corporativo</label>
                                <input type="text" class="form-control" id="emailCorporativo" value="suporte@itapoa.sc.gov.br" <?php echo $_SESSION['permissao'] > 2 ? '' : 'disabled=\"\"'; ?>>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Permissão</label>
                                    <select class="form-control" <?php echo $_SESSION['permissao'] > 4 ? '' : 'disabled=\"\"'; ?>>
                                        <option>Nível 1 - Usuário</option>
                                        <option>Nível 2 - Técnico</option>
                                        <option>Nível 3 - Coordenador</option>
                                        <option>Nível 4 - Diretor</option>
                                        <option>Nível 5 - Administrador</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Situação</label>
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" id="meusDados" checked="checked" name="meusDados" value="1" <?php echo $_SESSION['permissao'] > 2 ? '' : 'disabled=\"\"'; ?>>
                                        <label class="custom-control-label" for="meusDados">Conta Ativa</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Alterar</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
