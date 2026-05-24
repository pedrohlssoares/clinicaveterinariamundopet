<?php

include_once __DIR__ . "/../../config/conexao.php";

class prescricaoDao{


public function create(prescricao $prescricao){
    try{
        $pdo = conexao::conectar();
        $sql = "INSERT INTO prescricao(consultaprescricaofk, remedioprescricaofk) VALUES (?, ?)";
        $query = $pdo->prepare($sql);
        $query->execute([
            $prescricao->consultaprescricaofk,
            $prescricao->remedioprescricaofk]);
        conexao::desconectar();
        return True;
    }catch(PDOException $exception){
        return False; 
    }
}

public function read(){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM prescricao ORDER BY idprescricao";
        $result = $pdo->query($sql);
        $lista = [];
        foreach($result as $linha){
            $lista[] = new prescricao(
                $linha["idprescricao"],
                $linha["consultaprescricaofk"],
                $linha["remedioprescricaofk"]
            );
        }
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return Null;
    }
}

public function readID($idprescricao){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM prescricao WHERE idprescricao = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idprescricao]);
        $lista = $query->fetch(PDO::FETCH_ASSOC);
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return null;
    }
}

public function update(prescricao $prescricao){
    try{
        $pdo = conexao::conectar();
        $sql = "UPDATE prescricao SET 
        consultaprescricaofk = ?,
        remedioprescricaofk = ?
        WHERE idprescricao = ?";
        $query = $pdo->prepare($sql);
        $query->execute([
            $prescricao->consultaprescricaofk, 
            $prescricao->remedioprescricaofk,
            $prescricao->idprescricao]);
        conexao::desconectar();
        return true;
    }catch (PDOException $exception){
        return false;
    }
}

public function delete($idprescricao){
    try{
        $pdo = conexao::conectar();
        $sql = "DELETE FROM prescricao WHERE idprescricao = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idprescricao]);
        conexao::desconectar();
        return true;
    } catch (PDOException $exception){
        return false;
    }

}
}


?>