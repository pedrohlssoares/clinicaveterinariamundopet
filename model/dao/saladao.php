<?php
include_once __DIR__ . "/../../config/conexao.php";

class salaDao {
    public function create(sala $sala) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO sala(tipo, descricao) VALUES (?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $sala->tipo,
                $sala->descricao
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
            $sql = "SELECT numero, tipo, descricao FROM sala";
            $result = $pdo->query($sql);
            $lista = [];
            foreach($result as $linha) {
                $lista[] = new sala(
                    $linha["numero"],
                    $linha["tipo"],
                    $linha["descricao"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function readID($numero) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT numero, tipo, descricao FROM sala WHERE numero = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$numero]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();

            if ($linha) {
                return new sala(
                    $linha["numero"], $linha["tipo"], $linha["descricao"]
                );
            }
            return null;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function update(sala $sala) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE sala SET tipo = ?, descricao = ? WHERE numero = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $sala->tipo, $sala->descricao, $sala->numero
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function delete($numero) {
        try {
            $pdo = conexao::conectar();
            $sql = "DELETE FROM sala WHERE numero = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$numero]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
}
?>