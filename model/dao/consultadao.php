<?php

include_once __DIR__ . "/../../config/conexao.php";

class consultaDao{


public function create(consulta $consulta){
    try{
        $pdo = conexao::conectar();
        $sql = "INSERT INTO consulta(petconsultafk, veterinarioconsultafk, salaconsultafk, data, processos_feitos) VALUES (?, ?, ?, ?, ?)";
        $query = $pdo->prepare($sql);
        $query->execute([
            $consulta->petconsultafk,
            $consulta->veterinarioconsultafk,
            $consulta->salaconsultafk,
            $consulta->data,
            $consulta->processos_feitos]);
        conexao::desconectar();
        return True;
    }catch(PDOException $exception){
        return False; 
    }
}

public function read(){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM consulta ORDER BY data";
        $result = $pdo->query($sql);
        $lista = [];
        foreach($result as $linha){
            $lista[] = new consulta(
                $linha["idconsulta"],
                $linha["petconsultafk"],
                $linha["veterinarioconsultafk"],
                $linha["salaconsultafk"],
                $linha["data"],
                $linha["processos_feitos"]
            );
        }
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return Null;
    }
}

public function readID($idconsulta){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM consulta WHERE idconsulta = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idconsulta]);
        $lista = $query->fetch(PDO::FETCH_ASSOC);
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return null;
    }
}

public function update(consulta $consulta){
    try{
        $pdo = conexao::conectar();
        $sql = "UPDATE consulta SET 
        petconsultafk = ?,
        veterinarioconsultafk = ?,
        salaconsultafk = ?,
        data = ?,
        processos_feitos = ?
        WHERE idconsulta = ?";
        $query = $pdo->prepare($sql);
        $query->execute([
            $consulta->petconsultafk, 
            $consulta->veterinarioconsultafk,
            $consulta->salaconsultafk,
            $consulta->data,
            $consulta->processos_feitos,
            $consulta->idconsulta]);
        conexao::desconectar();
        return true;
    }catch (PDOException $exception){
        return false;
    }
}

public function delete($idconsulta){
    try{
        $pdo = conexao::conectar();
        $sql = "DELETE FROM consulta WHERE idconsulta = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idconsulta]);
        conexao::desconectar();
        return true;
    } catch (PDOException $exception){
        return false;
    }

}
}

?>