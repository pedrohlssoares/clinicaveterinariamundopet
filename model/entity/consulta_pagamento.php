<?php

class consulta_pagamento{
    private $idconsulta_pagamento;
    private $pagamento_idpagamentofk;
    private $consulta_idconsultafk;

    public function __construct($idconsulta_pagamento, $pagamento_idpagamentofk, $consulta_idconsultafk){
        $this->idconsulta_pagamento = $idconsulta_pagamento;
        $this->pagamento_idpagamentofk = $pagamento_idpagamentofk;
        $this->consulta_idconsultafk = $consulta_idconsultafk;
    }

    public function __get($key){
        return $this->{$key};
    }

    public  function __set($key, $value){
        $this->{$key} = $value;
    }
}

?>