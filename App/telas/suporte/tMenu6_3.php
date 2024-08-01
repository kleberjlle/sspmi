<?php
if(isset($_GET['criptografia'])){
    $criptografia = $_GET['criptografia'];
}else{
    $criptografia = '';
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        Gerar Senha
                    </h3>
                </div>
                <!-- /.card-header -->
                <form action="../../sistema/suporte/sGerarSenha.php" method="post" enctype="multipart/form-data">
                    <div class="card-body dark-mode">
                        <div class="row">
                            <div class="form-group col-md-8">
                                <input type="text" class="form-control" id="senha" name="senha" required="">
                                <input type="text" class="form-control" id="criptografia" name="criptografia" value="<?php echo $criptografia ?>">
                            </div>
                        </div>
                        
                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary float-left">Gerar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>