<?php

namespace App\sistema\acesso;

use App\modelo\{
    mConexao
};
use App\sistema\acesso\{
    sNotificacao
};

class sTelefone {

    private string $nomeCampo;
    private string $valorCampo;
    private bool $validador;
    private int $idTelefone;
    private int $idLocal;
    private string $numero;
    private bool $whatsApp;
    private string $nomenclaturaLocal;
    public mConexao $mConexao;
    public sNotificacao $sNotificacao;

    public function __construct(int $idTelefone, int $idLocal, string $nomenclaturaLocal) {
        $this->idTelefone = $idTelefone;
        $this->idLocal = $idLocal;
        $this->nomenclaturaLocal = $nomenclaturaLocal;
        $this->validador = false;
    }

    public function consultar($pagina) {
        $this->setMConexao(new mConexao());
        if ($pagina == 'tAcessar.php' ||
            $pagina == 'tMenu1_2.php' ||
            $pagina == 'tMenu1_3.php') {
            if ($this->getNomenclaturaLocal() == 'usuario') {
                $dados = [
                    'comando' => 'SELECT',
                    'busca' => '*',
                    'tabelas' => 'telefone',
                    'camposCondicionados' => 'idtelefone',
                    'valoresCondicionados' => $this->getIdTelefone(),
                    'camposOrdenados' => null, //caso não tenha, colocar como null
                    'ordem' => null
                ];
            } else if ($this->getNomenclaturaLocal() == 'setor' ||
                    $this->getNomenclaturaLocal() == 'coordenacao' ||
                    $this->getNomenclaturaLocal() == 'departamento' ||
                    $this->getNomenclaturaLocal() == 'secretaria') {
                $dados = [
                    'comando' => 'SELECT',
                    'busca' => ['telefone.numero', 'telefone.whatsApp'],
                    'tabelas' => ['telefone', 'telefone_has_' . $this->getNomenclaturaLocal()],
                    'camposCondicionados' => '',
                    'valoresCondicionados' => ['telefone.idtelefone', 'telefone_has_' . $this->getNomenclaturaLocal() . '.telefone_idtelefone'],
                    'camposOrdenados' => null, //caso não tenha, colocar como null
                    'ordem' => null
                ];
            }

            $this->mConexao->CRUD($dados);
            $this->setValidador($this->mConexao->getValidador());

            foreach ($this->mConexao->getRetorno() as $linha) {
                $this->setNumero($linha['numero']);
                $this->setWhatsApp($linha['whatsApp']);
            }
        }
    }

    public function tratarTelefone($telefone) {
        if (!ctype_alnum($telefone)) {
            $telefoneTratado = str_replace(['(', ')', '-', '_', ' '], '', $telefone);
        } else {
            $telefoneTratado = str_replace(" ", "", $telefone);
            //se for número de telefone fixo
            if (strlen($telefoneTratado) == 10) {
                $mascara = "(##) ####-####";                
            } else {
                //se for número de telefone celular
                $mascara = "(##) # ####-####";
            }
            for ($i = 0; $i < strlen($telefoneTratado); $i++) {
                $mascara[strpos($mascara, "#")] = $telefoneTratado[$i];
            }
            $telefoneTratado = $mascara;
        }

        return $telefoneTratado;
    }

    public function verificarTelefone($telefone) {
        if (strlen($telefone) < 10 ||
                strlen($telefone) > 11) {
            $this->setSNotificacao(new sNotificacao('A11'));
            $this->setValidador(false);
        } else {
            $this->setValidador(true);
        }
    }

    public function alterar($pagina) {
        //cria conexão para inserir os dados no BD
        $this->setMConexao(new mConexao());

        if ($pagina == 'tMenu1_1_1.php') {
            $dados = [
                'comando' => 'UPDATE',
                'tabela' => 'telefone',
                'camposAtualizar' => $this->getNomeCampo(),
                'valoresAtualizar' => $this->getValorCampo(),
                'camposCondicionados' => 'idtelefone',
                'valoresCondicionados' => $this->getIdTelefone(),
            ];

            $this->mConexao->CRUD($dados);
            //UPDATE table_name SET column1=value, column2=value2 WHERE some_column=some_value 
            if ($this->mConexao->getValidador()) {
                $this->setValidador(true);
                $this->setSNotificacao(new sNotificacao('S1'));
            }
        }
    }

    public function getNomeCampo(): string {
        return $this->nomeCampo;
    }

    public function getValorCampo(): string {
        return $this->valorCampo;
    }

    public function getValidador(): bool {
        return $this->validador;
    }

    public function getIdTelefone(): int {
        return $this->idTelefone;
    }

    public function getIdLocal(): int {
        return $this->idLocal;
    }

    public function getNumero(): string {
        return $this->numero;
    }

    public function getWhatsApp(): bool {
        return $this->whatsApp;
    }

    public function getNomenclaturaLocal(): string {
        return $this->nomenclaturaLocal;
    }

    public function getMConexao(): mConexao {
        return $this->mConexao;
    }

    public function getSNotificacao(): sNotificacao {
        return $this->sNotificacao;
    }

    public function setNomeCampo(string $nomeCampo): void {
        $this->nomeCampo = $nomeCampo;
    }

    public function setValorCampo(string $valorCampo): void {
        $this->valorCampo = $valorCampo;
    }

    public function setValidador(bool $validador): void {
        $this->validador = $validador;
    }

    public function setIdTelefone(int $idTelefone): void {
        $this->idTelefone = $idTelefone;
    }

    public function setIdLocal(int $idLocal): void {
        $this->idLocal = $idLocal;
    }

    public function setNumero(string $numero): void {
        $this->numero = $numero;
    }

    public function setWhatsApp(bool $whatsApp): void {
        $this->whatsApp = $whatsApp;
    }

    public function setNomenclaturaLocal(string $nomenclaturaLocal): void {
        $this->nomenclaturaLocal = $nomenclaturaLocal;
    }

    public function setMConexao(mConexao $mConexao): void {
        $this->mConexao = $mConexao;
    }

    public function setSNotificacao(sNotificacao $sNotificacao): void {
        $this->sNotificacao = $sNotificacao;
    }

}
