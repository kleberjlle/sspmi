<?php
namespace App\sistema\acesso;
use App\modelo\{mConexao};

class sSenha {
    private $email;
    private $senhaCriptografada;
    private $senha;
    public sNotificacao $sNotificacao;
    public sConfiguracao $sConfiguracao;
    public mConexao $mConexao;
        
    public function criptografar($senha) {
        $this->setSenha($senha);
        $this->setSenhaCriptografada(password_hash(hash_hmac("sha256", $senha, "sspmi"), PASSWORD_ARGON2ID));
    }
    
    public function verificar($pagina) {
        if($pagina == 'tAcessar.php'){
            //pega a senha do BD
            $this->mConexao = new mConexao();
            
            
            /*
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'email',
                'camposCondicionados' => 'nomenclatura',
                'valoresCondicionados' => $this->getEmail(),
                'camposOrdenados' => 'idemail',//caso não tenha, colocar como null
                'ordem' => 'ASC'
            ];
            
            $senhaTemp = hash_hmac("sha256", $this->getSenha(), "sspmi");
            if(password_verify($senhaTemp, $this->getSenhaCriptografada())){
                echo "é a mesma senha";
            }else{
                echo "não é a mesma senha";
            }
             * 
             */
        }
        
        //verifica se a senha informada está correta
        
    }

    public function getEmail() {
        return $this->email;
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

    public function getSConfiguracao(): sConfiguracao {
        return $this->sConfiguracao;
    }

    public function getMConexao(): mConexao {
        return $this->mConexao;
    }

    public function setEmail($email): void {
        $this->email = $email;
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

    public function setSConfiguracao(sConfiguracao $sConfiguracao): void {
        $this->sConfiguracao = $sConfiguracao;
    }

    public function setMConexao(mConexao $mConexao): void {
        $this->mConexao = $mConexao;
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
