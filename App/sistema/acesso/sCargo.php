<?php
namespace App\sistema\acesso;

use App\modelo\{mConexao};

class sCargo {
    private int $idCargo;
    private string $nomenclatura;
    public mConexao $mConexao;
    
    public function __construct(int $idCargo) {
        $this->idCargo = $idCargo;
    }
    
    public function consultar($pagina) {
        if($pagina == 'tMenu1_1.php'){
            $this->setMConexao(new mConexao());                 
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'cargo',
                'camposCondicionados' => 'idcargo',
                'valoresCondicionados' => $this->getIdCargo(),
                'camposOrdenados' => null,//caso não tenha, colocar como null
                'ordem' => 'ASC'
            ];            
            $this->mConexao->CRUD($dados);
                        
            foreach ($this->mConexao->getRetorno() as $linha) {
                $this->setNomenclatura($linha['nomenclatura']);
            }
        }        
    }

    public function getIdCargo(): int {
        return $this->idCargo;
    }

    public function getNomenclatura(): string {
        return $this->nomenclatura;
    }

    public function getMConexao(): mConexao {
        return $this->mConexao;
    }

    public function setIdCargo(int $idCargo): void {
        $this->idCargo = $idCargo;
    }

    public function setNomenclatura(string $nomenclatura): void {
        $this->nomenclatura = $nomenclatura;
    }

    public function setMConexao(mConexao $mConexao): void {
        $this->mConexao = $mConexao;
    }


}
