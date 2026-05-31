<?php

class cliente {
    private $idcliente;
    private $nome;
    private $cpf;
    private $email;
    private $celular;
    private $enderecoclientefk;

    // Novos atributos vindos do INNER JOIN com a tabela endereco
    private $rua;
    private $cidade;
    private $bairro;
    private $numero;
    private $complemento;

    public function __construct($idcliente, $nome, $cpf, $email, $celular, $enderecoclientefk, $rua = null, $cidade = null, $bairro = null, $numero = null, $complemento = null) {
        $this->idcliente = $idcliente;
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->celular = $celular;
        $this->enderecoclientefk = $enderecoclientefk;

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