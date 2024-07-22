<?php

namespace App\sistema\suporte;

use App\modelo\{
    mConexao
};
use App\sistema\acesso\{
    sNotificacao
};

class sProtocolo {

    private string $nomeCampo;
    private string $valorCampo;
    private string $validador;
    public mConexao $mConexao;
    public sNotificacao $sNotificacao;

     public function inserir($pagina, $dadosTratados) {
        //cria conexão para inserir os dados no BD
        $this->setMConexao(new mConexao());

        if ($pagina == 'tMenu2_1.php') {
            $dados = [
                'comando' => 'INSERT INTO',
                'tabela' => 'protocolo',
                'camposInsercao' => [
                    'nomeDoRequerente',
                    'sobrenomeDoRequerente',
                    'telefoneDoRequerente',
                    'whatsAppDoRequerente',
                    'emailDoRequerente',
                    'usuario_idusuario'
                ],
                'valoresInsercao' => [
                    $dadosTratados['nomeDoRequerente'],
                    $dadosTratados['sobrenomeDoRequerente'],
                    $dadosTratados['telefoneDoRequerente'],
                    $dadosTratados['whatsAppDoRequerente'],
                    $dadosTratados['emailDoRequerente'],
                    $dadosTratados['usuario_idusuario']
                ]
            ]; 
            
            $this->mConexao->CRUD($dados);
            //INSERT INTO table_name (column1, column2, column3, ...) VALUES (value1, value2, value3, ...);
            if ($this->mConexao->getValidador()) {
                $this->setValidador(true);
                $this->setSNotificacao(new sNotificacao('S4'));
            }
        }
    }
    
    public function getNomeCampo(): string {
        return $this->nomeCampo;
    }

    public function getValorCampo(): string {
        return $this->valorCampo;
    }
    
    public function getValidador(): string {
        return $this->validador;
    }

    public function getMConexao(): mConexao {
        return $this->mConexao;
    }

    public function getSNotificacao(): sNotificacao {
        return $this->sNotificacao;
    }

    public function setNomeCampo(string $nomeCampo): void {
        $this->nomeCampo = $nomeCampo;
    }

    public function setValorCampo(string $valorCampo): void {
        $this->valorCampo = $valorCampo;
    }

    public function setValidador(string $validador): void {
        $this->validador = $validador;
    }

    public function setMConexao(mConexao $mConexao): void {
        $this->mConexao = $mConexao;
    }

    public function setSNotificacao(sNotificacao $sNotificacao): void {
        $this->sNotificacao = $sNotificacao;
    }
}
