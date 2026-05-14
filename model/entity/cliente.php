<?php

class cliente{
    private $idcliente;
    private $nome;
    private $cpf;
    private $email;
    private $celular;
    private $enderecoclientefk;

    public function __construct($idcliente, $nome, $cpf, $email, $celular, $enderecoclientefk){
        $this->idcliente = $idcliente;
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->celular = $celular;
        $this->enderecoclientefk = $enderecoclientefk;
    }

    public function __get($key){
    return $this->{$key};
    }

    public  function __set($key, $value){
    $this->{$key} = $value;
    }    
}
?>
