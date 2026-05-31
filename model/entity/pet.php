<?php

class pet {
    private $idpet;
    private $petcolnome;
    private $especie;
    private $raca;
    private $idade;
    private $clientepetfk;

    // Atributo vindo do INNER JOIN
    private $nome_dono;

    public function __construct($idpet, $petcolnome, $especie, $raca, $idade, $clientepetfk, $nome_dono = null) {
        $this->idpet = $idpet;
        $this->petcolnome = $petcolnome;
        $this->especie = $especie;
        $this->raca = $raca;
        $this->idade = $idade;
        $this->clientepetfk = $clientepetfk;
        $this->nome_dono = $nome_dono;
    }

    public function __get($key) {
        return $this->{$key};
    }

    public function __set($key, $value) {
        $this->{$key} = $value;
    }    
}
?>
