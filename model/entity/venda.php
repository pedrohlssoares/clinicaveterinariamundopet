<?php

class venda {
    private $idvenda;
    private $pagamentovendafk;
    private $produtovendafk;
    
    private $nome_produto;
    private $preco_produto;

    public function __construct($idvenda, $pagamentovendafk, $produtovendafk, $nome_produto = null, $preco_produto = null) {
        $this->idvenda = $idvenda;
        $this->pagamentovendafk = $pagamentovendafk;
        $this->produtovendafk = $produtovendafk;
        
        $this->nome_produto = $nome_produto;
        $this->preco_produto = $preco_produto;
    }

    public function __get($key) {
        return $this->{$key};
    }

    public function __set($key, $value) {
        $this->{$key} = $value;
    }
}

?>