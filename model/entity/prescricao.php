<?php
class prescricao {
    private $idprescricao;
    private $consultaprescricaofk;
    private $remedioprescricaofk;
    private $pagamentoprescricaofk;
    private $dosagem;

    public function __construct($idprescricao, $consultaprescricaofk, $remedioprescricaofk, $pagamentoprescricaofk, $dosagem) {
        $this->idprescricao = $idprescricao;
        $this->consultaprescricaofk = $consultaprescricaofk;
        $this->remedioprescricaofk = $remedioprescricaofk;
        $this->pagamentoprescricaofk = $pagamentoprescricaofk;
        $this->dosagem = $dosagem;
    }
    public function __get($key) { return $this->{$key}; }
    public function __set($key, $value) { $this->{$key} = $value; }
}
?>