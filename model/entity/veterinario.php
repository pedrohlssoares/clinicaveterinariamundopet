<?php

class veterinario{
    private $idveterinario;
    private $crmv;
    private $funcionarioveterinariofk;
    private $descricao;

    public function __construct($idveterinario, $crmv, $funcionarioveterinariofk, $descricao){
        $this->idveterinario = $idveterinario;
        $this->crmv = $crmv;
        $this->funcionarioveterinariofk = $funcionarioveterinariofk;
        $this->descricao = $descricao; 
    }

    public function __get($key){
    return $this->{$key};
    }

    public  function __set($key, $value){
    $this->{$key} = $value;
    }
}
?>
