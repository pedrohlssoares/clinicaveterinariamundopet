<?php

class consulta{
    private $idconsulta;
    private $petconsultafk;
    private $veterinarioconsultafk;
    private $salaconsultafk;
    private $data;
    private $processos_feitos;

    public function __construct($idconsulta, $petconsultafk, $veterinarioconsultafk, $salaconsultafk, $data, $processos_feitos){
        $this->idconsulta = $idconsulta;
        $this->petconsultafk = $petconsultafk;
        $this->veterinarioconsultafk = $veterinarioconsultafk;
        $this->salaconsultafk = $salaconsultafk;
        $this->data = $data;
        $this->processos_feitos = $processos_feitos;
    }

    public function __get($key){
        return $this->{$key};
    }

    public  function __set($key, $value){
        $this->{$key} = $value;
    }
}

?>