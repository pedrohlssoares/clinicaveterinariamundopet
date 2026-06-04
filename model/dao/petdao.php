<?php

include_once __DIR__ . "/../../config/conexao.php";

class petDao {

    public function create(pet $pet) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO pet(nome, especie, raca, idade, clientepetfk) VALUES (?, ?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $pet->nome,
                $pet->especie,
                $pet->raca,
                $pet->idade,
                $pet->clientepetfk
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
            $sql = "SELECT idpet, nome, especie, raca, idade, clientepetfk FROM pet ORDER BY nome";
            $result = $pdo->query($sql);
            $lista = [];
            foreach($result as $linha) {
                $lista[] = new pet(
                    $linha["idpet"],
                    $linha["nome"],
                    $linha["especie"],
                    $linha["raca"],
                    $linha["idade"],
                    $linha["clientepetfk"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function readID($idpet) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT idpet, nome, especie, raca, idade, clientepetfk FROM pet WHERE idpet = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idpet]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();

            if ($linha) {
                return new pet(
                    $linha["idpet"],
                    $linha["nome"],
                    $linha["especie"],
                    $linha["raca"],
                    $linha["idade"],
                    $linha["clientepetfk"]
                );
            }
            return null;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function update(pet $pet) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE pet SET 
                        nome = ?,
                        especie = ?,
                        raca = ?,
                        idade = ?,
                        clientepetfk = ?
                    WHERE idpet = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $pet->nome, 
                $pet->especie,
                $pet->raca,
                $pet->idade,
                $pet->clientepetfk,
                $pet->idpet
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function delete($idpet) {
        try {
            $pdo = conexao::conectar();
            $sql = "DELETE FROM pet WHERE idpet = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idpet]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
}
?>