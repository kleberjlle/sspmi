<?php
namespace App\sistema\acesso;

use App\modelo\{mConexao};

class sSetor {
    private int $idSetor;
    private int $idDepartamento;
    private int $idSecretaria;
    private string $nomenclatura;
    private string $endereco;
    public mConexao $mConexao;
    
    public function __construct(int $idSetor) {
        $this->idSetor = $idSetor;
    }
    
    public function consultar($pagina) {
        $this->setMConexao(new mConexao());  
        if($pagina == 'tAcessar.php'){
                           
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'setor',
                'camposCondicionados' => 'idsetor',
                'valoresCondicionados' => $this->getIdSetor(),
                'camposOrdenados' => null,//caso não tenha, colocar como null
                'ordem' => 'ASC'
            ];            
            $this->mConexao->CRUD($dados);
                        
            foreach ($this->mConexao->getRetorno() as $linha) {
                $this->setIdSecretaria($linha['coordenacao_departamento_secretaria_idsecretaria']);
                $this->setIdDepartamento($linha['coordenacao_departamento_iddepartamento']);
                $this->setEndereco($linha['endereco']);
                $this->setNomenclatura($linha['nomenclatura']);
            }
        }    
        if($pagina == 'ajaxSetor.php'){
            //reoordena os IDs corretamente
            $this->setIdSecretaria($this->getIdSetor());
            $this->setIdSetor(0);
            
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'setor',
                'camposCondicionados' => 'coordenacao_departamento_secretaria_idsecretaria',
                'valoresCondicionados' => $this->getIdSecretaria(),
                'camposOrdenados' => 'nomenclatura',//caso não tenha, colocar como null
                'ordem' => 'ASC'
            ];
            
            $this->mConexao->CRUD($dados);
        }
    }

    public function getIdSetor(): int {
        return $this->idSetor;
    }

    public function getIdDepartamento(): int {
        return $this->idDepartamento;
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

    public function setIdSetor(int $idSetor): void {
        $this->idSetor = $idSetor;
    }

    public function setIdDepartamento(int $idDepartamento): void {
        $this->idDepartamento = $idDepartamento;
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
