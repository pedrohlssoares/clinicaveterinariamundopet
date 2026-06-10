<?php
include_once __DIR__ . "/../../config/conexao.php";

class vacinaDao {
    public function create(vacina $vacina) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO vacina(produtovacinafk, ativo, lote) VALUES (?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $vacina->produtovacinafk,
                $vacina->ativo,
                $vacina->lote
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
            $sql = "SELECT idvacina, produtovacinafk, ativo, lote FROM vacina";
            $result = $pdo->query($sql);
            $lista = [];
            foreach($result as $linha) {
                $lista[] = new vacina(
                    $linha["idvacina"], $linha["produtovacinafk"], 
                    $linha["ativo"], $linha["lote"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function readID($idvacina) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT idvacina, produtovacinafk, ativo, lote FROM vacina WHERE idvacina = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idvacina]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();

            if ($linha) {
                return new vacina(
                    $linha["idvacina"], $linha["produtovacinafk"], 
                    $linha["ativo"], $linha["lote"]
                );
            }
            return null;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function update(vacina $vacina) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE vacina SET produtovacinafk = ?, ativo = ?, lote = ? WHERE idvacina = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $vacina->produtovacinafk, $vacina->ativo, 
                $vacina->lote, $vacina->idvacina
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function delete($idvacina) {
        try {
            $pdo = conexao::conectar();
            $sql = "DELETE FROM vacina WHERE idvacina = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idvacina]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
}
?>