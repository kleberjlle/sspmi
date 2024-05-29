<?php
namespace App\sistema\acesso;

use App\modelo\{mConexao};

class sUsuario {
    private int $idUsuario;
    private string $nome;
    private string $sobrenome;
    private string $sexo;
    private string $imagem;
    private bool $situacao;//alterar no bd
    private int $idSetor;
    private int $idCoordenacao;
    private int $idSecretaria;
    private int $idTelefone;
    private int $idCargo;
    private int $idEmail;
    private int $idPermissao;
    private bool $validador;
    public mConexao $mConexao;


    public function __construct() {
        $this->validador = false;
    }

    
    public function consultar($pagina) {
        //tomada de decisão de acordo com a página
        if($pagina == 'tAcessar.php'){            
            //busca os dados do usuário no BD
            $this->setMConexao(new mConexao());                            
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'usuario',
                'camposCondicionados' => 'email_idemail',
                'valoresCondicionados' => $this->getIdEmail(),
                'camposOrdenados' => null,//caso não tenha, colocar como null
                'ordem' => 'ASC'
            ];
            $this->mConexao->CRUD($dados);
            
            session_start();
            foreach ($this->mConexao->getRetorno() as $linha) {
                $_SESSION['credencial'] = [
                    'idUsuario' => $linha['idusuario'],
                    'nome' => $linha['nome'],
                    'sobrenome' => $linha['sobrenome'],
                    'sexo' => $linha['sexo'],
                    'imagem' => $linha['imagem'],
                    'situacao' => $linha['situacao'],
                    'setor_idsetor' => $linha['setor_idsetor'],
                    'coordenacao_idcoordenacao' => $linha['coordenacao_idcoordenacao'],
                    'secretaria_idsecretaria' => $linha['secretaria_idsecretaria'],
                    'telefone_idtelefone' => $linha['telefone_idtelefone'],
                    'cargo_idcargo' => $linha['cargo_idcargo'],
                    'email_idemail' => $linha['email_idemail'],
                    'permissao_idpermissao' => $linha['permissao_idpermissao']
                ];
            }
            header('Location: ./tPainel.php');
        }
    }
    
    public function getIdUsuario(): int {
        return $this->idUsuario;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getSobrenome(): string {
        return $this->sobrenome;
    }

    public function getSexo(): string {
        return $this->sexo;
    }

    public function getImagem(): string {
        return $this->imagem;
    }

    public function getSituacao(): bool {
        return $this->situacao;
    }

    public function getIdSetor(): int {
        return $this->idSetor;
    }

    public function getIdCoordenacao(): int {
        return $this->idCoordenacao;
    }

    public function getIdSecretaria(): int {
        return $this->idSecretaria;
    }

    public function getIdTelefone(): int {
        return $this->idTelefone;
    }

    public function getIdCargo(): int {
        return $this->idCargo;
    }

    public function getIdEmail(): int {
        return $this->idEmail;
    }

    public function getIdPermissao(): int {
        return $this->idPermissao;
    }

    public function getValidador(): bool {
        return $this->validador;
    }

    public function getMConexao(): mConexao {
        return $this->mConexao;
    }

    public function setIdUsuario(int $idUsuario): void {
        $this->idUsuario = $idUsuario;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function setSobrenome(string $sobrenome): void {
        $this->sobrenome = $sobrenome;
    }

    public function setSexo(string $sexo): void {
        $this->sexo = $sexo;
    }

    public function setImagem(string $imagem): void {
        $this->imagem = $imagem;
    }

    public function setSituacao(bool $situacao): void {
        $this->situacao = $situacao;
    }

    public function setIdSetor(int $idSetor): void {
        $this->idSetor = $idSetor;
    }

    public function setIdCoordenacao(int $idCoordenacao): void {
        $this->idCoordenacao = $idCoordenacao;
    }

    public function setIdSecretaria(int $idSecretaria): void {
        $this->idSecretaria = $idSecretaria;
    }

    public function setIdTelefone(int $idTelefone): void {
        $this->idTelefone = $idTelefone;
    }

    public function setIdCargo(int $idCargo): void {
        $this->idCargo = $idCargo;
    }

    public function setIdEmail(int $idEmail): void {
        $this->idEmail = $idEmail;
    }

    public function setIdPermissao(int $idPermissao): void {
        $this->idPermissao = $idPermissao;
    }

    public function setValidador(bool $validador): void {
        $this->validador = $validador;
    }

    public function setMConexao(mConexao $mConexao): void {
        $this->mConexao = $mConexao;
    }
}
