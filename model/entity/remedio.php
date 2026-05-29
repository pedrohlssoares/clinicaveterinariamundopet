<?php

class remedio {
    private $idremedio;
    private $produtoremediofk;
    private $ativo;
    private $lote;
    
    private $nome;
    private $preco;
    private $quantidade;

    public function __construct($idremedio, $produtoremediofk, $ativo, $lote, $nome = null, $preco = null, $quantidade = null) {
        $this->idremedio = $idremedio;
        $this->produtoremediofk = $produtoremediofk;
        $this->ativo = $ativo;
        $this->lote = $lote;
        
        $this->nome = $nome;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
    }

    public function __get($key) {
        return $this->{$key};
    }

    public function __set($key, $value) {
        $this->{$key} = $value;
    }
}

?>