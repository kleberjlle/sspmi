<?php
namespace App\sistema\acesso;

use App\sistema\acesso\{sConfiguracao};

class sNotificacao{
    private $letra;
    private $numero;
    private $codigo;
    private $tipo;
    private $titulo;
    private $mensagem;
    public sConfiguracao $sConfiguracao;


    public function __construct($codigo) {
        $this->codigo = $codigo;
        $this->gerarNotificacao();
    }
    
    protected function gerarNotificacao() {
        //separa o tipo de notificação e seu índice
        $this->letra = substr($this->codigo, 0, 1);
        $this->numero = substr($this->codigo, 1);
        
        //se a for uma notificação de Alerta, execute o seguinte método
        if($this->letra == 'A'){
            $this->tipoAtencao();
        }else if($this->letra == 'E'){
            $this->tipoErro();
        }else if($this->letra == 'S'){
            $this->tipoSucesso();
        }else if($this->letra == 'I'){
            $this->tipoInformacao();
        }else{
            
        }        
    }
    
    private function tipoAtencao() {
        $this->setTipo('warning');
        $this->setTitulo('Atenção!');
        $this->setSConfiguracao(new sConfiguracao());
        
        switch ($this->getNumero()) {
            case '1':               
                $this->setMensagem('O e-mail informado não está registrado em nosso sistema.');
                break;
            case '2':
                $this->setMensagem('O e-mail informado não é um endereço de e-mail válido.');
                break;
            case '3':
                $this->setMensagem('E-mail já registrado, favor clique na opção <a href="tRecuperarAcesso.php">esqueci minha senha</a>.');
                break;
            case '4':
                $this->setMensagem('A senha deve ter de '.$this->sConfiguracao->getCaracterMinimo().' à '.$this->sConfiguracao->getCaracterMaximo().' caracteres.');
                break;
            case '5':
                $this->setMensagem('A senha deve possuir letras e números');
                break;
            case '6':
                $this->setMensagem('Senha incorreta, tente novamente.');
                break;
            default:
                $this->setTipo('danger');
                $this->setTitulo('Erro!');
                $this->setMensagem('Código: '.$this->getCodigo().' não localizado, favor contatar o desenvolvedor.');
                break;
        }
    }
    
    private function tipoErro() {
        $this->setTipo('danger');
        $this->setTitulo('Erro!');
        
        switch ($this->getNumero()) {
            case '1':               
                $this->setMensagem('Não esperávamos isso, contate o administrador do sistema e informe este erro ('.$this->getCodigo().').');
                break;
            case '2':
                $this->setMensagem('A página não está configurada, contate o administrador do sistema e informe este erro ('.$this->getCodigo().').');
                break;
            case '3':
                $this->setMensagem('Um parâmetro do método CRUD foi definido incorretamente, contate o administrador do sistema e informe este erro ('.$this->getCodigo().').');
                break;
            default:
                $this->setTipo('danger');
                $this->setTitulo('Erro!');
                $this->setMensagem('Código: '.$this->getCodigo().' não localizado, favor contatar o desenvolvedor.');
                break;
        }
    }
    
    private function tipoSucesso() {
        $this->setTipo('success');
        $this->setTitulo('Sucesso!');
        
        switch ($this->getNumero()) {
            case '1':               
                $this->setMensagem('Alteração realizada.');
                break;
            case '2':
                $this->setMensagem('Verifique seu e-mail para finalizar a recuperação de acesso.');
                break;
            case '3':
                $this->setMensagem('Registro realizado, você receberá um e-mail com a liberação do Departamento de Tecnologia da Informação.');
                break;
            case '4':
                $this->setMensagem('Registro realizado com sucesso.');
                break;
            case '5':
                $this->setMensagem('Suporte finalizado com sucesso.');
                break;
            default:
                $this->setTipo('danger');
                $this->setTitulo('Erro!');
                $this->setMensagem('Código: '.$this->getCodigo().' não localizado, favor contatar o desenvolvedor.');
                break;
        }
    } 
    
    private function tipoInformacao() {
        $this->setTipo('success');
        $this->setTitulo('Sucesso!');
        
        switch ($this->getNumero()) {
            default:
                $this->setTipo('danger');
                $this->setTitulo('Erro!');
                $this->setMensagem('Código: '.$this->getCodigo().' não localizado, favor contatar o desenvolvedor.');
                break;
        }
    }
    
    public function getLetra() {
        return $this->letra;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getMensagem() {
        return $this->mensagem;
    }

    public function getSConfiguracao(): sConfiguracao {
        return $this->sConfiguracao;
    }

    public function setLetra($letra): void {
        $this->letra = $letra;
    }

    public function setNumero($numero): void {
        $this->numero = $numero;
    }

    public function setCodigo($codigo): void {
        $this->codigo = $codigo;
    }

    public function setTipo($tipo): void {
        $this->tipo = $tipo;
    }

    public function setTitulo($titulo): void {
        $this->titulo = $titulo;
    }

    public function setMensagem($mensagem): void {
        $this->mensagem = $mensagem;
    }

    public function setSConfiguracao(sConfiguracao $sConfiguracao): void {
        $this->sConfiguracao = $sConfiguracao;
    }


}
?>