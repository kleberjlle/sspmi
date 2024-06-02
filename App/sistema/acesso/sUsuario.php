<?php
namespace App\sistema\acesso;

use App\modelo\{mConexao};
use App\sistema\acesso\{
    sNotificacao,
    sSetor,
    sCoordenacao,
    sDepartamento,
    sSecretaria,
    sTelefone,
    sEmail,
    sCargo,
    sPermissao
};

class sUsuario {
    private int $idUsuario;
    private int $idEmail;
    private bool $validador;
    private string $nome;
    private string $sobrenome;
    private string $sexo;
    private string $imagem;
    private bool $situacao;//alterar no bd
    private sSetor $sSetor;
    private sCoordenacao $sCoordenacao;
    private sDepartamento $sDepartamento;
    private sSecretaria $sSecretaria;
    private sTelefone $sTelefoneUsuario;
    private sTelefone $sTelefoneSetor;
    private sTelefone $sTelefoneCoordenacao;
    private sTelefone $sTelefoneDepartamento;
    private sTelefone $sTelefoneSecretaria;    
    private sEmail $sEmailUsuario;
    private sEmail $sEmailSetor;
    private sEmail $sEmailCoordenacao;
    private sEmail $sEmailDepartamento;
    private sEmail $sEmailSecretaria;
    private sCargo $sCargo;
    private sPermissao $sPermissao;
    public mConexao $mConexao;
    public sNotificacao $sNotificacao;

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
            
            //busca dos dados do usuário
            foreach ($this->mConexao->getRetorno() as $linha) {
                $idUsuario = $linha['idusuario'];
                $nome = $linha['nome'];
                $sobrenome = $linha['sobrenome'];
                $sexo = $linha['sexo'];
                $imagem = $linha['imagem'];
                $situacao = $linha['situacao'];
                $idSetor = $linha['setor_idsetor'];
                $idCoordenacao = $linha['coordenacao_idcoordenacao'];
                $idDepartamento = $linha['departamento_iddepartamento'];
                $idSecretaria = $linha['secretaria_idsecretaria'];
                $idTelefoneUsuario = $linha['telefone_idtelefone'];
                $idCargo = $linha['cargo_idcargo'];
                $idEmail = $linha['email_idemail'];
                $idPermissao = $linha['permissao_idpermissao'];
            }
            
