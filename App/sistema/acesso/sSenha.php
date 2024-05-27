<?php
namespace App\sistema\acesso;
use App\modelo\{mConexao};

class sSenha {
    private $senhaCriptografada;
    private $senha;
    public sNotificacao $sNotificacao;
    public sConfiguracao $sConfiguracao;
    public mConexao $mConexao;
        
    public function criptografar($senha) {
        $this->setSenha($senha);
        $this->setSenhaCriptografada(password_hash(hash_hmac("sha256", $senha, "segurança"), PASSWORD_ARGON2ID));
    }
    
    public function verificar() {
        //verifica se a senha informada está correta
        $this->mConexao = new mConexao();
        $this->mConexao->consultar($this->getSenhaCriptografada());
    }

    public function getSenhaCriptografada() {
        return $this->senhaCriptografada;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getSNotificacao(): sNotificacao {
        return $this->sNotificacao;
    }

    public function setSenhaCriptografada($senhaCriptografada): void {
        $this->senhaCriptografada = $senhaCriptografada;
    }

    public function setSenha($senha): void {
        $this->senha = $senha;
    }

    public function setSNotificacao(sNotificacao $sNotificacao): void {
        $this->sNotificacao = $sNotificacao;
    }

       
    //QA - área de testes
    /*compara as senhas
     * 
    public function comparar($senha) {
        $senhaTemp = hash_hmac("sha256", $senha, "teste");
        if(password_verify($senhaTemp, $this->getSenha())){
            echo "é a mesma senha";
        }else{
            echo "não é a mesma senha";
        }
    }
    * 
    */
    //QA - fim da área de testes
}
