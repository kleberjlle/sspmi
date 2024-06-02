<?php

namespace App\sistema\acesso;

use App\modelo\{
    mConexao
};

class sTelefone {

    private int $idTelefone;
    private int $idLocal;
    private string $numero;
    private bool $whatsApp;
    private string $nomenclaturaLocal;
    public mConexao $mConexao;

    public function __construct(int $idTelefone, int $idLocal, string $nomenclaturaLocal) {
        $this->idTelefone = $idTelefone;
        $this->idLocal = $idLocal;
        $this->nomenclaturaLocal = $nomenclaturaLocal;
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

}
