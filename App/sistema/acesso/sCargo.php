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
        //cria conexão para sonsulta
        $this->setMConexao(new mConexao());
        if( $pagina == 'tAcessar.php' ||
            $pagina == 'tMenu1_2.php' ||
            $pagina == 'tMenu1_3.php'){                             
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'cargo',
                'camposCondicionados' => 'idcargo',
                'valoresCondicionados' => $this->getIdCargo(),
                'camposOrdenados' => null,//caso não tenha, colocar como null
                'ordem' => null //ASC ou DESC
            ];            
            $this->mConexao->CRUD($dados);
                        
            foreach ($this->mConexao->getRetorno() as $linha) {
                $this->setNomenclatura($linha['nomenclatura']);
            }
        } 
        
        if( $pagina == 'tMenu1_1_1.php' ||
            $pagina == 'tSolicitarAcesso.php' ||
            $pagina == 'tMenu1_2_1.php' ||
            $pagina == 'tMenu5_1.php'){                             
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'cargo',
                'camposCondicionados' => '',
                'valoresCondicionados' => '',
                'camposOrdenados' => 'nomenclatura',//caso não tenha, colocar como null
                'ordem' => 'ASC' //ASC ou DESC
            ];            
            $this->mConexao->CRUD($dados);
            
                        
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
