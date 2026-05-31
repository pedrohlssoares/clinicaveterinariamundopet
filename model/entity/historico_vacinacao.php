<?php

class historico_vacinacao {
    private $idhistorico;
    private $pethistorico_vacinacaofk;
    private $vacinahistorico_vacinacaofk;
    private $data_aplicacao;
    private $dosagem;
    private $nome_pet;
    private $nome_vacina;

    public function __construct($idhistorico, $pethistorico_vacinacaofk, $vacinahistorico_vacinacaofk, $data_aplicacao, $dosagem, $nome_pet = null, $nome_vacina = null) {
        $this->idhistorico = $idhistorico;
        $this->pethistorico_vacinacaofk = $pethistorico_vacinacaofk;
        $this->vacinahistorico_vacinacaofk = $vacinahistorico_vacinacaofk;
        $this->data_aplicacao = $data_aplicacao;
        $this->dosagem = $dosagem;
        $this->nome_pet = $nome_pet;
        $this->nome_vacina = $nome_vacina;
    }

    public function __get($key) {
        return $this->{$key};
    }

    public function __set($key, $value) {
        $this->{$key} = $value;
    }    
}
?>