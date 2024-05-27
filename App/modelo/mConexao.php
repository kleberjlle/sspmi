<?php

namespace App\modelo;

use App\sistema\acesso\{sNotificacao,sConfiguracao};

class mConexao {

    private $conexao;
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
        $this->validador = false;
    }
    
    public function CRUD($dados) {
        //verifica qual comando foi passado para solicitar o método apropriado
        switch ($dados['comando']) {
            case 'SELECT':
                $this->consultar($dados);
                break;
            case 'INSERT':
                echo "falta implementar insert";
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
        $query = '';
        $n1 = '';
        $n2 = '';
        $ordem = false;
        $valoresCondicionados = false;
        
        //monta a query de consulta
        foreach ($dados as $key => $value) {   
            if($key == 'busca' && $value){
                $query .= $value.' FROM ';
            }else if($key == 'camposCondicionados' && $value){
                $query .= 'WHERE '.$value.'=';
            }else if($key == 'valoresCondicionados' && $value){
                $valoresCondicionados = true;
                $n1 = "'$value' ";
                $n2 = "'$value'";
            }else if($key == 'camposOrdenados' && $value){
                $ordem = true;
                $query .= $n1.'ORDER BY '.$value.' ';
            }else if($key == 'ordem'){
                if($ordem){
                    $query .= $value;
                }else{
                    $query .= $n2;
                }                
            }else{
                if($valoresCondicionados){
                    $query .= $value;
                }else{
                    $query .= $value.' ';
                }                
            }                
        }
        $query .= ';';
        
        $resultado = $this->conexao->query($query);

        
        if($resultado->num_rows > 0){
            $this->setValidador(true);
        }else{
            $this->setValidador(false);
        }
        
        /*QA - início da área de testes
        
        //var_dump($dados);
        echo $query;
        
        foreach ($resultado as $key) {
            echo "<pre>";
            echo 'email = ' . $key['nomenclatura'];
            echo "</pre>";
        }
        //QA - fim da área de testes
        //*/
    }

    public function inserir($dados) {
        
        $this->conexao->query("INSERT INTO historico(pagina, acao, campo, valorAtual, valorAnterior, ip, navegador, sistemaOperacional, nomeDoDispositivo, idusuario)"
        . "VALUES ('{$dados['pagina']}','{$dados['acao']}','{$dados['campo']}','{$dados['valorAtual']}','{$dados['valorAnterior']}','{$dados['ip']}','{$dados['navegador']}','{$dados['sistemaOperacional']}','{$dados['nomeDoDispositivo']}','{$dados['idUsuario']}');");

       
        
        /*QA - início da área de testes
        
        echo '<pre>';
        var_dump($dados);
        echo '</pre>';
        */
        //QA - fim da área de testes
        
    }
    
    public function getConexao() {
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

    public function setConexao($conexao): void {
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
