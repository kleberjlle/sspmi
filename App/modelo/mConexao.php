<?php

namespace App\modelo;

use App\sistema\acesso\{
    sNotificacao,
    sConfiguracao
};

class mConexao {

    private mixed $retorno;
    private mixed $conexao;
    private bool $validador;
    public sConfiguracao $sConfiguracao;
    public sNotificacao $sNotificacao;

    public function __construct() {
        $this->sConfiguracao = new sConfiguracao();
        $this->setConexao(new \mysqli(
                        $this->sConfiguracao->getHostname(),
                        $this->sConfiguracao->getUsername(),
                        $this->sConfiguracao->getPassword(),
                        $this->sConfiguracao->getDatabase(),
                        $this->sConfiguracao->getPort(),
                        $this->sConfiguracao->getSocket()
        ));
        mysqli_set_charset($this->conexao, $this->sConfiguracao->getCharsetDB());
        $this->validador = false;
    }

    public function CRUD($dados) {
        //verifica qual comando foi passado para solicitar o método apropriado
        switch ($dados['comando']) {
            case 'SELECT':
                $this->consultar($dados);
                break;
            case 'INSERT INTO':
                $this->inserir($dados);
                break;
            case 'UPDATE':
                echo "falta implementar UPDATE";
                break;
            case 'DELETE':
                echo "falta implementar DELETE";
                break;
            default:
                $this->setSNotificacao(new sNotificacao('E3'));
                $this->setValidador(false);
                break;
        }
    }

