<?php

include "config/conexao.php";

class consulta_pagamentoDao{


public function create(consulta_pagamento $consulta_pagamento){
    try{
        $pdo = conexao::conectar();
        $sql = "INSERT INTO consulta_pagamento(pagamentoconsulta_pagamentofk, consultaconsulta_pagamentofk) VALUES (?, ?)";
        $query = $pdo->prepare($sql);
        $query->execute([
            $consulta_pagamento->pagamentoconsulta_pagamentofk,
            $consulta_pagamento->consultaconsulta_pagamentofk]);
        conexao::desconectar();
        return True;
    }catch(PDOException $exception){
        return False; 
    }
}

public function read(){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM consulta_pagamento ORDER BY idconsulta_pagamento";
        $result = $pdo->query($sql);
        $lista = [];
        foreach($result as $linha){
            $lista[] = new consulta_pagamento(
                $linha["idconsulta_pagamento"],
                $linha["pagamentoconsulta_pagamentofk"],
                $linha["consultaconsulta_pagamentofk"]
            );
        }
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return Null;
    }
}

public function readID($idconsulta_pagamento){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM consulta_pagamento WHERE idconsulta_pagamento = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idconsulta_pagamento]);
        $lista = $query->fetch(PDO::FETCH_ASSOC);
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return null;
    }
}

public function update(consulta_pagamento $consulta_pagamento){
    try{
        $pdo = conexao::conectar();
        $sql = "UPDATE consulta_pagamento SET 
        pagamentoconsulta_pagamentofk = ?,
        consultaconsulta_pagamentofk = ?
        WHERE idconsulta_pagamento = ?";
        $query = $pdo->prepare($sql);
        $query->execute([
            $consulta_pagamento->pagamentoconsulta_pagamentofk, 
            $consulta_pagamento->consultaconsulta_pagamentofk,
            $consulta_pagamento->idconsulta_pagamento]);
        conexao::desconectar();
        return true;
    }catch (PDOException $exception){
        return false;
    }
}

public function delete($idconsulta_pagamento){
    try{
        $pdo = conexao::conectar();
        $sql = "DELETE FROM consulta_pagamento WHERE idconsulta_pagamento = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idconsulta_pagamento]);
        conexao::desconectar();
        return true;
    } catch (PDOException $exception){
        return false;
    }

}
}


?>