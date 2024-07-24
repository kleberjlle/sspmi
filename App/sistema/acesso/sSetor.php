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
        if( $pagina == 'tAcessar.php' ||
            $pagina == 'tMenu1_2.php' ||
            $pagina == 'tMenu1_2_1.php' ||
            $pagina == 'tMenu1_3.php' ||
            $pagina == 'tMenu2_1.php'){
                           
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'setor',
                'camposCondicionados' => 'idsetor',
                'valoresCondicionados' => $this->getIdSetor(),
                'camposOrdenados' => null,//caso não tenha, colocar como null
                'ordem' => null
            ];            
            $this->mConexao->CRUD($dados);
                        
            foreach ($this->mConexao->getRetorno() as $linha) {
                $this->setIdSecretaria($linha['secretaria_idsecretaria']);
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
                'camposCondicionados' => 'secretaria_idsecretaria',
                'valoresCondicionados' => $this->getIdSecretaria(),
                'camposOrdenados' => 'nomenclatura',//caso não tenha, colocar como null
                'ordem' => 'ASC'
            ];
            
            $this->mConexao->CRUD($dados);
        }
        if ($pagina == 'tMenu4_1.php' ||
            $pagina == 'tMenu2_1.php-f1') {
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'setor',
                'camposCondicionados' => '',
                'valoresCondicionados' => '',
                'camposOrdenados' => 'nomenclatura',//caso não tenha, colocar como null
                'ordem' => 'ASC'//caso não tenha, colocar como null
            ];            
            $this->mConexao->CRUD($dados);
        }
    }
    
    public function inserir($pagina, $tratarDados) {
        //cria conexão para inserir os dados na tabela
        $this->setMConexao(new mConexao());
        if ($pagina == 'tMenu4_1.php') {
            
            //insere os dados do histórico no BD            
            $dados = [
                'comando' => 'INSERT INTO',
                'tabela' => 'setor',
                'camposInsercao' => [
                    'nomenclatura',
                    'endereco',
                    'secretaria_idsecretaria'
                ],
                'valoresInsercao' => [
                    $tratarDados['nomenclatura'],
                    $tratarDados['endereco'],
                    $tratarDados['idSecretaria']
                ]
            ];            
        }
        $this->mConexao->CRUD($dados);
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
