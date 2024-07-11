<?php

namespace App\sistema\acesso;

class sTratamentoDados {

    private string $nomenclatura;

    public function __construct(string $nomenclatura) {
        $this->nomenclatura = $nomenclatura;
    }

    public function tratarNomenclatura() {
        $minuscula = mb_strtolower($this->getNomenclatura());
        $palavras = explode(" ", $minuscula);

        $palavrasTratadas = '';
        $j = count($palavras) - 1;
        for ($i = 0; $i < count($palavras); $i++) {
            if (strlen($palavras[$i]) < 3) {
                if($j == 0){
                    $palavrasTratadas .= $palavras[$i];
                }else{
                    $palavrasTratadas .= $palavras[$i] . ' ';
                }
                
            } else {
                if ($j == $i) {
                    $palavrasTratadas .= ucfirst($palavras[$i]);
                } else {
                    $palavrasTratadas .= ucfirst($palavras[$i]) . ' ';
                }
            }
        }
        return $palavrasTratadas;
    }
    
    public function getNomenclatura(): string {
        return $this->nomenclatura;
    }

    public function setNomenclatura(string $nomenclatura): void {
        $this->nomenclatura = $nomenclatura;
    }
}
