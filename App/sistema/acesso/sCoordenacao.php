<?php
namespace App\sistema\acesso;

use App\modelo\{mConexao};

class sCoordenacao {
    private int $idCoordenacao;
    private int $idSecretaria;
    private string $nomenclatura;
    private string $endereco;
    public mConexao $mConexao;
    
    public function __construct(int $idCoordenacao) {
        $this->idCoordenacao = $idCoordenacao;
    }
    
    public function consultar($pagina) {
        $this->setMConexao(new mConexao());  
        if($pagina == 'tAcessar.php'){
                           
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'coordenacao',
                'camposCondicionados' => 'idcoordenacao',
                'valoresCondicionados' => $this->getIdCoordenacao(),
                'camposOrdenados' => null,//caso não tenha, colocar como null
                'ordem' => 'ASC'
            ];            
            $this->mConexao->CRUD($dados);
                        
            foreach ($this->mConexao->getRetorno() as $linha) {
                $this->setIdSecretaria($linha['departamento_secretaria_idsecretaria']);
                $this->setEndereco($linha['endereco']);
                $this->setNomenclatura($linha['nomenclatura']);
            }
        }    
        
        if($pagina == 'ajaxCoordenacao.php'){
            //reoordena os IDs corretamente
            $this->setIdSecretaria($this->getIdCoordenacao());
            $this->setIdCoordenacao(0);
            
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'coordenacao',
                'camposCondicionados' => 'departamento_secretaria_idsecretaria',
                'valoresCondicionados' => $this->getIdSecretaria(),
                'camposOrdenados' => 'nomenclatura',//caso não tenha, colocar como null
                'ordem' => 'ASC'
            ];
            
            $this->mConexao->CRUD($dados);
            
            
        }
    }

    public function getIdCoordenacao(): int {
        return $this->idCoordenacao;
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

    public function setIdCoordenacao(int $idCoordenacao): void {
        $this->idCoordenacao = $idCoordenacao;
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
