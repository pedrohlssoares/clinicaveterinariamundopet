<?php

class funcionario{
    private $idfuncionario;
    private $nome;
    private $celular;
    private $cpf;
    private $salario;
    private $enderecofuncionariofk;

    public function __construct($idfuncionario, $nome, $celular, $cpf, $salario, $enderecofuncionariofk){
        $this->idfuncionario = $idfuncionario;
        $this->nome = $nome;
        $this->celular = $celular;
        $this->cpf = $cpf;
        $this->salario = $salario;
        $this->enderecofuncionariofk = $enderecofuncionariofk;
    }

    public function __get($key){
    return $this->{$key};
    }

    public  function __set($key, $value){
    $this->{$key} = $value;
    }
}
?>