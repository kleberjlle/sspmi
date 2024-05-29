<?php

namespace App\sistema\acesso;

use App\modelo\{mConexao};
use App\sistema\acesso\{sNotificacao};

class sEmail {
    private int $idEmail;
    private string $email;
    private bool $validador;
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
                
                //verifica se consta o email no BD
                $this->mConexao = new mConexao();                            
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
                
                //se não localizou o registro do no BD
                if(!$this->mConexao->getValidador()){
                    $this->setValidador(false);
                    $this->setSNotificacao(new sNotificacao('A1'));
                }else{
                    $this->setIdEmail($this->mConexao->getRetorno());
                    $this->setValidador(true);
                }
            } else {
                //retornar notificação
                $this->setValidador(false);
                $this->setSNotificacao(new sNotificacao('A2'));
            }
        }
    }

    public function getIdEmail(): int {
        return $this->idEmail;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getValidador(): bool {
        return $this->validador;
    }

    public function getMConexao(): mConexao {
        return $this->mConexao;
    }

    public function getSNotificacao(): sNotificacao {
        return $this->sNotificacao;
    }

    public function setIdEmail(int $idEmail): void {
        $this->idEmail = $idEmail;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setValidador(bool $validador): void {
        $this->validador = $validador;
    }

    public function setMConexao(mConexao $mConexao): void {
        $this->mConexao = $mConexao;
    }

    public function setSNotificacao(sNotificacao $sNotificacao): void {
        $this->sNotificacao = $sNotificacao;
    }
}
