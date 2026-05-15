<?php

class pagamento{
    private $idpagamento;
    private $pretacoes;
    private $valor;
    private $formapagamentofk;

    public function __construct($idpagamento, $pretacoes, $valor, $formapagamentofk){
        $this->idpagamento = $idpagamento;
        $this->pretacoes = $pretacoes;
        $this->valor = $valor;
        $this->formapagamentofk = $formapagamentofk;
    }

    public function __get($key){
        return $this->{$key};
    }

    public  function __set($key, $value){
        $this->{$key} = $value;
    }
}


?>