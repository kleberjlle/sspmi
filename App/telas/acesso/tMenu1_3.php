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
$sUsuario->consultar('tMenu1_3.php');
?>
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Etapa 1 - Solicitações de Acesso</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tabelaMenu1_3" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Cargo</th>
                    <th>Locais</th>
                    <th>Telefones</th>
                    <th>E-mails</th>
                    <th>Situação</th>
                    <th>Verificar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($sUsuario->mConexao->getValidador()) {
                    foreach ($sUsuario->mConexao->getRetorno() as $key => $value) {
                        //consultar os dados do usuário e armazenar em variáveis locais   
                        $seguranca = base64_encode($value['idsolicitacao']);
                        $nome = $value['nome'] . ' ' . $value['sobrenome'];
                        $idSecretaria = $value['secretaria_idsecretaria'];
                        $emailUsuario = $value['email'];
                        $idDepartamento = $value['departamento_iddepartamento'];
                        $idCoordenacao = $value['coordenacao_idcoordenacao'];
                        $idSetor = $value['setor_idsetor'];
                        $sSecretaria = new sSecretaria($value['secretaria_idsecretaria']);
                        $sSecretaria->consultar('tMenu1_3.php');
                        $secretaria = $sSecretaria->getNomenclatura();
                        $sCargo = new sCargo($value['cargo_idcargo']);
                        $sCargo->consultar('tMenu1_3.php');
                        $cargo = $sCargo->getNomenclatura();
                        $dataHoraSolicitacao = $value['dataHoraSolicitacao'];
                        $dataHoraSolicitacaoTratada = $sUsuario->tratarData($dataHoraSolicitacao);
                        
                        if(!empty($value['dataHoraExaminador'])){
                            $dataHoraExaminador = $value['dataHoraExaminador'];
                            
                            $sExaminador = new sUsuario();
                            $dataHoraExaminador = $sExaminador->tratarData($dataHoraExaminador);
                        }
                        
                        //obtem os dados do usuário que solicitou acesso
                        if(!empty($value['examinador'])){
                            $idExaminador = $value['examinador'];
                            
                            $sExaminador = new sUsuario();
                            $sExaminador->setIdUsuario($idExaminador);
                            $sExaminador->consultar('tMenu1_3-examinador.php');
                            $nomeExaminador = $sExaminador->getNome().' '.$sExaminador->getSobrenome();                            
                        }                        
                        
                        //verifica se o registro já foi aprovado e por quem
                        if($value['examinador']){
                            if($value['situacao']){
                                $situacao = '<span class="bg-green"> aprovada</span><br /><i>por '.$nomeExaminador.'<br />em '.$dataHoraExaminador.'</i>';
                            }else{
                                $situacao = '<span class="bg-red">reprovada</span><br /><i>por '.$nomeExaminador.'<br />em '.$dataHoraExaminador.'</i>';
                            }
                        }else{
                            $situacao = '<span class="bg-info">aguardando análise</span><br /><i>desde '.$dataHoraSolicitacaoTratada.'</i>';
                        }

                        //se tiver um departamento vinculado, retorna os dados
                        if ($value['departamento_iddepartamento']) {
                            $sDepartamento = new sDepartamento($value['departamento_iddepartamento']);
                            $sDepartamento->consultar('tMenu1_3.php');
                            $departamento = $sDepartamento->getNomenclatura();
                        } else {
                            $departamento = '--';
                        }
                        
                        //se tiver uma coordenação vinculado, retorna os dados
                        if ($value['coordenacao_idcoordenacao']) {
                            $sCoordenacao = new sCoordenacao($value['coordenacao_idcoordenacao']);
                            $sCoordenacao->consultar('tMenu1_3.php');
                            $coordenacao = $sCoordenacao->getNomenclatura();
                        } else {
                            $coordenacao = '--';
                        }
                        
                        //se tiver um setor vinculado, retorna os dados
                        if ($value['setor_idsetor']) {
                            $sSetor = new sSetor($value['setor_idsetor']);
                            $sSetor->consultar('tMenu1_3.php');
                            $setor = $sSetor->getNomenclatura();
                        } else {
                            $setor = '--';
                        }
                        
                        //se tiver telefone na secretaria, retorna os dados
                        $sTelefoneSecretaria = new sTelefone(0, $value['secretaria_idsecretaria'], 'secretaria');
                        $sTelefoneSecretaria->consultar('tMenu1_3.php');
                        if ($sTelefoneSecretaria->getValidador()) {
                            $telefoneSecretaria = $sTelefoneSecretaria->tratarTelefone($sTelefoneSecretaria->getNumero());
                            $sTelefoneSecretaria->getWhatsApp() ? $whatsAppSecretaria = '<i class="fab fa-whatsapp mr-1"></i>' : $whatsAppSecretaria = '';
                        } else {
                            $telefoneSecretaria = '--';
                        }
                        
                        //se tiver telefone no departamento, e o usuário pertencer há um departamento retorna os dados
                        $sTelefoneDepartamento = new sTelefone(0, $value['departamento_iddepartamento'], 'departamento');
                        $sTelefoneDepartamento->consultar('tMenu1_3.php');
                        if ($sTelefoneDepartamento->getValidador() && $value['departamento_iddepartamento']) {
                            $telefoneDepartamento = $sTelefoneDepartamento->tratarTelefone($sTelefoneDepartamento->getNumero());
                            $sTelefoneDepartamento->getWhatsApp() ? $whatsAppDepartamento = '<i class="fab fa-whatsapp mr-1"></i>' : $whatsAppDepartamento = '';
                        } else {
                            $telefoneDepartamento = '--';
                            $whatsAppDepartamento = '';
                        }
                        
                        //se tiver telefone na coordenação, e o usuário pertencer há uma coordenação retorna os dados
                        $sTelefoneCoordenacao = new sTelefone(0, $value['coordenacao_idcoordenacao'], 'coordenacao');
                        $sTelefoneCoordenacao->consultar('tMenu1_3.php');
                        if ($sTelefoneCoordenacao->getValidador() && $value['coordenacao_idcoordenacao']) {
                            $telefoneCoordenacao = $sTelefoneCoordenacao->tratarTelefone($sTelefoneCoordenacao->getNumero());
                            $sTelefoneCoordenacao->getWhatsApp() ? $whatsAppCoordenacao = '<i class="fab fa-whatsapp mr-1"></i>' : $whatsAppCoordenacao = '';
                        } else {
                            $telefoneCoordenacao = '--';
                            $whatsAppCoordenacao = '';
                        }
                        
                        //se tiver telefone na setor, e o usuário pertencer há um setor retorna os dados
                        $sTelefoneSetor = new sTelefone(0, $value['setor_idsetor'], 'setor');
                        $sTelefoneSetor->consultar('tMenu1_3.php');
                        if ($sTelefoneSetor->getValidador() && $value['setor_idsetor']) {
                            $telefoneSetor = $sTelefoneSetor->tratarTelefone($sTelefoneSetor->getNumero());
                            $sTelefoneSetor->getWhatsApp() ? $whatsAppSetor = '<i class="fab fa-whatsapp mr-1"></i>' : $whatsAppSetor = '';
                        } else {
                            $telefoneSetor = '--';
                            $whatsAppSetor = '';
                        }

                        $telefoneUsuario = $value['telefone'];
                        $sTelefoneUsuario = new sTelefone(0, 0, '0');
                        $telefoneUsuarioTratado = $sTelefoneUsuario->tratarTelefone($telefoneUsuario);
                        if (strlen($telefoneUsuarioTratado) > 0) {
                            $value['whatsApp'] == '1' ? $whatsAppUsuario = '<i class="fab fa-whatsapp mr-1"></i>' : $whatsAppUsuario = '';
                        } else {
                            $telefoneUsuarioTratado = '--';
                            $whatsAppUsuario = '';
                        }

                        if ($value['secretaria_idsecretaria'] != 0) {
                            $sEmailSecretaria = new sEmail('', 'secretaria');
                            $sEmailSecretaria->setIdEmail($idSecretaria);
                            $sEmailSecretaria->consultar('tMenu1_3.php');
                            $emailSecretaria = $sEmailSecretaria->getNomenclatura();
                        }else{
                            $emailSecretaria = '--';
                        }

                        if ($value['departamento_iddepartamento'] != 0) {
                            $sEmailDepartamento = new sEmail('', 'departamento');
                            $sEmailDepartamento->setIdEmail($idDepartamento);
                            $sEmailDepartamento->consultar('tMenu1_3.php');
                            $emailDepartamento = $sEmailDepartamento->getNomenclatura();
                        }else{
                            $emailDepartamento = '--';
                        }

                        if ($value['coordenacao_idcoordenacao']) {
                            $sEmailCoordenacao = new sEmail('', 'coordenacao');
                            $sEmailCoordenacao->setIdEmail($idCoordenacao);
                            $sEmailCoordenacao->consultar('tMenu1_3.php');
                            $emailCoordenacao = $sEmailCoordenacao->getNomenclatura();
                        }else{
                            $emailCoordenacao = '--';
                        }

                        if ($value['setor_idsetor']) {
                            $sEmailSetor = new sEmail('', 'setor');
                            $sEmailSetor->setIdEmail($idSetor);
                            $sEmailSetor->consultar('tMenu1_3.php');
                            $emailSetor = $sEmailSetor->getNomenclatura();
                        }else{
                            $emailSetor = '--';
                        }
                        
                        //instancia as configurações do sistema
                        $sConfiguracao = new sConfiguracao();
                        $diretorio = $sConfiguracao->getDiretorioVisualizacaoAcesso();
                        
                        $pagina = 'tMenu1_3.php';
                        
                        echo <<<HTML
                        <tr>
                            <td>{$nome}</td>
                            <td>{$cargo}</td>
                            <td>
                                {$secretaria}<br / >
                                {$departamento}<br />
                                {$coordenacao}<br />
                                {$setor}</td>
                            <td>
                                <i class="fas fa-building mr-1"></i> {$whatsAppSecretaria} {$telefoneSecretaria}<br />
                                <i class="fas fa-building mr-1"></i> {$whatsAppDepartamento} {$telefoneDepartamento}<br />
                                <i class="fas fa-building mr-1"></i> {$whatsAppCoordenacao} {$telefoneCoordenacao}<br />
                                <i class="fas fa-building mr-1"></i> {$whatsAppSetor} {$telefoneSetor}<br />
                                <i class="fas fa-user-alt mr-1"></i> {$whatsAppUsuario} {$telefoneUsuarioTratado}
                            </td>
                            <td>
                                {$emailSecretaria}<br />
                                {$emailDepartamento}<br />
                                {$emailCoordenacao}<br />
                                {$emailSetor}<br />
                                {$emailUsuario}<br />
                            </td>
                            <td>
                                {$situacao}
                            </td>
                            <td>
                                <i class="fas fa-door-open"></i>
                                <a href="{$diretorio}tPainel.php?menu=1_3_1&seguranca={$seguranca}"> Verificar</a>
                            </td>
                        </tr>
HTML;
                    }
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
                    <th>Verificar</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<script>
    $(function () {
        $("#tabelaMenu1_3").DataTable({
            language:{
                url: "https://itapoa.app.br/vendor/dataTable_pt_br/dataTable_pt_br.json"
            },
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tabelaMenu1_3_wrapper .col-md-6:eq(0)');        
    });
</script>