<?php
namespace App\sistema\acesso;

use App\modelo\{mConexao};

class sPermissao {
    private int $idPermissao;
    private int $nivel;
    private string $nomenclatura;
    public mConexao $mConexao;
    
    public function __construct(int $idPermissao) {
        $this->idPermissao = $idPermissao;
    }
    
    public function consultar($pagina) {
        if($pagina == 'tAcessar.php'){
            $this->setMConexao(new mConexao());                 
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'permissao',
                'camposCondicionados' => 'idpermissao',
                'valoresCondicionados' => $this->getIdPermissao(),
                'camposOrdenados' => null,//caso não tenha, colocar como null
                'ordem' => null //ASC ou DESC
            ];            
            $this->mConexao->CRUD($dados);
                        
            foreach ($this->mConexao->getRetorno() as $linha) {
                $this->setNivel($linha['nivel']);
                $this->setNomenclatura($linha['nomenclatura']);
            }
        }        
    }

    public function getIdPermissao(): int {
        return $this->idPermissao;
    }

    public function getNivel(): int {
        return $this->nivel;
    }

    public function getNomenclatura(): string {
        return $this->nomenclatura;
    }

    public function getMConexao(): mConexao {
        return $this->mConexao;
    }

    public function setIdPermissao(int $idPermissao): void {
        $this->idPermissao = $idPermissao;
    }

    public function setNivel(int $nivel): void {
        $this->nivel = $nivel;
    }

    public function setNomenclatura(string $nomenclatura): void {
        $this->nomenclatura = $nomenclatura;
    }

    public function setMConexao(mConexao $mConexao): void {
        $this->mConexao = $mConexao;
    }


}