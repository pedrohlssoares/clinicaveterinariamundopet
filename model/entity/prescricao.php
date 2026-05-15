<?php

class prescricao{

    private $idprescricao;
    private $consultaprescricaofk;
    private $remedioprescricaofk;

    public function __construct($idprescricao, $consultaprescricaofk, $remedioprescricaofk){
        $this->idprescricao = $idprescricao;
        $this->consultaprescricaofk = $consultaprescricaofk;
        $this->remedioprescricaofk = $remedioprescricaofk;
    }

    public function __get($key){
        return $this->{$key};
    }

    public  function __set($key, $value){
        $this->{$key} = $value;
    }

}

?>