    private function consultar($dados) {

        //monta a query de consulta
        if (is_array($dados['tabelas'])) {
            $query = $this->consultarJuncao($dados);
        } else {
            $query = $this->consultarBasico($dados);
        }
        $query .= ';';

        //QA - início da área de testes
        /* verificar o que tem no objeto

          echo "<pre>";
          echo $query;
          echo "</pre>";

          // */
        //QA - fim da área de testes

        $resultado = $this->conexao->query($query);

        //tomada de decisão de acordo com o(s) campo(s)
        switch ($dados['tabelas']) {
            case 'email':
                if ($dados['camposCondicionados'] == 'idemail') {
                    if ($resultado->num_rows > 0) {
                        foreach ($resultado as $linha) {
                            $this->setRetorno($resultado);
                        }
                        $this->setValidador(true);
                    } else {
                        $this->setValidador(false);
                    }
                } else if ($dados['camposCondicionados'] == 'nomenclatura') {
                    if ($resultado->num_rows > 0) {
                        foreach ($resultado as $linha) {
                            $this->setRetorno($resultado);
                        }
                        $this->setValidador(true);
                    } else {
                        $this->setValidador(false);
                    }
                }
                if ($dados['busca'] == 'senha') {
                    if ($resultado->num_rows > 0) {
                        $this->setValidador(true);
                        foreach ($resultado as $linha) {
                            $this->setRetorno($linha['senha']);
                        }
                    } else {
                        $this->setValidador(false);
                    }
                }
                break;
            case 'cargo':
                if ($dados['camposCondicionados'] == 'idcargo') {
                    if ($resultado->num_rows > 0) {
                        foreach ($resultado as $linha) {
                            $this->setRetorno($resultado);
                        }
                        $this->setValidador(true);
                    } else {
                        $this->setValidador(false);
                    }
                }
            case 'permissao':
                if ($dados['camposCondicionados'] == 'idpermissao') {
                    if ($resultado->num_rows > 0) {
                        foreach ($resultado as $linha) {
                            $this->setRetorno($resultado);
                        }
                        $this->setValidador(true);
                    } else {
                        $this->setValidador(false);
                    }
                }
            case 'usuario':
                if ($dados['busca'] == '*') {
                    if ($resultado->num_rows > 0) {
                        foreach ($resultado as $linha) {
                            $this->setRetorno($resultado);
                        }
                        $this->setValidador(true);
                    } else {
                        $this->setValidador(false);
                    }
                }
                break;
            case 'telefone':
                if ($dados['busca'] == '*') {
                    if ($resultado->num_rows > 0) {
                        foreach ($resultado as $linha) {
                            $this->setRetorno($resultado);
                        }
                        $this->setValidador(true);
                    } else {
                        $this->setValidador(false);
                    }
                }
                break;
            case 'secretaria':
                if ($dados['busca'] == '*') {
                    if ($resultado->num_rows > 0) {
                        foreach ($resultado as $linha) {
                            $this->setRetorno($resultado);
                        }
                        $this->setValidador(true);
                    } else {
                        $this->setValidador(false);
                    }
                }
                break;
            case 'departamento':
                if ($dados['busca'] == '*') {
                    if ($resultado->num_rows > 0) {
                        foreach ($resultado as $linha) {
                            $this->setRetorno($resultado);
                        }
                        $this->setValidador(true);
                    } else {
                        $this->setValidador(false);
                    }
                }
                break;
            case 'coordenacao':
                if ($dados['busca'] == '*') {
                    if ($resultado->num_rows > 0) {
                        foreach ($resultado as $linha) {
                            $this->setRetorno($resultado);
                        }
                        $this->setValidador(true);
                    } else {
                        $this->setValidador(false);
                    }
                }
                break;
            case 'setor':
                if ($dados['busca'] == '*') {
                    if ($resultado->num_rows > 0) {
                        foreach ($resultado as $linha) {
                            $this->setRetorno($resultado);
                        }
                        $this->setValidador(true);
                    } else {
                        $this->setValidador(false);
                    }
                }
                break;
            case is_array(['telefone', 'telefone_has_setor']):
                if ($resultado->num_rows > 0) {
                    foreach ($resultado as $linha) {
                        $this->setRetorno($resultado);
                    }
                    $this->setValidador(true);
                } else {
                    $this->setValidador(false);
                }
                break;
            case is_array(['telefone', 'telefone_has_coordenacao']):
                if ($resultado->num_rows > 0) {
                    foreach ($resultado as $linha) {
                        $this->setRetorno($resultado);
                    }
                    $this->setValidador(true);
                } else {
                    $this->setValidador(false);
                }
                break;
            case is_array(['telefone', 'telefone_has_departamento']):
                if ($resultado->num_rows > 0) {
                    foreach ($resultado as $linha) {
                        $this->setRetorno($resultado);
                    }
                    $this->setValidador(true);
                } else {
                    $this->setValidador(false);
                }
                break;
            case is_array(['telefone', 'telefone_has_secretaria']):
                if ($resultado->num_rows > 0) {
                    foreach ($resultado as $linha) {
                        $this->setRetorno($resultado);
                    }
                    $this->setValidador(true);
                } else {
                    $this->setValidador(false);
                }
                break;
            case is_array(['email', 'email_has_setor']):
                if ($resultado->num_rows > 0) {
                    foreach ($resultado as $linha) {
                        $this->setRetorno($resultado);
                    }
                    $this->setValidador(true);
                } else {
                    $this->setValidador(false);
                }
                break;
            case is_array(['email', 'email_has_coordenacao']):
                if ($resultado->num_rows > 0) {
                    foreach ($resultado as $linha) {
                        $this->setRetorno($resultado);
                    }
                    $this->setValidador(true);
                } else {
                    $this->setValidador(false);
                }
                break;
            case is_array(['email', 'email_has_departamento']):
                if ($resultado->num_rows > 0) {
                    foreach ($resultado as $linha) {
                        $this->setRetorno($resultado);
                    }
                    $this->setValidador(true);
                } else {
                    $this->setValidador(false);
                }
                break;
            case is_array(['email', 'email_has_secretaria']):
                if ($resultado->num_rows > 0) {
                    foreach ($resultado as $linha) {
                        $this->setRetorno($resultado);
                    }
                    $this->setValidador(true);
                } else {
                    $this->setValidador(false);
                }
                break;
            default:
                break;
        }

        //mysqli_close($this->conexao);
    }

