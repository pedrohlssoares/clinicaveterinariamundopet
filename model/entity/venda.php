<?php

class venda{
    private $idvenda;
    private $pagamentovendafk;
    private $produtovendafk;

    public function __construct($idvenda, $pagamentovendafk, $produtovendafk){
        $this->idvenda = $idvenda;
        $this->pagamentovendafk = $pagamentovendafk;
        $this->produtovendafk = $produtovendafk;
    }

    public function __get($key){
        return $this->{$key};
    }

    public  function __set($key, $value){
        $this->{$key} = $value;
    }
}

?>