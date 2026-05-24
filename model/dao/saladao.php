<?php

include_once __DIR__ . "/../../config/conexao.php";

class salaDao{

public function create(sala $sala){
    try{
        $pdo = conexao::conectar();
        $sql = "INSERT INTO sala(tipo, descricao) VALUES (?, ?)";
        $query = $pdo->prepare($sql);
        $query->execute([
            $sala->tipo,
            $sala->descricao
            ]);
        conexao::desconectar();
        return True;
    }catch(PDOException $exception){
        return False; 
    }
}

public function read(){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM sala ORDER BY tipo";
        $result = $pdo->query($sql);
        $lista = [];
        foreach($result as $linha){
            $lista[] = new sala(
            $linha["idsala"],    
            $linha["tipo"],
            $linha["descricao"]
            );
        }
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return Null;
    }
}

public function readID($idsala){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM sala WHERE idsala = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idsala]);
        $lista = $query->fetch(PDO::FETCH_ASSOC);
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return null;
    }
}

public function update(sala $sala){
    try{
        $pdo = conexao::conectar();
        $sql = "UPDATE sala SET 
        tipo =?,
        descricao = ?
        WHERE idsala= ?";
        $query = $pdo->prepare($sql);
        $query->execute([
            $sala->tipo, 
            $sala->descricao,
            $sala->idsala]);
        conexao::desconectar();
        return true;
    }catch (PDOException $exception){
        return false;
    }
}

public function delete($idsala){
    try{
        $pdo = conexao::conectar();
        $sql = "DELETE FROM sala WHERE idsala = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idsala]);
        conexao::desconectar();
        return true;
    } catch (PDOException $exception){
        return false;
    }

}
}


?>