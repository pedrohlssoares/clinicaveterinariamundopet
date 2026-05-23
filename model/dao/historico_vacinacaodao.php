<?php

include "config/conexao.php";

class historico_vacinacaoDao{

public function create(historico_vacinacao $historico_vacinacao){
    try{
        $pdo = conexao::conectar();
        $sql = "INSERT INTO historico_vacinacao(pethistorico_vacinacaofk, vacinahistorico_vacinacaofk) VALUES (?, ?)";
        $query = $pdo->prepare($sql);
        $query->execute([
            $historico_vacinacao->pethistorico_vacinacaofk,
            $historico_vacinacao->vacinahistorico_vacinacaofk
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
        $sql = "SELECT * FROM historico_vacinacao ORDER BY idhistorico";
        $result = $pdo->query($sql);
        $lista = [];
        foreach($result as $linha){
            $lista[] = new historico_vacinacao(
                $linha["idhistorico"],
                $linha["pethistorico_vacinacaofk"],
                $linha["vacinahistorico_vacinacaofk"]
            );
        }
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return Null;
    }
}

public function readID($idhistorico){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM historico_vacinacao WHERE idhistorico = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idhistorico]);
        $lista = $query->fetch(PDO::FETCH_ASSOC);
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return null;
    }
}

public function update(historico_vacinacao $historico_vacinacao){
    try{
        $pdo = conexao::conectar();
        $sql = "UPDATE historico_vacinacao SET 
        pethistorico_vacinacaofk = ?,
        vacinahistorico_vacinacaofk = ?
        WHERE idhistorico = ?";
        $query = $pdo->prepare($sql);
        $query->execute([
            $historico_vacinacao->pethistorico_vacinacaofk, 
            $historico_vacinacao->vacinahistorico_vacinacaofk,
            $historico_vacinacao->idhistorico
        ]);
        conexao::desconectar();
        return true;
    }catch (PDOException $exception){
        return false;
    }
}

public function delete($idhistorico){
    try{
        $pdo = conexao::conectar();
        $sql = "DELETE FROM historico_vacinacao WHERE idhistorico = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idhistorico]);
        conexao::desconectar();
        return true;
    } catch (PDOException $exception){
        return false;
    }
}
}

?>