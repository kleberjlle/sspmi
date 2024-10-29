<?php
use App\sistema\acesso\{
    sConfiguracao,
    sSecretaria,
    sTelefone,
    sTratamentoDados,
    sEmail,
    sSair
};

use App\sistema\suporte\{
    sAmbiente
};

if(!isset($_POST['pagina']) || !isset($_POST['formulario'])){
    //solicitar saída com tentativa de violação
    $sSair = new sSair();
    $sSair->verificar('0');
}else{
    if($_POST['formulario'] == 'f1'){
        $pagina = $_POST['pagina'];
        $idSecretaria = $_POST['secretaria'];
        $opcao = 'Secretaria';

        //busca dados da secretaria no bd
        $sSecretaria = new sSecretaria($idSecretaria);
        $sSecretaria->consultar('tMenu4_2_1_1.php');

        foreach ($sSecretaria->mConexao->getRetorno() as $value) {
            $secretaria = $value['nomenclatura'];
            $endereco = $value['endereco'];
            $idAmbiente = $value['ambiente_idambiente'];
        }
        
        //busca dados do ambiente no bd
        $sAmbiente = new sAmbiente();
        $sAmbiente->consultar('tMenu4_2_1_1.php');
        
        //busca dados do telefone
        $sTelefone = new sTelefone(0, $idSecretaria, '');
        $sTelefone->setNomeCampo('secretaria_idsecretaria');
        $sTelefone->setValorCampo($idSecretaria);
        $sTelefone->consultar('tMenu4_2_1_1.php');
        
        //se tiver alguma Secretaria registrada na tabela telefone_has_secretaria
        if($sTelefone->getValidador()){
            foreach ($sTelefone->mConexao->getRetorno() as $value) {
                $idTelefone = $value['telefone_idtelefone'];
            }
            
            //consulta o idTelefone na tabela telefone
            $sTelefone = new sTelefone($idTelefone, 0, 0);
            $sTelefone->setNomeCampo('idtelefone');
            $sTelefone->setValorCampo($idTelefone);
            $sTelefone->consultar('tMenu4_2_1_1.php-2');
            
            //se localizou um telefone registrado colete as informações
            if($sTelefone->getValidador()){            
                foreach ($sTelefone->mConexao->getRetorno() as $value) {
                    $numero = $value['numero'];
                    $whatsApp = $value['whatsApp'];
                }
                
                //trata o numero de telefone para inserção dos caracteres especiais
                $sTratamentoTelefone = new sTratamentoDados($numero);
                $telefoneTratado = $sTratamentoTelefone->tratarTelefone();
            }            
        }
                
        //busca dados do e-mail no bd
        $sEmail = new sEmail('', '');
        $sEmail->setNomeCampo('secretaria_idsecretaria');
        $sEmail->setValorCampo($idSecretaria);
        $sEmail->consultar('tMenu4_2_1_1.php');
        
        //se tiver algum e-mail registrado na tabela email_has_secretaria
        if($sEmail->getValidador()){
            foreach ($sEmail->mConexao->getRetorno() as $value) {
                $idEmail = $value['email_idemail'];
            }
            
            //consulta se possui e-mail registrado na tabela email
            $sEmail->setNomeCampo('idemail');
            $sEmail->setValorCampo($idEmail);
            $sEmail->consultar('tMenu4_2_1_1.php-2');

            //armazena os dados da consulta
            foreach ($sEmail->mConexao->getRetorno() as $value) {
                $email = $value['nomenclatura'];
            }            
        }
    }
}
?>        
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <!--registro secretaria-->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?php echo $opcao; ?></h3>
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
                        <div class="form-group col-md-2">
                            <label for="secretaria">Secretaria</label>
                            <input type="text" class="form-control" name="secretaria" value="<?php echo $secretaria; ?>" form="f1" required="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="endereco">Endereço</label>
                            <input type="text" class="form-control" name="endereco" value="<?php echo $endereco; ?>" form="f1" required="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="endereco">E-mail</label>
                            <input type="email" class="form-control" name="email" value="<?php echo isset($email) ? $email : ''; ?>" form="f1" required="">
                        </div>
                        <div class="form-group">
                            <label>Ambiente</label>
                            <select class="form-control" name="idAmbiente" id="idAmbiente" form="f1">
                                <?php
                                foreach ($sAmbiente->mConexao->getRetorno() as $value) {    
                                    $idAmbiente == $value['idambiente'] ? $atributo = 'selected=""' : $atributo = '';
                                    echo '<option value="' . $value['idambiente'] . '"' . $atributo . ' >' . $value['nomenclatura'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" name="telefone" value="<?php echo isset($telefoneTratado) ? $telefoneTratado : ''; ?>" form="f1" required="">
                        </div>
                        <div class="form-group">
                            <label>WhatsApp?</label>
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input class="custom-control-input" type="checkbox" name="whatsApp" id="whatsApp" <?php echo isset($whatsApp) ? 'checked=""' : ''; ?> onclick="decisao();" form="f1">
                                <label class="custom-control-label" for="whatsApp">
                                    <div class="conteudo" name="conteudo" id="conteudo"><?php echo isset($whatsApp) ? 'sim' : 'Não'; ?></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <form action="<?php echo $sConfiguracao->getDiretorioVisualizacaoAcesso() ?>sAlterarLocal.php" method="post" id="alterarLocal" enctype="multipart/form-data">
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" name="pagina" value="menu4_2_1">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
<script>
    function decisao(){
       if (document.getElementById('whatsApp').checked) {
            document.getElementById('conteudo').innerHTML = 'Sim';
        } else {
            document.getElementById('conteudo').innerHTML = 'Não';
        }
    }
</script>