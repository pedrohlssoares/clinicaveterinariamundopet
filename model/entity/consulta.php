<?php

class consulta{
    private $idconsulta;
    private $petconsultafk;
    private $veterinarioconsultafk;
    private $salaconsultafk;
    private $data;
    private $processos_feitos;
    
    private $nome_pet;
    private $nome_veterinario;
    private $numero_sala;

    public function __construct($idconsulta, $petconsultafk, $veterinarioconsultafk, $salaconsultafk, $data, $processos_feitos, $nome_pet = null, $nome_veterinario = null, $numero_sala = null){
        $this->idconsulta = $idconsulta;
        $this->petconsultafk = $petconsultafk;
        $this->veterinarioconsultafk = $veterinarioconsultafk;
        $this->salaconsultafk = $salaconsultafk;
        $this->data = $data;
        $this->processos_feitos = $processos_feitos;
        
        $this->nome_pet = $nome_pet;
        $this->nome_veterinario = $nome_veterinario;
        $this->numero_sala = $numero_sala;
    }

    public function __get($key){
        return $this->{$key};
    }

    public  function __set($key, $value){
        $this->{$key} = $value;
    }
}

?>