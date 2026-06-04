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
        } catch(PDOException $exception) {
            return false; 
        }
    }

    public function read() {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT idremedio, produtoremediofk, ativo, lote FROM remedio";
            $result = $pdo->query($sql);
            $lista = [];
            foreach($result as $linha) {
                $lista[] = new remedio(
                    $linha["idremedio"], $linha["produtoremediofk"], 
                    $linha["ativo"], $linha["lote"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function readID($idremedio) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT idremedio, produtoremediofk, ativo, lote FROM remedio WHERE idremedio = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idremedio]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();

            if ($linha) {
                return new remedio(
                    $linha["idremedio"], $linha["produtoremediofk"], 
                    $linha["ativo"], $linha["lote"]
                );
            }
            return null;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function update(remedio $remedio) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE remedio SET produtoremediofk = ?, ativo = ?, lote = ? WHERE idremedio = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $remedio->produtoremediofk, $remedio->ativo, 
                $remedio->lote, $remedio->idremedio
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