    public function consultarBasico($dados) {
        $query = '';
        $n1 = '';
        $n2 = '';
        $ordem = false;
        $valoresCondicionados = false;

        foreach ($dados as $key => $value) {
            if ($key == 'busca' && $value) {
                $query .= $value . ' FROM ';
            } else if ($key == 'camposCondicionados' && $value) {
                $query .= 'WHERE ' . $value . '=';
            } else if ($key == 'valoresCondicionados' && $value) {
                $valoresCondicionados = true;
                $n1 = "'$value' ";
                $n2 = "'$value'";
            } else if ($key == 'camposOrdenados' && $value) {
                $ordem = true;
                $query .= $n1 . 'ORDER BY ' . $value . ' ';
            } else if ($key == 'ordem') {
                if ($ordem) {
                    $query .= $value;
                } else {
                    $query .= $n2;
                }
            } else {
                if ($valoresCondicionados) {
                    $query .= $value;
                } else {
                    $query .= $value . ' ';
                }
            }
        }
        return $query;
    }

    public function consultarJuncao($dados) {
        $query = '';
        foreach ($dados as $key => $value) {
            if ($key == 'comando') {
                $query .= $value . ' ';
            }
        }
        $query .= $dados['busca'][0] . ', ' . $dados['busca'][1] . ' ';
        $query .= 'FROM ' . $dados['tabelas'][0] . ' INNER JOIN ' . $dados['tabelas'][1] . ' ';
        $query .= 'ON ' . $dados['valoresCondicionados'][0] . '=' . $dados['valoresCondicionados'][1];

        return $query;
        //SELECT telefone.numero, telefone.whatsApp FROM `telefone` INNER JOIN `telefone_has_setor` ON telefone.idtelefone=telefone_has_setor.telefone_idtelefone;
    }

    public function inserir($dados) {
        //monta a query para inserção dos dados
        $j = count($dados['camposInsercao'])-1;
        $query = '';
        $query .= $dados['comando'] . ' ';
        $query .= $dados['tabela'] . '(';        
        for ($i = 0; $i < count($dados['camposInsercao']); $i++) {
            if($i == $j){
                $query .= $dados['camposInsercao'][$i].') ';
            }else{
                $query .= $dados['camposInsercao'][$i].',';
            }            
        }
        $query .= 'VALUES (';
        for ($i = 0; $i < count($dados['valoresInsercao']); $i++) {
            if($i == $j){
                $query .= "'{$dados['valoresInsercao'][$i]}');";
            }else{
                $query .= "'{$dados['valoresInsercao'][$i]}',";
            }            
        }
        
        ///* QA - início da área de testes

        echo '<pre>';
        echo $query;
        echo '</pre>';
        //*/
        //QA - fim da área de testes
    }

    public function getRetorno(): mixed {
        return $this->retorno;
    }

    public function getConexao(): mixed {
        return $this->conexao;
    }

    public function getValidador(): bool {
        return $this->validador;
    }

    public function getSConfiguracao(): sConfiguracao {
        return $this->sConfiguracao;
    }

    public function getSNotificacao(): sNotificacao {
        return $this->sNotificacao;
    }

    public function setRetorno(mixed $retorno): void {
        $this->retorno = $retorno;
    }

    public function setConexao(mixed $conexao): void {
        $this->conexao = $conexao;
    }

    public function setValidador(bool $validador): void {
        $this->validador = $validador;
    }

    public function setSConfiguracao(sConfiguracao $sConfiguracao): void {
        $this->sConfiguracao = $sConfiguracao;
    }

    public function setSNotificacao(sNotificacao $sNotificacao): void {
        $this->sNotificacao = $sNotificacao;
    }

}
