<?php
include_once __DIR__ . "/../../config/conexao.php";

class despesaDao {
    
    public function create(despesa $despesa) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO despesa(preco, despesadata, descricao) VALUES (?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $despesa->preco,
                $despesa->despesadata,
                $despesa->descricao
            ]);
            conexao::desconectar();
            return true;
        } catch(PDOException $exception) {
            return false; 
        }
    }

    public function read() {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT iddespesa, preco, despesadata, descricao FROM despesa ORDER BY despesadata DESC";
            $result = $pdo->query($sql);
            $lista = [];
            foreach($result as $linha) {
                $lista[] = new despesa(
                    $linha["iddespesa"], $linha["preco"], 
                    $linha["despesadata"], $linha["descricao"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function readID($iddespesa) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT iddespesa, preco, despesadata, descricao FROM despesa WHERE iddespesa = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$iddespesa]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            if ($linha) {
                return new despesa(
                    $linha["iddespesa"], $linha["preco"], 
                    $linha["despesadata"], $linha["descricao"]
                );
            }
            return null;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function update(despesa $despesa) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE despesa SET preco = ?, despesadata = ?, descricao = ? WHERE iddespesa = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $despesa->preco, $despesa->despesadata, 
                $despesa->descricao, $despesa->iddespesa
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function delete($iddespesa) {
        try {
            $pdo = conexao::conectar();
            $sql = "DELETE FROM despesa WHERE iddespesa = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$iddespesa]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
}
?>