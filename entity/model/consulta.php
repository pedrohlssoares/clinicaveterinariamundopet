<?php
class consulta {
    private $idconsulta;
    private $petconsultafk;
    private $veterinarioconsultafk;
    private $salaconsultafk;
    private $data_consulta;
    private $horario;
    private $status;
    private $processos_feitos;

    public function __construct($idconsulta, $petconsultafk, $veterinarioconsultafk, $salaconsultafk, $data_consulta, $horario, $status, $processos_feitos) {
        $this->idconsulta = $idconsulta;
        $this->petconsultafk = $petconsultafk;
        $this->veterinarioconsultafk = $veterinarioconsultafk;
        $this->salaconsultafk = $salaconsultafk;
        $this->data_consulta = $data_consulta;
        $this->horario = $horario;
        $this->status = $status;
        $this->processos_feitos = $processos_feitos;
    }

    public function __get($key) { return $this->{$key}; }
    public function __set($key, $value) { $this->{$key} = $value; }
}
?>