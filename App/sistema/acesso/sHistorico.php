<?php
namespace App\sistema\acesso;
use App\modelo\{
    mConexao
};
use App\sistema\acesso\{
    sNotificacao
};

class sHistorico{
    public mConexao $mConexao;
    public sNotificacao $sNotificacao;
    
    public function inserir($pagina, $tratarDados) {
        //cria conexão para inserir os dados na tabela
        $this->setMConexao(new mConexao());
        if( $pagina == 'tMenu1_1_1.php' ||
            $pagina == 'tSolicitarAcesso.php' ||
            $pagina == 'tAcessar.php' ||
            $pagina == 'tMenu5_1.php' ||
            $pagina == 'tMenu5_2_1.php'){
            //insere os dados do histórico no BD            
            $dados = [
                'comando' => 'INSERT INTO',
                'tabela' => 'historico',
                'camposInsercao' => [
                    'pagina',
                    'acao',
                    'campo',
                    'valorAtual',
                    'valorAnterior',
                    'ip',
                    'navegador',
                    'sistemaOperacional',
                    'nomeDoDispositivo',
                    'idusuario'
                ],                    
                'valoresInsercao' => [
                    $tratarDados['pagina'],
                    $tratarDados['acao'],
                    $tratarDados['campo'],
                    $tratarDados['valorCampoAtual'],
                    $tratarDados['valorCampoAnterior'],
                    $tratarDados['ip'],
                    $tratarDados['navegador'],
                    $tratarDados['sistemaOperacional'],
                    $tratarDados['nomeDoDispositivo'],
                    $tratarDados['idUsuario']
                ]
            ];
            $this->mConexao->CRUD($dados);
        }
    }
    public function getMConexao(): mConexao {
        return $this->mConexao;
    }

    public function getSNotificacao(): sNotificacao {
        return $this->sNotificacao;
    }

    public function setMConexao(mConexao $mConexao): void {
        $this->mConexao = $mConexao;
    }

    public function setSNotificacao(sNotificacao $sNotificacao): void {
        $this->sNotificacao = $sNotificacao;
    }


    

}

?>
        