<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        Aterar Menu
                    </h3>
                </div>
                <!-- /.card-header -->
                <form action="../../sistema/acesso/sAlterarMenu.php" method="post" enctype="multipart/form-data">
                    <div class="card-body dark-mode">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" id="menu1" name="menu1" value="Perfil" required="">
                                <input type="text" class="form-control" id="menu1_1" name="menu1_1" value="Meus dados" required="">
                                <input type="text" class="form-control" id="menu1_2" name="menu1_2" value="Outros Usuários" required="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" id="menu2" name="menu2" value="Suporte" required="">
                                <input type="text" class="form-control" id="menu2_1" name="menu2_1" value="Solicitar" required="">
                                <input type="text" class="form-control" id="menu2_2" name="menu2_2" value="Acompanhar" required="">                
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" id="menu3" name="menu3" value="Equipamento" required="">
                                <input type="text" class="form-control" id="menu3_1" name="menu3_1" value="Registrar" required="">
                                <input type="text" class="form-control" id="menu3_2" name="menu3_2" value="Alterar" required="">           
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" id="menu4" name="menu4" value="Local" required="">
                                <input type="text" class="form-control" id="menu4_1" name="menu4_1" value="Registrar" required="">
                                <input type="text" class="form-control" id="menu4_2" name="menu4_2" value="Alterar" required="">           
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" id="menu5" name="menu5" value="Cargo" required="">
                                <input type="text" class="form-control" id="menu5_1" name="menu5_1" value="Registrar" required="">
                                <input type="text" class="form-control" id="menu5_2" name="menu5_2" value="Alterar" required="">           
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" id="menu6" name="menu6" value="Configuração" required="">
                                <input type="text" class="form-control" id="menu6_1" name="menu6_1" value="Menu" required="">         
                            </div>
                        </div>
                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary float-left">Alterar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>