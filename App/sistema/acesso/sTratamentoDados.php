<?php

namespace App\sistema\acesso;

class sTratamentoDados {

    private string $dados;

    public function __construct(string $dados) {
        $this->dados = $dados;
    }

    public function tratarNomenclatura() {
        //converte tudo para minúscula
        $minuscula = mb_strtolower($this->getDados());
        $nomenclatura = explode(" ", $minuscula);

        $nomenclaturaTratada = '';
        $j = count($nomenclatura) - 1;
        for ($i = 0; $i < count($nomenclatura); $i++) {
            if (strlen($nomenclatura[$i]) < 3) {
                if($j == 0){
                    $nomenclaturaTratada .= $nomenclatura[$i];
                }else{
                    $nomenclaturaTratada .= $nomenclatura[$i] . ' ';
                }
                
            } else {
                if ($j == $i) {
                    $nomenclaturaTratada .= ucfirst($nomenclatura[$i]);
                } else {
                    $nomenclaturaTratada .= ucfirst($nomenclatura[$i]) . ' ';
                }
            }
        }
        return $nomenclaturaTratada;
    }
    
    public function tratarPatrimonio() {
        //converte todas para maiúsculas
        $maiuscula = mb_strtoupper($this->getDados());
        if(strlen($maiuscula) < 1){
            $patrimonioTratado = 'Indefinido';
        }else{
            $patrimonioTratado = $maiuscula;
        }
        return $patrimonioTratado;
    }
    
    public function tratarData() {
        $dataTratada = date("d/m/Y H:i:s", strtotime(str_replace('-', '/', $data)));

        return $dataTratada;
    }
    
    public function tratarTelefone() {
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
    
    public function tratarEtiquetaDeServico() {
        return $this->tratarPatrimonio();
    }
    
    public function tratarNumeroDeSerie() {
        return $this->tratarPatrimonio();
    }
    
    public function tratarEmail() {
        if (filter_var($this->getDados(), FILTER_VALIDATE_EMAIL)) {
            return true;
        }else{
            return false;
        }
    }
    
    public function getDados(): string {
        return $this->dados;
    }

    public function setDados(string $dados): void {
        $this->dados = $dados;
    }
}
