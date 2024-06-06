<?php

namespace App\sistema\acesso;

use App\modelo\{
    mConexao
};
use App\sistema\acesso\{
    sNotificacao
};

class sEmail {

    private int $idEmail;
    private string $nomenclatura;
    private string $nomenclaturaLocal;
    private bool $validador;
    public mConexao $mConexao;
    public sNotificacao $sNotificacao;

    public function __construct($nomenclatura, $nomenclaturaLocal) {
        $this->nomenclatura = $nomenclatura;
        $this->nomenclaturaLocal = $nomenclaturaLocal;
        $this->validador = false;
    }

    public function verificar($pagina) {
        if ($pagina == 'tAcessar.php') {
            //etapas de verificase é um endereço de e-mail
            if (filter_var($this->getNomenclatura(), FILTER_VALIDATE_EMAIL)) {
                //verifica se consta o email no BD
                $this->setMConexao(new mConexao());
                $dados = [
                    'comando' => 'SELECT',
                    'busca' => '*',
                    'tabelas' => 'email',
                    'camposCondicionados' => 'nomenclatura',
                    'valoresCondicionados' => $this->getNomenclatura(),
                    'camposOrdenados' => null, //caso não tenha, colocar como null
                    'ordem' => null //ASC ou DESC
                ];
                $this->mConexao->CRUD($dados);

                //se não localizou o registro do no BD
                if (!$this->mConexao->getValidador()) {
                    $this->setValidador(false);
                    $this->setSNotificacao(new sNotificacao('A1'));
                } else {
                    foreach ($this->mConexao->getRetorno() as $linha) {
                        $this->setIdEmail($linha['idemail']);
                        $this->setNomenclatura($linha['nomenclatura']);
                    }
                    $this->setValidador(true);
                }
            } else {
                //retornar notificação
                $this->setValidador(false);
                $this->setSNotificacao(new sNotificacao('A2'));
            }
        }
    }

    public function consultar($pagina) {
        //encaminha as buscas de acordo com a origem 
        if ($pagina == 'tAcessar.php') {
            $this->setMConexao(new mConexao());
            if ($this->getNomenclaturaLocal() == 'email') {
                //organiza os dados nos devidos campos
                $this->setIdEmail($this->getNomenclatura());
                $this->setNomenclatura('');
                
                $dados = [
                    'comando' => 'SELECT',
                    'busca' => '*',
                    'tabelas' => 'email',
                    'camposCondicionados' => 'idemail',
                    'valoresCondicionados' => $this->getIdEmail(),
                    'camposOrdenados' => null, //caso não tenha, colocar como null
                    'ordem' => null //ASC ou DESC
                ];
            } else if ($this->getNomenclaturaLocal() == 'setor' ||
                    $this->getNomenclaturaLocal() == 'coordenacao' ||
                    $this->getNomenclaturaLocal() == 'departamento' ||
                    $this->getNomenclaturaLocal() == 'secretaria') {
                $dados = [
                    'comando' => 'SELECT',
                    'busca' => ['email.idemail', 'email.nomenclatura'],
                    'tabelas' => ['email', 'email_has_'.$this->getNomenclaturaLocal()],
                    'camposCondicionados' => '',
                    'valoresCondicionados' => ['email.idemail', 'email_has_'.$this->getNomenclaturaLocal().'.email_idemail'],
                    'camposOrdenados' => null, //caso não tenha, colocar como null
                    'ordem' => null //ASC ou DESC
                ];
            }
            $this->mConexao->CRUD($dados);

            foreach ($this->mConexao->getRetorno() as $linha) {
                $this->setIdEmail($linha['idemail']);
                $this->setNomenclatura($linha['nomenclatura']);
            }
            $this->setValidador(true);
        }
    }

    public function getIdEmail(): int {
        return $this->idEmail;
    }

    public function getNomenclatura(): string {
        return $this->nomenclatura;
    }

    public function getNomenclaturaLocal(): string {
        return $this->nomenclaturaLocal;
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

    public function setNomenclatura(string $nomenclatura): void {
        $this->nomenclatura = $nomenclatura;
    }

    public function setNomenclaturaLocal(string $nomenclaturaLocal): void {
        $this->nomenclaturaLocal = $nomenclaturaLocal;
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
