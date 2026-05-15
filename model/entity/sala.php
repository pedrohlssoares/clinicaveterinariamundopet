<?php

class sala{
    private $numero;

    public function __construct($numero){
        $this->numero = $numero;
    }

    public function __get($key){
        return $this->{$key};
    }

    public  function __set($key, $value){
        $this->{$key} = $value;
    }
}

?>