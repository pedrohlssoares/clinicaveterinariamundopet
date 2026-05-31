<?php

class prescricao {
    private $idprescricao;
    private $consultaprescricaofk;
    private $remedioprescricaofk;
    private $dosagem;
    
    private $nome_medicamento;
    private $principio_ativo;
    private $descricao_produto;

    public function __construct($idprescricao, $consultaprescricaofk, $remedioprescricaofk, $dosagem, $nome_medicamento = null, $principio_ativo = null, $descricao_produto = null) {
        $this->idprescricao = $idprescricao;
        $this->consultaprescricaofk = $consultaprescricaofk;
        $this->remedioprescricaofk = $remedioprescricaofk;
        $this->dosagem = $dosagem;
        
        $this->nome_medicamento = $nome_medicamento;
        $this->principio_ativo = $principio_ativo;
        $this->descricao_produto = $descricao_produto;
    }

    public function __get($key) {
        return $this->{$key};
    }

    public function __set($key, $value) {
        $this->{$key} = $value;
    }
}

?>