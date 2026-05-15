<?php

class historico_vacinacao{
    private $idhistorico;
    private $vacinahistorico_vacinacaofk;
    private $pethistoricofk;

    public function __construct($idhistorico, $vacinahistorico_vacinacaofk, $pethistoricofk){

        $this->idhistorico = $idhistorico;
        $this->$vacinahistorico_vacinacaofk = $vacinahistorico_vacinacaofk;
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