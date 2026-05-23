<?php

include "config/conexao.php";

class vendaDao{


public function create(venda $venda){
    try{
        $pdo = conexao::conectar();
        $sql = "INSERT INTO venda(pagamentovendafk, produtovendafk) VALUES (?, ?)";
        $query = $pdo->prepare($sql);
        $query->execute([
            $venda->pagamentovendafk,
            $venda->produtovendafk]);
        conexao::desconectar();
        return True;
    }catch(PDOException $exception){
        return False; 
    }
}

public function read(){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM venda ORDER BY idvenda";
        $result = $pdo->query($sql);
        $lista = [];
        foreach($result as $linha){
            $lista[] = new venda(
                $linha["idvenda"],
                $linha["pagamentovendafk"],
                $linha["produtovendafk"]
            );
        }
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return Null;
    }
}

public function readID($idvenda){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM venda WHERE idvenda = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idvenda]);
        $lista = $query->fetch(PDO::FETCH_ASSOC);
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return null;
    }
}

public function update(venda $venda){
    try{
        $pdo = conexao::conectar();
        $sql = "UPDATE venda SET 
        pagamentovendafk = ?,
        produtovendafk = ?
        WHERE idvenda = ?";
        $query = $pdo->prepare($sql);
        $query->execute([
            $venda->pagamentovendafk, 
            $venda->produtovendafk,
            $venda->idvenda]);
        conexao::desconectar();
        return true;
    }catch (PDOException $exception){
        return false;
    }
}

public function delete($idvenda){
    try{
        $pdo = conexao::conectar();
        $sql = "DELETE FROM venda WHERE idvenda = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idvenda]);
        conexao::desconectar();
        return true;
    } catch (PDOException $exception){
        return false;
    }

}
}


?>