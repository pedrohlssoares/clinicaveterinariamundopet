<?php
class endereco {
    private $idendereco;
    private $rua;
    private $cidade;
    private $bairro;
    private $numero;
    private $complemento;

    public function __construct($idendereco, $rua, $cidade, $bairro, $numero, $complemento) {
        $this->idendereco = $idendereco;
        $this->rua = $rua;
        $this->cidade = $cidade;
        $this->bairro = $bairro;
        $this->numero = $numero;
        $this->complemento = $complemento;
    }
    public function __get($key) { return $this->{$key}; }
    public function __set($key, $value) { $this->{$key} = $value; }
}
?>