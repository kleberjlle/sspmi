<?php
namespace App\sistema\acesso;
use App\modelo\{mConexao};

class sHistorico{
    private $dados;
    public mConexao $mConexao;

    public function __construct($pagina, $acao, $campo, $valorAtual, $valorAnterior, $ip, $navegador, $sistemaOperacional, $nomeDoDispositivo, $idUsuario) {
                
        $dados = [
        'pagina' => $pagina,
        'acao' => $acao,
        'campo' => $campo,
        'valorAtual' => $valorAtual,
        'valorAnterior' => $valorAnterior,
        'ip' => $ip,
        'navegador' => $navegador,
        'sistemaOperacional' => $sistemaOperacional,
        'nomeDoDispositivo' => $nomeDoDispositivo,
        'idUsuario' => $idUsuario
        ];
        
        $this->mConexao = new mConexao();
        $this->mConexao->inserir($dados);
    }
    
    public function getDados() {
        return $this->dados;
    }

    public function getMConexao(): mConexao {
        return $this->mConexao;
    }

    public function setDados($dados): void {
        $this->dados = $dados;
    }

    public function setMConexao(mConexao $mConexao): void {
        $this->mConexao = $mConexao;
    }



}

?>
        