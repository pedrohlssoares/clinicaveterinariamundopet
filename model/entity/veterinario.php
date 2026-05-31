<?php

class veterinario {
    private $idveterinario;
    private $crmv;
    private $funcionarioveterinariofk;
    private $descricao;
    private $nome_veterinario;

    public function __construct($idveterinario, $crmv, $funcionarioveterinariofk, $descricao, $nome_veterinario = null) {
        $this->idveterinario = $idveterinario;
        $this->crmv = $crmv;
        $this->funcionarioveterinariofk = $funcionarioveterinariofk;
        $this->descricao = $descricao;
        $this->nome_veterinario = $nome_veterinario;
    }

    public function __get($key) {
        return $this->{$key};
    }

    public function __set($key, $value) {
        $this->{$key} = $value;
    }    
}
?>