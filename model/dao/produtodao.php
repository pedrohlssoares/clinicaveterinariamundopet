<?php

include_once __DIR__ . "/../../config/conexao.php";

class produtoDao{

public function create(produto $produto){
    try{
        $pdo = conexao::conectar();
        $sql = "INSERT INTO produto(nome, quantidade, descricao, preco) VALUES (?, ?, ?, ?)";
        $query = $pdo->prepare($sql);
        $query->execute([
            $produto->nome,
            $produto->quantidade,
            $produto->descricao,
            $produto->preco
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
        $sql = "SELECT * FROM produto ORDER BY nome";
        $result = $pdo->query($sql);
        $lista = [];
        foreach($result as $linha){
            $lista[] = new produto(
            $linha["idproduto"],    
            $linha["nome"],
            $linha["quantidade"],
            $linha["descricao"],
            $linha["preco"]
            );
        }
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return Null;
    }
}

public function readID($idproduto){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM produto WHERE idproduto = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idproduto]);
        $lista = $query->fetch(PDO::FETCH_ASSOC);
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return null;
    }
}

public function update(produto $produto){
    try{
        $pdo = conexao::conectar();
        $sql = "UPDATE produto SET 
        nome =?,
        quantidade =?,
        descricao = ?,
        preco =?
        WHERE idproduto= ?";
        $query = $pdo->prepare($sql);
        $query->execute([
            $produto->tipo, 
            $produto->descricao,
            $produto->idproduto]);
        conexao::desconectar();
        return true;
    }catch (PDOException $exception){
        return false;
    }
}

public function delete($idproduto){
    try{
        $pdo = conexao::conectar();
        $sql = "DELETE FROM produto WHERE idproduto = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idproduto]);
        conexao::desconectar();
        return true;
    } catch (PDOException $exception){
        return false;
    }

}
}


?>