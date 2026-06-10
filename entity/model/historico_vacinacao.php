<?php
class historico_vacinacao {
    private $idhistorico;
    private $pethistorico_vacinacaofk;
    private $vacinahistorico_vacinacaofk;
    private $data_aplicacao;
    private $dosagem;

    public function __construct($idhistorico, $pethistorico_vacinacaofk, $vacinahistorico_vacinacaofk, $data_aplicacao, $dosagem) {
        $this->idhistorico = $idhistorico;
        $this->pethistorico_vacinacaofk = $pethistorico_vacinacaofk;
        $this->vacinahistorico_vacinacaofk = $vacinahistorico_vacinacaofk;
        $this->data_aplicacao = $data_aplicacao;
        $this->dosagem = $dosagem;
    }
    public function __get($key) { return $this->{$key}; }
    public function __set($key, $value) { $this->{$key} = $value; }
}
?>