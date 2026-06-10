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

    public function __construct($idpagamento, $prestacoes, $valor, $data_pagamento, $formapagamentofk, $clientepagamentofk, $consultapagamentofk, $prescricaopagamentofk) {
        $this->idpagamento = $idpagamento;
        $this->prestacoes = $prestacoes;
        $this->valor = $valor;
        $this->data_pagamento = $data_pagamento;
        $this->formapagamentofk = $formapagamentofk;
        $this->clientepagamentofk = $clientepagamentofk;
        $this->consultapagamentofk = $consultapagamentofk;
        $this->prescricaopagamentofk = $prescricaopagamentofk;
    }

    public function __get($key) { return $this->{$key}; }
    public function __set($key, $value) { $this->{$key} = $value; }
}
?>