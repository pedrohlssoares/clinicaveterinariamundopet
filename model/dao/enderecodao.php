<?php

class enderecoDao{

public function create(endereco $endereco){
    try{
        $pdo = conexao::conectar();
        $sql = "INSERT INTO endereco(rua, cidade, bairro, numero, complemento) VALUES (?, ?, ?, ?, ?)";
        $query = $pdo->prepare($sql);
        $query->execute([
            $endereco->rua,
            $endereco->cidade,
            $endereco->bairro,
            $endereco->numero,
            $endereco->complemento]);
        conexao::desconectar();
        return True;
    }catch(PDOException $exception){
        return False; 
    }
}

public function read(){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM endereco ORDER BY cidade";
        $result = $pdo->query(sql);
        lista = [];
        foreach($result as $linha){
            $lista[] = new endereco(
                $linha["idendereco"],
                $linha["rua"],
                $linha["cidade"],0
                $linha["bairro"],
                $linha["numero"],
                $linha["complemento"]
            );
        }
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return Null;
    }
}

public function readID($idendereco){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM endereco WHERE idendereco = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idendereco]);
        $lista = $query->fetch(PDO::FETCH_ASSOC);
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return null;
    }
}

public function update(endereco $endereco){
    try{
        $pdo = conexao::conectar();
        $sql = "UPDATE endereco SET 
        rua =?,
        cidade = ?,
        bairro = ?,
        numero = ?,
        complemento = ?
        WHERE idendereco= ?";
        $query = $pdo->prepare($sql);
        $query->execute([
            $endereco->rua, 
            $endereco->cidade,
            $endereco->bairro,
            $endereco->numero,
            $endereco->complemento,
            $endereco->idendereco]);
        conexao::desconectar();
        return true;
    }catch (PDOException $exception){
        return false;
    }
}

public function delete($idendereco){
    try{
        $pdo = conexao::conectar();
        $sql = "DELETE FROM endereco WHERE idendereco = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idendereco]);
        conexao::desconectar();
        return true;
    } catch (PDOException $exception){
        return false;
    }

}
}


?>