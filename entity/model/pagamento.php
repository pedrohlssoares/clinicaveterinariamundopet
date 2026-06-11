<?php
class pagamento {
    private $idpagamento;
    private $prestacoes;
    private $valor;
    private $data_pagamento;
    private $formapagamentofk;
    private $clientepagamentofk;
    private $consultapagamentofk;
    private $prescricaopagamentofk;
    private $vendapagamentofk;

    public function __construct($idpagamento, $prestacoes, $valor, $data_pagamento, $formapagamentofk, $clientepagamentofk, $consultapagamentofk, $prescricaopagamentofk, $vendapagamentofk) {
        $this->idpagamento = $idpagamento;
        $this->prestacoes = $prestacoes;
        $this->valor = $valor;
        $this->data_pagamento = $data_pagamento;
        $this->formapagamentofk = $formapagamentofk;
        $this->clientepagamentofk = $clientepagamentofk;
        $this->consultapagamentofk = $consultapagamentofk;
        $this->prescricaopagamentofk = $prescricaopagamentofk;
        $this->vendapagamentofk = $vendapagamentofk;
    }

    public function __get($key) { return $this->{$key}; }
    public function __set($key, $value) { $this->{$key} = $value; }
}
?>