            if(!$situacao){
                //notifica o usuário sobre a inatividade do perfil
                $this->setSNotificacao(new sNotificacao('A7'));
                $this->setValidador(false);
            }else{               
                //tratamento dos dados buscados
                $sexo == 'M' ? $sexo = 'Masculino' : 'Feminino';
                $situacao ? $situacao = 'Ativo' : $situacao = 'Inativo';
                
                $this->setSSetor(new sSetor($idSetor));
                $this->sSetor->consultar($pagina);
                
                $this->setSCoordenacao(new sCoordenacao($idCoordenacao));
                $this->sCoordenacao->consultar($pagina);
                
                $this->setSDepartamento(new sDepartamento($idDepartamento));
                $this->sDepartamento->consultar($pagina);

                $this->setSSecretaria(new sSecretaria($idSecretaria));
                $this->sSecretaria->consultar($pagina);
                
                $this->setSTelefoneUsuario(new sTelefone($idTelefoneUsuario, $idUsuario, 'usuario'));
                $this->sTelefoneUsuario->consultar($pagina);
                
                $this->setSTelefoneSetor(new sTelefone(0, $this->sSetor->getIdSetor(), 'setor'));
                $this->sTelefoneSetor->consultar($pagina);
                
                $this->setSTelefoneCoordenacao(new sTelefone(0, $this->sCoordenacao->getIdCoordenacao(), 'coordenacao'));
                $this->sTelefoneCoordenacao->consultar($pagina);
                
                $this->setSTelefoneDepartamento(new sTelefone(0, $this->sDepartamento->getIdDepartamento(), 'departamento'));
                $this->sTelefoneDepartamento->consultar($pagina);
                
                $this->setSTelefoneSecretaria(new sTelefone(0, $this->sSecretaria->getIdSecretaria(), 'secretaria'));
                $this->sTelefoneSecretaria->consultar($pagina);
                
                $this->setSEmailUsuario(new sEmail($idEmail, 'email'));
                $this->sEmailUsuario->consultar($pagina);
                
                $this->setSEmailSetor(new sEmail($idEmail, 'setor'));
                $this->sEmailSetor->consultar($pagina);

                $this->setSEmailCoordenacao(new sEmail($idEmail, 'coordenacao'));
                $this->sEmailCoordenacao->consultar($pagina);
                
                $this->setSEmailDepartamento(new sEmail($idEmail, 'departamento'));
                $this->sEmailDepartamento->consultar($pagina);

                $this->setSEmailSecretaria(new sEmail($idEmail, 'secretaria'));
                $this->sEmailSecretaria->consultar($pagina);
                
                $this->setSCargo(new sCargo($idCargo));
                $this->sCargo->consultar($pagina);
                
                $this->setSPermissao(new sPermissao($idPermissao));
                $this->sPermissao->consultar($pagina);
                
                session_start();
                $_SESSION['credencial'] = [
                        'idUsuario' => $idUsuario,
                        'nome' => $nome,
                        'sobrenome' => $sobrenome,
                        'sexo' => $sexo,
                        'imagem' => $imagem,
                        'situacao' => $situacao,
                        'setor' => $this->sSetor->getNomenclatura(),
                        'coordenacao' => $this->sCoordenacao->getNomenclatura(),
                        'departamento' => $this->sDepartamento->getNomenclatura(),
                        'secretaria' => $this->sSecretaria->getNomenclatura(),
                        'telefoneUsuario' => $this->sTelefoneUsuario->getNumero(),
                        'whatsAppUsuario' => $this->sTelefoneUsuario->getWhatsApp(),
                        'telefoneSetor' => $this->sTelefoneSetor->getNumero(),
                        'whatsAppSetor' => $this->sTelefoneSetor->getWhatsApp(),
                        'telefoneCoordenacao' => $this->sTelefoneCoordenacao->getNumero(),
                        'whatsAppCoordenacao' => $this->sTelefoneCoordenacao->getWhatsApp(),
                        'telefoneDepartamento' => $this->sTelefoneDepartamento->getNumero(),
                        'whatsAppDepartamento' => $this->sTelefoneDepartamento->getWhatsApp(),
                        'telefoneSecretaria' => $this->sTelefoneSecretaria->getNumero(),
                        'whatsAppSecretaria' => $this->sTelefoneSecretaria->getWhatsApp(),
                        'emailUsuario' => $this->sEmailUsuario->getNomenclatura(),
                        'emailSetor' => $this->sEmailSetor->getNomenclatura(),
                        'emailCoordenacao' => $this->sEmailCoordenacao->getNomenclatura(),
                        'emailDepartamento' => $this->sEmailDepartamento->getNomenclatura(),
                        'emailSecretaria' => $this->sEmailSecretaria->getNomenclatura(),
                        'cargo' => $this->sCargo->getNomenclatura(),
                        'nivelPermissao' => $this->sPermissao->getNivel(),
                        'permissao' => $this->sPermissao->getNomenclatura()
                    ];
                
                //aprovado em todas as validações
                $this->setValidador(true);
               
                //QA - início da área de testes
                /* verificar o que tem no objeto

                  echo "<pre>";
                  var_dump($_SESSION['credencial']);
                  echo "</pre>";

                  // */
                //QA - fim da área de testes
            }
        }
    }
    public function acessar($pagina) {
        if($pagina == 'tAcessar.php'){
            header('Location: ./tPainel.php');
        }
    }
    
    public function getIdUsuario(): int {
        return $this->idUsuario;
    }

    public function getIdEmail(): int {
        return $this->idEmail;
    }

    public function getValidador(): bool {
        return $this->validador;
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

    public function getSSetor(): sSetor {
        return $this->sSetor;
    }

    public function getSCoordenacao(): sCoordenacao {
        return $this->sCoordenacao;
    }

    public function getSDepartamento(): sDepartamento {
        return $this->sDepartamento;
    }

    public function getSSecretaria(): sSecretaria {
        return $this->sSecretaria;
    }

    public function getSTelefoneUsuario(): sTelefone {
        return $this->sTelefoneUsuario;
    }

    public function getSTelefoneSetor(): sTelefone {
        return $this->sTelefoneSetor;
    }

    public function getSTelefoneCoordenacao(): sTelefone {
        return $this->sTelefoneCoordenacao;
    }

    public function getSTelefoneDepartamento(): sTelefone {
        return $this->sTelefoneDepartamento;
    }

    public function getSTelefoneSecretaria(): sTelefone {
        return $this->sTelefoneSecretaria;
    }

    public function getSEmailUsuario(): sEmail {
        return $this->sEmailUsuario;
    }

    public function getSEmailSetor(): sEmail {
        return $this->sEmailSetor;
    }

    public function getSEmailCoordenacao(): sEmail {
        return $this->sEmailCoordenacao;
    }

    public function getSEmailDepartamento(): sEmail {
        return $this->sEmailDepartamento;
    }

    public function getSEmailSecretaria(): sEmail {
        return $this->sEmailSecretaria;
    }

    public function getSCargo(): sCargo {
        return $this->sCargo;
    }

    public function getSPermissao(): sPermissao {
        return $this->sPermissao;
    }

    public function getMConexao(): mConexao {
        return $this->mConexao;
    }

    public function getSNotificacao(): sNotificacao {
        return $this->sNotificacao;
    }

    public function setIdUsuario(int $idUsuario): void {
        $this->idUsuario = $idUsuario;
    }

    public function setIdEmail(int $idEmail): void {
        $this->idEmail = $idEmail;
    }

    public function setValidador(bool $validador): void {
        $this->validador = $validador;
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

    public function setSSetor(sSetor $sSetor): void {
        $this->sSetor = $sSetor;
    }

    public function setSCoordenacao(sCoordenacao $sCoordenacao): void {
        $this->sCoordenacao = $sCoordenacao;
    }

    public function setSDepartamento(sDepartamento $sDepartamento): void {
        $this->sDepartamento = $sDepartamento;
    }

    public function setSSecretaria(sSecretaria $sSecretaria): void {
        $this->sSecretaria = $sSecretaria;
    }

    public function setSTelefoneUsuario(sTelefone $sTelefoneUsuario): void {
        $this->sTelefoneUsuario = $sTelefoneUsuario;
    }

    public function setSTelefoneSetor(sTelefone $sTelefoneSetor): void {
        $this->sTelefoneSetor = $sTelefoneSetor;
    }

    public function setSTelefoneCoordenacao(sTelefone $sTelefoneCoordenacao): void {
        $this->sTelefoneCoordenacao = $sTelefoneCoordenacao;
    }

    public function setSTelefoneDepartamento(sTelefone $sTelefoneDepartamento): void {
        $this->sTelefoneDepartamento = $sTelefoneDepartamento;
    }

    public function setSTelefoneSecretaria(sTelefone $sTelefoneSecretaria): void {
        $this->sTelefoneSecretaria = $sTelefoneSecretaria;
    }

    public function setSEmailUsuario(sEmail $sEmailUsuario): void {
        $this->sEmailUsuario = $sEmailUsuario;
    }

    public function setSEmailSetor(sEmail $sEmailSetor): void {
        $this->sEmailSetor = $sEmailSetor;
    }

    public function setSEmailCoordenacao(sEmail $sEmailCoordenacao): void {
        $this->sEmailCoordenacao = $sEmailCoordenacao;
    }

    public function setSEmailDepartamento(sEmail $sEmailDepartamento): void {
        $this->sEmailDepartamento = $sEmailDepartamento;
    }

    public function setSEmailSecretaria(sEmail $sEmailSecretaria): void {
        $this->sEmailSecretaria = $sEmailSecretaria;
    }

    public function setSCargo(sCargo $sCargo): void {
        $this->sCargo = $sCargo;
    }

    public function setSPermissao(sPermissao $sPermissao): void {
        $this->sPermissao = $sPermissao;
    }

    public function setMConexao(mConexao $mConexao): void {
        $this->mConexao = $mConexao;
    }

    public function setSNotificacao(sNotificacao $sNotificacao): void {
        $this->sNotificacao = $sNotificacao;
    }


}
