<?php
class forma_pagamento {
    private $idforma_pagamento;
    private $tipo;
    private $descricao;

    public function __construct($idforma_pagamento, $tipo, $descricao) {
        $this->idforma_pagamento = $idforma_pagamento;
        $this->tipo = $tipo;
        $this->descricao = $descricao;
    }
    public function __get($key) { return $this->{$key}; }
    public function __set($key, $value) { $this->{$key} = $value; }
}
?>