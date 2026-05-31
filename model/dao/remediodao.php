<?php

include_once __DIR__ . "/../../config/conexao.php";

class remedioDao {

    public function create(remedio $remedio) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO remedio(produtoremediofk, ativo, lote) VALUES (?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $remedio->produtoremediofk,
                $remedio->ativo,
                $remedio->lote
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false; 
        }
    }

    public function read(){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT 
                    r.idremedio,
                    p.nome,
                    r.ativo,
                    r.lote,
                    p.preco,
                    p.quantidade
                FROM remedio r
                INNER JOIN produto p ON r.produtoremediofk = p.idproduto
                ORDER BY p.nome";
        $result = $pdo->query($sql);
        $lista = [];
        foreach($result as $linha){
            $lista[] = new remedio(
                $linha["idremedio"],
                null,
                $linha["nome"],
                $linha["ativo"],
                $linha["lote"],
                $linha["preco"],
                $linha["quantidade"]
            );
        }
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return Null;
    }
}

    public function readID($idremedio) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT * FROM remedio WHERE idremedio = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idremedio]);
            $lista = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $lista;
        } catch (PDOException $exception) {
            return null;
        }
    }

    public function update(remedio $remedio) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE remedio SET 
                    produtoremediofk = ?,
                    ativo = ?,
                    lote = ?
                    WHERE idremedio = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $remedio->produtoremediofk, 
                $remedio->ativo,
                $remedio->lote,
                $remedio->idremedio
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function delete($idremedio) {
        try {
            $pdo = conexao::conectar();
            $sql = "DELETE FROM remedio WHERE idremedio = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idremedio]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
}

?>