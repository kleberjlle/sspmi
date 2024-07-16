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
    
    public function getDados(): string {
        return $this->dados;
    }

    public function setDados(string $dados): void {
        $this->dados = $dados;
    }
}
