<?php
use App\sistema\acesso\{sSecretaria};

$sSecretaria = new sSecretaria($_SESSION['credencial']['secretaria_idsecretaria']);
$sSecretaria->consultar('tMenu1_1.php');
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="../../../vendor/almasaeed2010/adminlte/dist/img/user2-160x160.jpg"
                             alt="Imagem do Perfil">
                    </div>

                    <h3 class="profile-username text-center"><?php echo $_SESSION['credencial']['nome'].' '.$_SESSION['credencial']['sobrenome']; ?></h3>
                    <ul class="list-group list-group-unbordered mb-4">
                        <li class="list-group-item">
                            <i class="fas fa-venus-mars mr-1"></i><b> Sexo</b><a class="float-right"><?php echo $_SESSION['credencial']['sexo'] == 'M' ? 'Masculino' : 'Feminino'; ?></a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-building mr-1"></i><b> Secretaria</b><a class="float-right"><?php echo $sSecretaria->getNomenclatura(); ?></a>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-house-user mr-1"></i><b> Departamento/ Unidade</b> <a class="float-right"><?php echo $_SESSION['credencial']['departamento_iddepartamento']; ?></a>
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
        <!-- /.col -->
    </div>
    <!-- /.row -->            
</div>
<!-- /.container-fluid -->