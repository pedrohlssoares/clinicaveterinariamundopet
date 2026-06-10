<?php
class sala {
    private $numero;
    private $tipo;
    private $descricao;

    public function __construct($numero, $tipo, $descricao) {
        $this->numero = $numero;
        $this->tipo = $tipo;
        $this->descricao = $descricao;
    }
    public function __get($key) { return $this->{$key}; }
    public function __set($key, $value) { $this->{$key} = $value; }
}
?>