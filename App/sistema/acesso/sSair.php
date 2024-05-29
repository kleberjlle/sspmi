<?php
namespace App\sistema\acesso;

use App\sistema\acesso\{sConfiguracao};

class sSair{
    private string $destino;
    public sConfiguracao $sConfiguracao;
    
    public function __construct() {
        $this->destino = 'tAcessar.php';
        session_start();
        session_destroy();
        header("Location: {$this->sConfiguracao->getDiretorioPrincipal()}.tAcessar.php");        
    }
}
?>