<?php

class consulta {
    private $idconsulta;
    private $petconsultafk;
    private $veterinarioconsultafk;
    private $salaconsultafk;
    private $data;
    private $horario; 
    private $processos_feitos;
    
    private $petcolnome; 
    private $nome_veterinario;
    private $numero_sala;

    public function __construct($idconsulta, $petconsultafk, $veterinarioconsultafk, $salaconsultafk, $data, $horario, $processos_feitos, $petcolnome = null, $nome_veterinario = null, $numero_sala = null) {
        $this->idconsulta = $idconsulta;
        $this->petconsultafk = $petconsultafk;
        $this->veterinarioconsultafk = $veterinarioconsultafk;
        $this->salaconsultafk = $salaconsultafk;
        $this->data = $data;
        $this->horario = $horario; 
        $this->processos_feitos = $processos_feitos;
        
        $this->petcolnome = $petcolnome; 
        $this->nome_veterinario = $nome_veterinario;
        $this->numero_sala = $numero_sala;
    }

    public function __get($key) {
        return $this->{$key};
    }

    public function __set($key, $value) {
        $this->{$key} = $value;
    }
}

?>