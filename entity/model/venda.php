<?php
class venda {
    private $idvenda;
    private $produtovendafk;
    private $quantidade;
    private $valor_unitario;

    public function __construct($idvenda, $produtovendafk, $quantidade, $valor_unitario) {
        $this->idvenda = $idvenda;
        $this->produtovendafk = $produtovendafk;
        $this->quantidade = $quantidade;
        $this->valor_unitario = $valor_unitario;
    }
    public function __get($key) { return $this->{$key}; }
    public function __set($key, $value) { $this->{$key} = $value; }
}
?>
