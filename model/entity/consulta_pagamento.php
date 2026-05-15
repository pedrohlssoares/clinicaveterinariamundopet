<?php

class consulta_pagamento{
    private $idconsulta_pagamento;
    private $pagamentoconsulta_pagamentofk;
    private $consultaconsulta_pagamentofk;

    public function __construct($idconsulta_pagamento, $pagamentoconsulta_pagamentofk, $consultaconsulta_pagamentofk){
        $this->idconsulta_pagamento = $idconsulta_pagamento;
        $this->$pagamentoconsulta_pagamentofk = $pagamentoconsulta_pagamentofk;
        $this->$consultaconsulta_pagamentofk = $consultaconsulta_pagamentofk;
    }

    public function __get($key){
        return $this->{$key};
    }

    public  function __set($key, $value){
        $this->{$key} = $value;
    }
}

?>