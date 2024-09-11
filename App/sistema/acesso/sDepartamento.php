<?php

namespace App\sistema\acesso;

use App\modelo\{
    mConexao
};

use App\sistema\acesso\{
    sNotificacao
};

class sDepartamento {

    private int $idDepartamento;
    private int $idSecretaria;
    private string $nomenclatura;
    private string $endereco;
    public mConexao $mConexao;
    public sNotificacao $sNotificacao;

    public function __construct(int $idDepartamento) {
        $this->idDepartamento = $idDepartamento;
    }

    public function consultar($pagina) {
        //cria conexão para as opções das páginas abaixo
        $this->setMConexao(new mConexao());
        if ($pagina == 'tAcessar.php' ||
            $pagina == 'tMenu1_2.php' ||
            $pagina == 'tMenu1_3.php' ||
            $pagina == 'tMenu2_1.php') {
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'departamento',
                'camposCondicionados' => 'iddepartamento',
                'valoresCondicionados' => $this->getIdDepartamento(),
                'camposOrdenados' => null, //caso não tenha, colocar como null
                'ordem' => null
            ];
            
            $this->mConexao->CRUD($dados);
            
            foreach ($this->mConexao->getRetorno() as $linha) {
                $this->setIdSecretaria($linha['secretaria_idsecretaria']);
                $this->setEndereco($linha['endereco']);
                $this->setNomenclatura($linha['nomenclatura']);
            }
        }

        if ($pagina == 'tMenu1_1_1.php') {
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'departamento',
                'camposCondicionados' => 'secretaria_idsecretaria',
                'valoresCondicionados' => $this->getIdSecretaria(),
                'camposOrdenados' => null, //caso não tenha, colocar como null
                'ordem' => null
            ];
            
            $this->mConexao->CRUD($dados);
        }

        if ($pagina == 'ajaxDepartamento.php') {
            //consulta para busca com id da secretaria
            $this->setIdSecretaria($this->getIdDepartamento());
            $this->setIdDepartamento(0);

            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'departamento',
                'camposCondicionados' => 'secretaria_idsecretaria',
                'valoresCondicionados' => $this->getIdSecretaria(),
                'camposOrdenados' => 'nomenclatura', //caso não tenha, colocar como null
                'ordem' => 'ASC'
            ];
            
            $this->mConexao->CRUD($dados);
        }
        
        if ($pagina == 'tMenu1_2_1.php') {
            //consulta para busca sem o id da secretaria
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'departamento',
                'camposCondicionados' => '',
                'valoresCondicionados' => '',
                'camposOrdenados' => 'nomenclatura', //caso não tenha, colocar como null
                'ordem' => 'ASC'
            ];
            
            $this->mConexao->CRUD($dados);
        }
        
        if ($pagina == 'tMenu4_1.php' ||
            $pagina == 'tMenu2_1.php-f1' ||
            $pagina == 'tMenu2_2_2.php') {
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'departamento',
                'camposCondicionados' => '',
                'valoresCondicionados' => '',
                'camposOrdenados' => 'nomenclatura',//caso não tenha, colocar como null
                'ordem' => 'ASC'
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
                'tabela' => 'departamento',
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

    public function getSNotificacao(): sNotificacao {
        return $this->sNotificacao;
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

    public function setSNotificacao(sNotificacao $sNotificacao): void {
        $this->sNotificacao = $sNotificacao;
    }
}
