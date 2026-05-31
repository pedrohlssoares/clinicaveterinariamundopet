<?php

class funcionario {
    private $idfuncionario;
    private $nome;
    private $celular;
    private $cpf;
    private $salario;
    private $enderecofuncionariofk;

    // Novos atributos vindos do INNER JOIN com a tabela endereco
    private $rua;
    private $cidade;
    private $bairro;
    private $numero;
    private $complemento;

    public function __construct($idfuncionario, $nome, $celular, $cpf, $salario, $enderecofuncionariofk, $rua = null, $cidade = null, $bairro = null, $numero = null, $complemento = null) {
        $this->idfuncionario = $idfuncionario;
        $this->nome = $nome;
        $this->celular = $celular;
        $this->cpf = $cpf;
        $this->salario = $salario;
        $this->enderecofuncionariofk = $enderecofuncionariofk;

        // Atribuição dos campos opcionais de endereço
        $this->rua = $rua;
        $this->cidade = $cidade;
        $this->bairro = $bairro;
        $this->numero = $numero;
        $this->complemento = $complemento;
    }

    public function __get($key) {
        return $this->{$key};
    }

    public function __set($key, $value) {
        $this->{$key} = $value;
    }    
}
?>