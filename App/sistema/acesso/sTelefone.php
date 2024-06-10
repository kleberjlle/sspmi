<?php

namespace App\sistema\acesso;

use App\modelo\{
    mConexao
};
use App\sistema\acesso\{
    sNotificacao
}; 

class sTelefone {
    private bool $validador;
    private int $idTelefone;
    private int $idLocal;
    private string $numero;
    private bool $whatsApp;
    private string $nomenclaturaLocal;
    public mConexao $mConexao;
    public sNotificacao $sNotificacao;

    public function __construct(int $idTelefone, int $idLocal, string $nomenclaturaLocal) {
        $this->idTelefone = $idTelefone;
        $this->idLocal = $idLocal;
        $this->nomenclaturaLocal = $nomenclaturaLocal;
        $this->validador = false;
    }

    public function consultar($pagina) {
        $this->setMConexao(new mConexao());
        if ($pagina == 'tAcessar.php') {
            if ($this->getNomenclaturaLocal() == 'usuario') {             
                $dados = [
                    'comando' => 'SELECT',
                    'busca' => '*',
                    'tabelas' => 'telefone',
                    'camposCondicionados' => 'idtelefone',
                    'valoresCondicionados' => $this->getIdTelefone(),
                    'camposOrdenados' => null, //caso não tenha, colocar como null
                    'ordem' => 'ASC'
                ];
            } else if ($this->getNomenclaturaLocal() == 'setor' ||
                        $this->getNomenclaturaLocal() == 'coordenacao' ||
                        $this->getNomenclaturaLocal() == 'departamento' ||
                        $this->getNomenclaturaLocal() == 'secretaria') {
                $dados = [
                    'comando' => 'SELECT',
                    'busca' => ['telefone.numero', 'telefone.whatsApp'],
                    'tabelas' => ['telefone', 'telefone_has_'.$this->getNomenclaturaLocal()],
                    'camposCondicionados' => '',
                    'valoresCondicionados' => ['telefone.idtelefone', 'telefone_has_'.$this->getNomenclaturaLocal().'.telefone_idtelefone'],
                    'camposOrdenados' => null, //caso não tenha, colocar como null
                    'ordem' => 'ASC'
                ];
            }
            $this->mConexao->CRUD($dados);

            foreach ($this->mConexao->getRetorno() as $linha) {                
                $this->setNumero($linha['numero']);
                $this->setWhatsApp($linha['whatsApp']);     
            }
            
        }
    }
    
    public function tratarTelefone($telefone) {
        if(!ctype_alnum($telefone)){
            $telefoneTratado = str_replace(['(', ')', '-','_', ' '], '', $telefone);
        }
        return $telefoneTratado;
    }

    public function verificarTelefone($telefone) {
        if(strlen($telefone) < 10 ||
            strlen($telefone) > 11){
            $this->setSNotificacao(new sNotificacao('A11'));
            $this->setValidador(false);
        }else{
            $this->setValidador(true);
        }
    }
    
    public function getValidador(): bool {
        return $this->validador;
    }

    public function getIdTelefone(): int {
        return $this->idTelefone;
    }

    public function getIdLocal(): int {
        return $this->idLocal;
    }

    public function getNumero(): string {
        return $this->numero;
    }

    public function getWhatsApp(): bool {
        return $this->whatsApp;
    }

    public function getNomenclaturaLocal(): string {
        return $this->nomenclaturaLocal;
    }

    public function getMConexao(): mConexao {
        return $this->mConexao;
    }

    public function getSNotificacao(): sNotificacao {
        return $this->sNotificacao;
    }

    public function setValidador(bool $validador): void {
        $this->validador = $validador;
    }

    public function setIdTelefone(int $idTelefone): void {
        $this->idTelefone = $idTelefone;
    }

    public function setIdLocal(int $idLocal): void {
        $this->idLocal = $idLocal;
    }

    public function setNumero(string $numero): void {
        $this->numero = $numero;
    }

    public function setWhatsApp(bool $whatsApp): void {
        $this->whatsApp = $whatsApp;
    }

    public function setNomenclaturaLocal(string $nomenclaturaLocal): void {
        $this->nomenclaturaLocal = $nomenclaturaLocal;
    }

    public function setMConexao(mConexao $mConexao): void {
        $this->mConexao = $mConexao;
    }

    public function setSNotificacao(sNotificacao $sNotificacao): void {
        $this->sNotificacao = $sNotificacao;
    }



}
