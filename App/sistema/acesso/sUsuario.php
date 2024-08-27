<?php

namespace App\sistema\acesso;

use App\modelo\{
    mConexao
};
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
    private string $email;
    private string $telefone;
    private int $whatsApp;
    private int $idSecretaria;
    private int $idDepartamento;
    private int $idCoordenacao;
    private int $idSetor;
    private int $idCargo;
    private int $idPermissao;
    private bool $validador;
    private string $nome;
    private string $sobrenome;
    private string $sexo;
    private string $imagem;
    private bool $situacao; //alterar no bd
    private string $nomeCampo;
    private mixed $valorCampo;
    private int $examinador;
    public sSetor $sSetor;
    public sCoordenacao $sCoordenacao;
    public sDepartamento $sDepartamento;
    public sSecretaria $sSecretaria;
    public sTelefone $sTelefoneUsuario;
    public sTelefone $sTelefoneSetor;
    public sTelefone $sTelefoneCoordenacao;
    public sTelefone $sTelefoneDepartamento;
    public sTelefone $sTelefoneSecretaria;
    public sEmail $sEmailUsuario;
    public sEmail $sEmailSetor;
    public sEmail $sEmailCoordenacao;
    public sEmail $sEmailDepartamento;
    public sEmail $sEmailSecretaria;
    public sCargo $sCargo;
    public sPermissao $sPermissao;
    public mConexao $mConexao;
    public sNotificacao $sNotificacao;

    public function __construct() {
        $this->validador = false;
    }

    public function consultar($pagina) {
        //busca os dados do usuário no BD
        $this->setMConexao(new mConexao());

        //tomada de decisão de acordo com a página
        if ($pagina == 'tAcessar.php') {
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'usuario',
                'camposCondicionados' => 'email_idemail',
                'valoresCondicionados' => $this->getIdEmail(),
                'camposOrdenados' => null, //caso não tenha, colocar como null
                'ordem' => null
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

            //trataemnto de dados
            if (!$situacao) {
                //notifica o usuário sobre a inatividade do perfil
                $this->setSNotificacao(new sNotificacao('A7'));
                $this->setValidador(false);
            } else {
                //tratamento dos dados buscados
                $sexo == 'M' ? $sexo = 'Masculino' : $sexo = 'Feminino';
                $situacao == true ? $situacao = 'Ativo' : $situacao = 'Inativo';

                if (!is_null($idSetor)) {
                    $this->setSSetor(new sSetor($idSetor));
                    $this->sSetor->consultar($pagina);
                    $nomenclaturaSetor = $this->sSetor->getNomenclatura();
                } else {
                    $nomenclaturaSetor = '--';
                }

                if (!is_null($idCoordenacao)) {
                    $this->setSCoordenacao(new sCoordenacao($idCoordenacao));
                    $this->sCoordenacao->consultar($pagina);
                    $nomenclaturaCoordenacao = $this->sCoordenacao->getNomenclatura();
                } else {
                    $nomenclaturaCoordenacao = '--';
                }

                if (!is_null($idDepartamento)) {
                    $this->setSDepartamento(new sDepartamento($idDepartamento));
                    $this->sDepartamento->consultar($pagina);
                    $nomenclaturaDepartamento = $this->sDepartamento->getNomenclatura();
                } else {
                    $nomenclaturaDepartamento = '--';
                }

                $this->setSSecretaria(new sSecretaria($idSecretaria));
                $this->sSecretaria->consultar($pagina);

                if (!is_null($idTelefoneUsuario)) {
                    $this->setSTelefoneUsuario(new sTelefone($idTelefoneUsuario, $idUsuario, 'usuario'));
                    $this->sTelefoneUsuario->consultar($pagina);
                    $telefoneUsuario = $this->sTelefoneUsuario->getNumero();
                    $whatsAppUsuario = $this->sTelefoneUsuario->getWhatsApp();
                } else {
                    $telefoneUsuario = '--';
                    $whatsAppUsuario = false;
                }

                if (!is_null($idSetor)) {
                    $this->setSTelefoneSetor(new sTelefone(0, $this->sSetor->getIdSetor(), 'setor'));
                    $this->sTelefoneSetor->consultar($pagina);
                    if ($this->sTelefoneSetor->getValidador()) {
                        $telefoneSetor = $this->sTelefoneSetor->getNumero();
                        $whatsAppSetor = $this->sTelefoneSetor->getWhatsApp();
                    } else {
                        $telefoneSetor = '--';
                        $whatsAppSetor = false;
                    }
                } else {
                    $telefoneSetor = '--';
                    $whatsAppSetor = false;
                }

                if (!is_null($idCoordenacao)) {
                    $this->setSTelefoneCoordenacao(new sTelefone(0, $this->sCoordenacao->getIdCoordenacao(), 'coordenacao'));
                    $this->sTelefoneCoordenacao->consultar($pagina);
                    if ($this->sTelefoneCoordenacao->getValidador()) {
                        $telefoneCoordenacao = $this->sTelefoneCoordenacao->getNumero();
                        $whatsAppCoordenacao = $this->sTelefoneCoordenacao->getWhatsApp();
                    } else {
                        $telefoneCoordenacao = '--';
                        $whatsAppCoordenacao = false;
                    }
                } else {
                    $telefoneCoordenacao = '--';
                    $whatsAppCoordenacao = false;
                }

                if (!is_null($idDepartamento)) {
                    $this->setSTelefoneDepartamento(new sTelefone(0, $this->sDepartamento->getIdDepartamento(), 'departamento'));
                    $this->sTelefoneDepartamento->consultar($pagina);
                    if ($this->sTelefoneDepartamento->getValidador()) {
                        $telefoneDepartamento = $this->sTelefoneDepartamento->getNumero();
                        $whatsAppDepartamento = $this->sTelefoneDepartamento->getWhatsApp();
                    } else {
                        $telefoneDepartamento = '--';
                        $whatsAppDepartamento = false;
                    }
                } else {
                    $telefoneDepartamento = '--';
                    $whatsAppDepartamento = false;
                }

                $this->setSTelefoneSecretaria(new sTelefone(0, $this->sSecretaria->getIdSecretaria(), 'secretaria'));
                $this->sTelefoneSecretaria->consultar($pagina);
                if ($this->sTelefoneSecretaria->getValidador()) {
                    $telefoneSecretaria = $this->sTelefoneSecretaria->getNumero();
                    $whatsAppSecretaria = $this->sTelefoneSecretaria->getWhatsApp();
                } else {
                    $telefoneSecretaria = '--';
                    $whatsAppSecretaria = false;
                }

                $this->setSEmailUsuario(new sEmail($idEmail, 'email'));
                $this->sEmailUsuario->consultar($pagina);

                if (!is_null($idSetor)) {
                    $this->setSEmailSetor(new sEmail($idEmail, 'setor'));
                    $this->sEmailSetor->consultar($pagina);
                    if ($this->sEmailSetor->getValidador()) {
                        $emailSetor = $this->sEmailSetor->getNomenclatura();
                    } else {
                        $emailSetor = '--';
                    }
                } else {
                    $emailSetor = '--';
                }

                if (!is_null($idCoordenacao)) {
                    $this->setSEmailCoordenacao(new sEmail($idEmail, 'coordenacao'));
                    $this->sEmailCoordenacao->consultar($pagina);
                    if ($this->sEmailCoordenacao->getValidador()) {
                        $emailCoordenacao = $this->sEmailCoordenacao->getNomenclatura();
                    } else {
                        $emailCoordenacao = '--';
                    }
                } else {
                    $emailCoordenacao = '--';
                }

                if (!is_null($idDepartamento)) {
                    $this->setSEmailDepartamento(new sEmail($idEmail, 'departamento'));
                    $this->sEmailDepartamento->consultar($pagina);
                    if ($this->sEmailDepartamento->getValidador()) {
                        $emailDepartamento = $this->sEmailDepartamento->getNomenclatura();
                    } else {
                        $emailDepartamento = '--';
                    }
                } else {
                    $emailDepartamento = '--';
                }

                $this->setSEmailSecretaria(new sEmail($idEmail, 'secretaria'));
                $this->sEmailSecretaria->consultar($pagina);
                if($this->sEmailSecretaria->getValidador()){
                    $emailSecretaria = $this->sEmailSecretaria->getNomenclatura();
                }else{
                    $emailSecretaria = '--';
                }

                $this->setSCargo(new sCargo($idCargo));
                $this->sCargo->consultar($pagina);

                $this->setSPermissao(new sPermissao($idPermissao));
                $this->sPermissao->consultar($pagina);

                if(!isset($_SESSION)){
                    session_start();
                }
                
                $_SESSION['credencial'] = [
                    'idUsuario' => $idUsuario,
                    'nome' => $nome,
                    'sobrenome' => $sobrenome,
                    'sexo' => $sexo,
                    'imagem' => $imagem,
                    'situacao' => $situacao,
                    'idSetor' => $idSetor,
                    'setor' => $nomenclaturaSetor,
                    'idCoordenacao' => $idCoordenacao,
                    'coordenacao' => $nomenclaturaCoordenacao,
                    'idDepartamento' => $idDepartamento,
                    'departamento' => $nomenclaturaDepartamento,
                    'idSecretaria' => $idSecretaria,
                    'secretaria' => $this->sSecretaria->getNomenclatura(),
                    'idTelefoneUsuario' => $idTelefoneUsuario,
                    'telefoneUsuario' => $telefoneUsuario,
                    'whatsAppUsuario' => $whatsAppUsuario,
                    'telefoneSetor' => $telefoneSetor,
                    'whatsAppSetor' => $whatsAppSetor,
                    'telefoneCoordenacao' => $telefoneCoordenacao,
                    'whatsAppCoordenacao' => $whatsAppCoordenacao,
                    'telefoneDepartamento' => $telefoneDepartamento,
                    'whatsAppDepartamento' => $whatsAppDepartamento,
                    'telefoneSecretaria' => $telefoneSecretaria,
                    'whatsAppSecretaria' => $whatsAppSecretaria,
                    'idEmailUsuario' => $idEmail,
                    'emailUsuario' => $this->sEmailUsuario->getNomenclatura(),
                    'emailSetor' => $emailSetor,
                    'emailCoordenacao' => $emailCoordenacao,
                    'emailDepartamento' => $emailDepartamento,
                    'emailSecretaria' => $emailSecretaria,
                    'idCargo' => $idCargo,
                    'cargo' => $this->sCargo->getNomenclatura(),
                    'nivelPermissao' => $this->sPermissao->getNivel(),
                    'idPermissao' => $idPermissao,
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

        if ($pagina == 'tMenu1_2.php') {
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'usuario',
                'camposCondicionados' => '',
                'valoresCondicionados' => '',
                'camposOrdenados' => 'idusuario', //caso não tenha, colocar como null
                'ordem' => 'ASC'
            ];
            $this->mConexao->CRUD($dados);

            $this->setValidador($this->mConexao->getValidador());
        }

        if ($pagina == 'tMenu1_2_1.php' ||
            $pagina == 'tMenu2_2.php' ||
            $pagina == 'tMenu2_2_1.php') {
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'usuario',
                'camposCondicionados' => $this->getNomeCampo(),
                'valoresCondicionados' => $this->getValorCampo(),
                'camposOrdenados' => null, //caso não tenha, colocar como null
                'ordem' => null
            ];
            $this->mConexao->CRUD($dados);
            $this->setValidador($this->mConexao->getValidador());

            foreach ($this->mConexao->getRetorno() as $linha) {
                $this->setNome($linha['nome']);
                $this->setSobrenome($linha['sobrenome']);
                $this->setSexo($linha['sexo']);
                $this->setImagem($linha['imagem']);
                $this->setSituacao($linha['situacao']);
                if (strlen($linha['setor_idsetor']) > 0) {
                    $this->setIdSetor($linha['setor_idsetor']);
                } else {
                    $this->setIdSetor(0);
                }
                if (strlen($linha['coordenacao_idcoordenacao']) > 0) {
                    $this->setIdCoordenacao($linha['coordenacao_idcoordenacao']);
                } else {
                    $this->setIdCoordenacao(0);
                }
                if (strlen($linha['departamento_iddepartamento']) > 0) {
                    $this->setIdDepartamento($linha['departamento_iddepartamento']);
                } else {
                    $this->setIdDepartamento(0);
                }
                $this->setIdSecretaria($linha['secretaria_idsecretaria']);

                if (!empty($linha['telefone_idtelefone'])) {
                    $this->setTelefone($linha['telefone_idtelefone']);
                } else {
                    $this->setTelefone(0);
                }

                $this->setIdEmail($linha['email_idemail']);

                $this->setIdCargo($linha['cargo_idcargo']);

                $this->setIdPermissao($linha['permissao_idpermissao']);
            }
        }

        if ($pagina == 'tMenu1_3.php') {
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'solicitacao',
                'camposCondicionados' => '',
                'valoresCondicionados' => '',
                'camposOrdenados' => null, //caso não tenha, colocar como null
                'ordem' => null
            ];
            $this->mConexao->CRUD($dados);

            $this->setValidador($this->mConexao->getValidador());
        }

        if ($pagina == 'tMenu1_3-examinador.php') {
            $dados = [
                'comando' => 'SELECT',
                'busca' => '*',
                'tabelas' => 'usuario',
                'camposCondicionados' => 'idusuario',
                'valoresCondicionados' => $this->getIdUsuario(),
                'camposOrdenados' => null, //caso não tenha, colocar como null
                'ordem' => null
            ];

            $this->mConexao->CRUD($dados);
            foreach ($this->mConexao->getRetorno() as $linha) {
                $this->setNome($linha['nome']);
                $this->setSobrenome($linha['sobrenome']);
            }

            $this->setValidador($this->mConexao->getValidador());
        }
    }

    public function acessar($pagina) {
        if ($pagina == 'tAcessar.php') {
            header('Location: ./tPainel.php');
        }
    }

    public function verificarNome($nome) {
        //verifica se tem letras e espaço
        $caracterValido = !!preg_match('|^[\pL\s]+$|u', $nome);
        if (mb_strlen($nome) < 2 ||
                mb_strlen($nome) > 20) {
            $this->setValidador(false);
            $this->setSNotificacao(new sNotificacao('A8'));
        } else if (!$caracterValido) {
            $this->setValidador(false);
            $this->setSNotificacao(new sNotificacao('A9'));
        } else {
            $this->setValidador(true);
        }
    }

    public function verificarSobrenome($sobrenome) {
        //verifica se tem letras e espaço
        $caracterValido = !!preg_match('|^[\pL\s]+$|u', $sobrenome);
        if (mb_strlen($sobrenome) < 2 ||
                mb_strlen($sobrenome) > 100) {
            $this->setValidador(false);
            $this->setSNotificacao(new sNotificacao('A8'));
        } else if (!$caracterValido) {
            $this->setValidador(false);
            $this->setSNotificacao(new sNotificacao('A9'));
        } else {
            $this->setValidador(true);
        }
    }

    public function alterar($pagina) {
        //cria conexão para inserir os dados no BD
        $this->setMConexao(new mConexao());

        if ($pagina == 'tMenu1_1_1.php' ||
            $pagina == 'tMenu1_2_1.php') {
            $dados = [
                'comando' => 'UPDATE',
                'tabela' => 'usuario',
                'camposAtualizar' => $this->getNomeCampo(),
                'valoresAtualizar' => $this->getValorCampo(),
                'camposCondicionados' => 'idusuario',
                'valoresCondicionados' => $this->getIdUsuario()
            ];
            $this->mConexao->CRUD($dados);
            //UPDATE table_name SET column1=value, column2=value2 WHERE some_column=some_value 
            if ($this->mConexao->getValidador()) {
                $this->setValidador(true);
                $this->setSNotificacao(new sNotificacao('S1'));
            }
        }
    }

    public function inserir($pagina) {
        //cria conexão para inserir os dados no BD
        $this->setMConexao(new mConexao());

        if ($pagina == 'sSolicitarAcesso.php') {
            $dados = [
                'comando' => 'INSERT INTO',
                'tabela' => 'solicitacao',
                'camposInsercao' => [
                    'nome',
                    'sobrenome',
                    'sexo',
                    'telefone',
                    'whatsApp',
                    'email',
                    'secretaria_idsecretaria',
                    'departamento_iddepartamento',
                    'coordenacao_idcoordenacao',
                    'setor_idsetor',
                    'cargo_idcargo'
                ],
                'valoresInsercao' => [
                    $this->getNome(),
                    $this->getSobrenome(),
                    $this->getSexo(),
                    $this->getTelefone(),
                    $this->getWhatsApp(),
                    $this->getEmail(),
                    $this->getIdSecretaria(),
                    $this->getIdDepartamento(),
                    $this->getIdCoordenacao(),
                    $this->getIdSetor(),
                    $this->getIdCargo()
                ]
            ];
            $this->mConexao->CRUD($dados);
            //INSERT INTO table_name (column1, column2, column3, ...) VALUES (value1, value2, value3, ...);
            if ($this->mConexao->getValidador()) {
                $this->setValidador(true);
                $this->setSNotificacao(new sNotificacao('S3'));
            }
        }
    }

    public function tratarData($data) {
        $dataTratada = date("d/m/Y H:i:s", strtotime(str_replace('-', '/', $data)));

        return $dataTratada;
    }

    public function getIdUsuario(): int {
        return $this->idUsuario;
    }

    public function getIdEmail(): int {
        return $this->idEmail;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getTelefone(): string {
        return $this->telefone;
    }

    public function getWhatsApp(): int {
        return $this->whatsApp;
    }

    public function getIdSecretaria(): int {
        return $this->idSecretaria;
    }

    public function getIdDepartamento(): int {
        return $this->idDepartamento;
    }

    public function getIdCoordenacao(): int {
        return $this->idCoordenacao;
    }

    public function getIdSetor(): int {
        return $this->idSetor;
    }

    public function getIdCargo(): int {
        return $this->idCargo;
    }

    public function getIdPermissao(): int {
        return $this->idPermissao;
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

    public function getNomeCampo(): string {
        return $this->nomeCampo;
    }

    public function getValorCampo(): mixed {
        return $this->valorCampo;
    }

    public function getExaminador(): int {
        return $this->examinador;
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

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setTelefone(string $telefone): void {
        $this->telefone = $telefone;
    }

    public function setWhatsApp(int $whatsApp): void {
        $this->whatsApp = $whatsApp;
    }

    public function setIdSecretaria(int $idSecretaria): void {
        $this->idSecretaria = $idSecretaria;
    }

    public function setIdDepartamento(int $idDepartamento): void {
        $this->idDepartamento = $idDepartamento;
    }

    public function setIdCoordenacao(int $idCoordenacao): void {
        $this->idCoordenacao = $idCoordenacao;
    }

    public function setIdSetor(int $idSetor): void {
        $this->idSetor = $idSetor;
    }

    public function setIdCargo(int $idCargo): void {
        $this->idCargo = $idCargo;
    }

    public function setIdPermissao(int $idPermissao): void {
        $this->idPermissao = $idPermissao;
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

    public function setNomeCampo(string $nomeCampo): void {
        $this->nomeCampo = $nomeCampo;
    }

    public function setValorCampo(mixed $valorCampo): void {
        $this->valorCampo = $valorCampo;
    }

    public function setExaminador(int $examinador): void {
        $this->examinador = $examinador;
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
