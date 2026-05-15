<?php

class prescricaoprescricaopagamento{
    private $idprescricao_pagamento;
    private $prescricaoprescricaopagamentofk;
    private $pagamentoprescricaopagamentofk;


    public function __construct($idprescricao_pagamento, $prescricaoprescricaopagamentofk, $pagamentoprescricaopagamentofk){
        $this->idprescricao_pagamento = $idprescricao_pagamento;
        $this->prescricaoprescricaopagamentofk = $prescricaoprescricaopagamentofk;
        $this->pagamentoprescricaopagamentofk = $pagamentoprescricaopagamentofk;
    }

    public function __get($key){
        return $this->{$key};
    }

    public  function __set($key, $value){
        $this->{$key} = $value;
    }
}

?>