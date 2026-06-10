<?php
class despesa {
    private $iddespesa;
    private $preco;
    private $despesadata;
    private $descricao;

    public function __construct($iddespesa, $preco, $despesadata, $descricao) {
        $this->iddespesa = $iddespesa;
        $this->preco = $preco;
        $this->despesadata = $despesadata;
        $this->descricao = $descricao;
    }

    public function __get($key) { return $this->{$key}; }
    public function __set($key, $value) { $this->{$key} = $value; }
}
?>