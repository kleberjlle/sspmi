<?php
namespace App\sistema\acesso;

use App\modelo\{mConexao};

class sAmbiente {
    private int $idAmbiente;
    public mConexao $mConexao;
    
    public function consultar($pagina) {
        $this->setMConexao(new mConexao());  
        
        if ($pagina == 'tMenu4_1.php') {
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'ambiente',
                'camposCondicionados' => '',
                'valoresCondicionados' => '',
                'camposOrdenados' => 'nomenclatura',//caso não tenha, colocar como null
                'ordem' => 'ASC'//caso não tenha, colocar como null
            ];            
            $this->mConexao->CRUD($dados);
        }
    }    
    
    public function getIdAmbiente(): int {
        return $this->idAmbiente;
    }

    public function getMConexao(): mConexao {
        return $this->mConexao;
    }

    public function setIdAmbiente(int $idAmbiente): void {
        $this->idAmbiente = $idAmbiente;
    }

    public function setMConexao(mConexao $mConexao): void {
        $this->mConexao = $mConexao;
    }


}
