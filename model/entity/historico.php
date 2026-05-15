<?php

class historico{
    private $idhistorico;
    private $consultas;
    private $tratamentos;
    private $pethistoricofk;

    public function __construct($idhistorico, $consultas, $tratamentos, $pethistoricofk){

        $this->idhistorico = $idhistorico;
        $this->consultas = $consultas;
        $this->tratamentos = $tratamentos;
        $this->pethistoricofk = $pethistoricofk;
    }

    public function __get($key){
        return $this->{$key};
    }

    public  function __set($key, $value){
        $this->{$key} = $value;
    }
}

?>