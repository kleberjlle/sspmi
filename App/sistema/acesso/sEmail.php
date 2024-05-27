<?php

namespace App\sistema\acesso;

use App\modelo\{mConexao};
use App\sistema\acesso\{sNotificacao};

class sEmail {
    private $email;
    private $validador;
    public mConexao $mConexao;
    public sNotificacao $sNotificacao;

    public function __construct($email) {
        $this->email = $email;
        $this->validador = false;
    }

    public function verificar($pagina) {
        if ($pagina == 'tAcessar.php') {
            //etapas de verificase é um endereço de e-mail
            if (filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL)) {
                $this->setValidador(true);
                $this->mConexao = new mConexao();

                //verificar se consta o email no BD            
                $dados = [
                    'comando' => 'SELECT',
                    'busca' => '*',
                    'tabelas' => 'email',
                    'camposCondicionados' => 'nomenclatura',
                    'valoresCondicionados' => $this->getEmail(),
                    'camposOrdenados' => 'idemail',//caso não tenha, colocar como null
                    'ordem' => 'ASC'
                ];

                $this->mConexao->CRUD($dados);
                
                if(!$this->mConexao->getValidador()){
                    $this->setValidador(false);
                    $this->setSNotificacao(new sNotificacao('A1'));
                }
            } else {
                //retornar notificação
                $this->setValidador(false);
                $this->setSNotificacao(new sNotificacao('A2'));
            }
        }
    }

    public function getEmail() {
        return $this->email;
    }

    public function getValidador() {
        return $this->validador;
    }

    public function getMConexao(): mConexao {
        return $this->mConexao;
    }

    public function getSNotificacao(): sNotificacao {
        return $this->sNotificacao;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setValidador($validador): void {
        $this->validador = $validador;
    }

    public function setMConexao(mConexao $mConexao): void {
        $this->mConexao = $mConexao;
    }

    public function setSNotificacao(sNotificacao $sNotificacao): void {
        $this->sNotificacao = $sNotificacao;
    }


}
