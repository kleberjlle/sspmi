<?php
namespace App\sistema\acesso;

use App\modelo\{mConexao};

class sSecretaria {
    private int $idSecretaria;
    private string $nomenclatura;
    private string $endereco;
    public mConexao $mConexao;
    
    public function __construct(int $idSecretaria) {
        $this->idSecretaria = $idSecretaria;
    }
    
    public function consultar($pagina) {
        if($pagina == 'tMenu1_1.php'){
            $this->setMConexao(new mConexao());                 
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'secretaria',
                'camposCondicionados' => 'idsecretaria',
                'valoresCondicionados' => $this->getIdSecretaria(),
                'camposOrdenados' => 'idsecretaria',//caso não tenha, colocar como null
                'ordem' => 'ASC'
            ];            
            $this->mConexao->CRUD($dados);
                        
            foreach ($this->mConexao->getRetorno() as $linha) {
                $this->setEndereco($linha['endereco']);
                $this->setNomenclatura($linha['nomenclatura']);               
            }
        }        
    }

    public function getIdSecretaria(): int {
        return $this->idSecretaria;
    }

    public function getNomenclatura(): string {
        return $this->nomenclatura;
    }

    public function getEndereco(): string {
        return $this->endereco;
    }

    public function getMConexao(): mConexao {
        return $this->mConexao;
    }

    public function setIdSecretaria(int $idSecretaria): void {
        $this->idSecretaria = $idSecretaria;
    }

    public function setNomenclatura(string $nomenclatura): void {
        $this->nomenclatura = $nomenclatura;
    }

    public function setEndereco(string $endereco): void {
        $this->endereco = $endereco;
    }

    public function setMConexao(mConexao $mConexao): void {
        $this->mConexao = $mConexao;
    }
}
