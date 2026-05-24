<?php

include_once __DIR__ . "/../../config/conexao.php";

class forma_pagamentoDao{

public function create(forma_pagamento $forma_pagamento){
    try{
        $pdo = conexao::conectar();
        $sql = "INSERT INTO forma_pagamento(tipo, descricao) VALUES (?, ?)";
        $query = $pdo->prepare($sql);
        $query->execute([
            $forma_pagamento->tipo,
            $forma_pagamento->descricao
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
        $sql = "SELECT * FROM forma_pagamento ORDER BY tipo";
        $result = $pdo->query($sql);
        $lista = [];
        foreach($result as $linha){
            $lista[] = new forma_pagamento(
            $linha["idforma_pagamento"],    
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

public function readID($idforma_pagamento){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM forma_pagamento WHERE idforma_pagamento = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idforma_pagamento]);
        $lista = $query->fetch(PDO::FETCH_ASSOC);
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return null;
    }
}

public function update(forma_pagamento $forma_pagamento){
    try{
        $pdo = conexao::conectar();
        $sql = "UPDATE forma_pagamento SET 
        tipo =?,
        descricao = ?
        WHERE idforma_pagamento= ?";
        $query = $pdo->prepare($sql);
        $query->execute([
            $forma_pagamento->tipo, 
            $forma_pagamento->descricao,
            $forma_pagamento->idforma_pagamento]);
        conexao::desconectar();
        return true;
    }catch (PDOException $exception){
        return false;
    }
}

public function delete($idforma_pagamento){
    try{
        $pdo = conexao::conectar();
        $sql = "DELETE FROM forma_pagamento WHERE idforma_pagamento = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idforma_pagamento]);
        conexao::desconectar();
        return true;
    } catch (PDOException $exception){
        return false;
    }

}
}


?>