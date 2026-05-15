<?php

class produto{
    private $idproduto;
    private $nome;
    private $quantidade;
    private $descricao;
    private $preco;

    public function __construct($idproduto, $nome, $quantidade, $descricao, $preco){
        $this->idproduto = $idproduto;
        $this->nome = $nome;
        $this->quantidade = $quantidade;
        $this->descricao = $descricao;
        $this->preco = $preco;
    }

    public function __get($key){
        return $this->{$key};
    }

    public  function __set($key, $value){
        $this->{$key} = $value;
    }
}

?>