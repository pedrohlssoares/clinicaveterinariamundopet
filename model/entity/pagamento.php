<?php

class pagamento{
    private $idpagamento;
    private $prestacoes;
    private $valor;
    private $formapagamentofk;

    public function __construct($idpagamento, $prestacoes, $valor, $formapagamentofk){
        $this->idpagamento = $idpagamento;
        $this->prestacoes = $prestacoes;
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