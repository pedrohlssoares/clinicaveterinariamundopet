<?php

class remedio{
    private $idremedio;
    private $produtoremediofk;
    private $ativo; 
    private $lote;

    public function __construct($idremedio, $produtoremediofk, $ativo, $lote){
        $this->idremedio = $idremedio;
        $this->produtoremediofk = $produtoremediofk;
        $this->ativo = $ativo;
        $this->lote = $lote; 
    }

    public function __get($key){
        return $this->{$key};
    }

    public  function __set($key, $value){
        $this->{$key} = $value;
    }
}

?>
