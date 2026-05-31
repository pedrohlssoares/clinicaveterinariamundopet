<?php



class vacina{
    private $idvacina;
    private $produtovacinafk;
    private $ativo;
    private $lote;

    public function __construct($idvacina, $produtovacinafk, $ativo, $lote){

    $this->idvacina = $idvacina;
    $this->produtovacinafk = $produtovacinafk;
    $this->ativo = $ativo;
    $this->lote = $lote;

    }

    public function __get($key){
        return $this->{$key};
    }

    public  function __set($key, $value){
        $this->{$key} = $value;
    }
    
}

?>
