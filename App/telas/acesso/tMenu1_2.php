<?php

use App\sistema\acesso\{
    sConfiguracao,
    sUsuario,
    sCargo,
    sSecretaria,
    sDepartamento,
    sCoordenacao,
    sSetor,
    sTelefone,
    sEmail,
};

$sConfiguracao = new sConfiguracao();
$sUsuario = new sUsuario();
$sUsuario->consultar('tMenu1_2.php');
?>
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Etapa 1 - Outros Usuários</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tabelaMenu1_2" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Cargo</th>
                    <th>Locais</th>
                    <th>Telefones</th>
                    <th>E-mails</th>
                    <th>Situação</th>
                    <th>Solicitação</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($sUsuario->mConexao->getRetorno() as $key => $value) {
                    //consultar os dados do usuário e armazenar em variáveis locais                    
                    $nome = $value['nome'].' '.$value['sobrenome'];
                    $sSecretaria = new sSecretaria($value['secretaria_idsecretaria']);
                    $sSecretaria->consultar('tMenu1_2.php');
                    $secretaria = $sSecretaria->getNomenclatura();       
                    $sCargo = new sCargo($value['cargo_idcargo']);
                    $sCargo->consultar('tMenu1_2.php');
                    $cargo = $sCargo->getNomenclatura();
                    
                    //se tiver um departamento vinculado, retorna os dados
                    if($value['departamento_iddepartamento']){
                        $sDepartamento = new sDepartamento($value['departamento_iddepartamento']);
                        $sDepartamento->consultar('tMenu1_2.php');
                        $departamento = $sDepartamento->getNomenclatura();
                    }else{
                        $departamento = '--';
                    }
                    //se tiver uma coordenação vinculado, retorna os dados
                    if($value['coordenacao_idcoordenacao']){
                        $sCoordenacao = new sCoordenacao($value['coordenacao_idcoordenacao']);
                        $sCoordenacao->consultar('tMenu1_2.php');
                        $coordenacao = $sCoordenacao->getNomenclatura();
                    }else{
                        $coordenacao = '--';
                    }
                    //se tiver um setor vinculado, retorna os dados
                    if($value['setor_idsetor']){
                        $sSetor = new sSetor($value['setor_idsetor']);
                        $sSetor->consultar('tMenu1_2.php');
                        $setor = $sSetor->getNomenclatura();
                    }else{
                        $setor = '--';
                    }
                    //se tiver telefone na secretaria, retorna os dados
                    $sTelefoneSecretaria = new sTelefone(0, $value['secretaria_idsecretaria'], 'secretaria'); 
                    $sTelefoneSecretaria->consultar('tMenu1_2.php');
                    if($sTelefoneSecretaria->getValidador()){                        
                        $telefoneSecretaria = $sTelefoneSecretaria->tratarTelefone($sTelefoneSecretaria->getNumero());
                        $sTelefoneSecretaria->getWhatsApp() ? $whatsAppSecretaria = '<i class="fab fa-whatsapp mr-1"></i>' : $whatsAppSecretaria = '';
                    }else{
                        $telefoneSecretaria = '--';
                    }
                    //se tiver telefone no departamento, e o usuário pertencer há um departamento retorna os dados
                    $sTelefoneDepartamento = new sTelefone(0, $value['secretaria_idsecretaria'], 'departamento'); 
                    $sTelefoneDepartamento->consultar('tMenu1_2.php');
                    if($sTelefoneDepartamento->getValidador() && $value['departamento_iddepartamento']){                        
                        $telefoneDepartamento = $sTelefoneDepartamento->tratarTelefone($sTelefoneDepartamento->getNumero());
                        $sTelefoneDepartamento->getWhatsApp() ? $whatsAppDepartamento = '<i class="fab fa-whatsapp mr-1"></i>' : $whatsAppDepartamento = '';
                    }else{
                        $telefoneDepartamento = '--';
                    }
                    //se tiver telefone na coordenação, e o usuário pertencer há uma coordenação retorna os dados
                    $sTelefoneCoordenacao = new sTelefone(0, $value['secretaria_idsecretaria'], 'coordenacao'); 
                    $sTelefoneCoordenacao->consultar('tMenu1_2.php');
                    if($sTelefoneCoordenacao->getValidador() && $value['coordenacao_idcoordenacao']){                        
                        $telefoneCoordenacao = $sTelefoneCoordenacao->tratarTelefone($sTelefoneCoordenacao->getNumero());
                        $sTelefoneCoordenacao->getWhatsApp() ? $whatsAppCoordenacao = '<i class="fab fa-whatsapp mr-1"></i>' : $whatsAppCoordenacao = '';
                    }else{
                        $telefoneCoordenacao = '--';
                    }
                    //se tiver telefone na setor, e o usuário pertencer há um setor retorna os dados
                    $sTelefoneSetor = new sTelefone(0, $value['secretaria_idsecretaria'], 'setor'); 
                    $sTelefoneSetor->consultar('tMenu1_2.php');
                    if($sTelefoneSetor->getValidador() && $value['setor_idsetor']){                        
                        $telefoneSetor = $sTelefoneSetor->tratarTelefone($sTelefoneSetor->getNumero());
                        $sTelefoneSetor->getWhatsApp() ? $whatsAppSetor = '<i class="fab fa-whatsapp mr-1"></i>' : $whatsAppSetor = '';
                    }else{
                        $telefoneSetor = '--';
                    }
                    //se o usuário tiver telefone registrado retorna os dados
                    $sTelefoneUsuario = new sTelefone($value['telefone_idtelefone'], '0', 'usuario'); 
                    $sTelefoneUsuario->consultar('tMenu1_2.php');
                    if($sTelefoneUsuario->getValidador()){                        
                        $telefoneUsuario = $sTelefoneUsuario->tratarTelefone($sTelefoneUsuario->getNumero());
                        $sTelefoneUsuario->getWhatsApp() ? $whatsAppUsuario = '<i class="fab fa-whatsapp mr-1"></i>' : $whatsAppUsuario = '';
                    }else{
                        $telefoneUsuario = '--';
                    }
                    //se tiver email na secretaria, retorna os dados
                    $sEmailSecretaria = new sEmail($value['email_idemail'], 'secretaria'); 
                    $sEmailSecretaria->consultar('tMenu1_2.php');
                    if($sEmailSecretaria->getValidador()){                        
                        $emailSecretaria = $sEmailSecretaria->getNomenclatura();
                    }else{
                        $emailSecretaria = '--';
                    }
                    //se tiver email no departamento, retorna os dados
                    $sEmailDepartamento = new sEmail($value['email_idemail'], 'departamento'); 
                    $sEmailDepartamento->consultar('tMenu1_2.php');
                    if($sEmailDepartamento->getValidador() && $value['departamento_iddepartamento']){                        
                        $emailDepartamento = $sEmailDepartamento->getNomenclatura();
                    }else{
                        $emailDepartamento = '--';
                    }
                    //se tiver email na coordenaçao, retorna os dados
                    $sEmailCoordenacao = new sEmail($value['email_idemail'], 'coordenacao'); 
                    $sEmailCoordenacao->consultar('tMenu1_2.php');
                    if($sEmailCoordenacao->getValidador() && $value['coordenacao_idcoordenacao']){                        
                        $emailCoordenacao = $sEmailCoordenacao->getNomenclatura();
                    }else{
                        $emailCoordenacao = '--';
                    }
                    //se tiver email na coordenaçao, retorna os dados
                    $sEmailSetor = new sEmail($value['email_idemail'], 'setor'); 
                    $sEmailSetor->consultar('tMenu1_2.php');
                    if($sEmailSetor->getValidador() && $value['setor_idsetor']){                        
                        $emailSetor = $sEmailSetor->getNomenclatura();
                    }else{
                        $emailSetor = '--';
                    }
                    //se o usuário tiver email registrado retorna os dados
                    $sEmailUsuario = new sEmail($value['email_idemail'], 'email'); 
                    $sEmailUsuario->consultar('tMenu1_2.php');
                    if($sEmailUsuario->getValidador()){                        
                        $emailUsuario = $sEmailUsuario->getNomenclatura();
                    }else{
                        $emailUsuario = '--';
                    }
                    
                    if($value['situacao'] == true){
                        $situacao = '<span class="bg-green">ativa</span>';
                    }else{
                        $situacao = '<span class="bg-red">inativa</span>';
                    }
                    
                    
                    echo "<tr>";
                        echo "<td>{$nome}</td>";
                        echo "<td>{$cargo}</td>";
                        echo "<td>{$secretaria}<br / >{$departamento}<br />{$coordenacao}<br />{$setor}</td>";
                        echo "<td><i class=\"fas fa-building mr-1\"></i> {$whatsAppSecretaria} {$telefoneSecretaria}<br /><i class=\"fas fa-building mr-1\"></i> {$whatsAppDepartamento} {$telefoneDepartamento}<br /><i class=\"fas fa-building mr-1\"></i> {$whatsAppCoordenacao} {$telefoneCoordenacao}<br /><i class=\"fas fa-building mr-1\"></i> {$whatsAppSetor} {$telefoneSetor}<br /><i class=\"fas fa-user-alt mr-1\"></i> {$whatsAppUsuario} {$telefoneUsuario}</td>";
                        echo "<td>{$emailSecretaria}<br />{$emailDepartamento}<br />{$emailCoordenacao}<br />{$emailSetor}<br />{$emailUsuario}<br /></td>";
                        echo "<td>{$situacao}</td>";
                        echo "<td><span class=\"bg-green\">aprovada</span> <i>por Kleber Pereira de Almeida</i></td>";
                        echo "<td><a href=\"tPainel.php?menu=1_1_1&id=2\"><i class=\"fas fa-edit mr-1\"></i></a></td>";
                    echo "</tr>";
                }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Usuário</th>
                    <th>Cargo</th>
                    <th>Locais</th>
                    <th>Telefones</th>
                    <th>E-mails</th>
                    <th>Situação</th>
                    <th>Solicitação</th>
                    <th>Editar</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>