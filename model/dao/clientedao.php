
<?php

include_once __DIR__ . "/../../config/conexao.php";

class clienteDao{


public function create(cliente $cliente){
    try{
        $pdo = conexao::conectar();
        $sql = "INSERT INTO cliente(nome, cpf, email, celular, enderecoclientefk) VALUES (?, ?, ?, ?, ?)";
        $query = $pdo->prepare($sql);
        $query->execute([
            $cliente->nome,
            $cliente->cpf,
            $cliente->email,
            $cliente->celular,
            $cliente->enderecoclientefk]);
        conexao::desconectar();
        return True;
    }catch(PDOException $exception){
        return False; 
    }
}

public function read(){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM cliente ORDER BY nome";
        $result = $pdo->query($sql);
        $lista = [];
        foreach($result as $linha){
            $lista[] = new cliente(
                $linha["idcliente"],
                $linha["nome"],
                $linha["cpf"],
                $linha["email"],
                $linha["celular"],
                $linha["enderecoclientefk"]
            );
        }
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return Null;
    }
}

public function readID($idcliente){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM cliente WHERE idcliente = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idcliente]);
        $lista = $query->fetch(PDO::FETCH_ASSOC);
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return null;
    }
}

public function update(cliente $cliente){
    try{
        $pdo = conexao::conectar();
        $sql = "UPDATE cliente SET 
        nome =?,
        cpf = ?,
        email = ?,
        celular = ?,
        enderecoclientefk = ?
        WHERE idcliente = ?";
        $query = $pdo->prepare($sql);
        $query->execute([
            $cliente->nome, 
            $cliente->cpf,
            $cliente->email,
            $cliente->celular,
            $cliente->enderecoclientefk,
            $cliente->idcliente]);
        conexao::desconectar();
        return true;
    }catch (PDOException $exception){
        return false;
    }
}

public function delete($idcliente){
    try{
        $pdo = conexao::conectar();
        $sql = "DELETE FROM cliente WHERE idcliente = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idcliente]);
        conexao::desconectar();
        return true;
    } catch (PDOException $exception){
        return false;
    }

}
}


?>