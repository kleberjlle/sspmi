<?php
namespace App\sistema\acesso;

use App\modelo\{mConexao};

class sTelefone {
    private int $idTelefone;
    private int $idLocal;
    private string $numero;
    private bool $whatsApp;
    public mConexao $mConexao;
    
    public function __construct(int $idTelefone, int $idLocal) {
        $this->idTelefone = $idTelefone;
        $this->idLocal = $idLocal;
    }
    
    public function consultar($pagina) {
        if($pagina == 'tMenu1_1.php'){
            $this->setMConexao(new mConexao());                 
            $dados = [
                'comando' => 'SELECT',
                'busca' => 'telefone.numero, telefone.whatsApp',
                'tabelas' => ['telefone', 'telefone_has_setor'],
                'camposCondicionados' => '',
                'valoresCondicionados' => ['telefone.idtelefone', 'telefone_has_setor.telefone_idtelefone'],
                'camposOrdenados' => null,//caso não tenha, colocar como null
                'ordem' => 'ASC'
            ];            
            $this->mConexao->CRUD($dados);
                        
            foreach ($this->mConexao->getRetorno() as $linha) {
                $this->setNomenclatura($linha['nomenclatura']);
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

    public function setMConexao(mConexao $mConexao): void {
        $this->mConexao = $mConexao;
    }


}
