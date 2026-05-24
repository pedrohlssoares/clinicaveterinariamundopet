<?php

include_once __DIR__ . "/../../config/conexao.php";

class veterinarioDao {

    public function create(veterinario $veterinario) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO veterinario(crmv, funcionarioveterinariofk, descricao) VALUES (?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $veterinario->crmv,
                $veterinario->funcionarioveterinariofk,
                $veterinario->descricao
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false; 
        }
    }

    public function read() {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT * FROM veterinario ORDER BY crmv";
            $result = $pdo->query($sql);
            $lista = [];
            foreach ($result as $linha) {
                $lista[] = new veterinario(
                    $linha["idveterinario"],    
                    $linha["crmv"],
                    $linha["funcionarioveterinariofk"],
                    $linha["descricao"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch (PDOException $exception) {
            return null;
        }
    }

    public function readID($idveterinario) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT * FROM veterinario WHERE idveterinario = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idveterinario]);
            $lista = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $lista;
        } catch (PDOException $exception) {
            return null;
        }
    }

    public function update(veterinario $veterinario) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE veterinario SET 
                    crmv = ?,
                    funcionarioveterinariofk = ?,
                    descricao = ?
                    WHERE idveterinario = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $veterinario->crmv, 
                $veterinario->funcionarioveterinariofk,
                $veterinario->descricao,
                $veterinario->idveterinario
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function delete($idveterinario) {
        try {
            $pdo = conexao::conectar();
            $sql = "DELETE FROM veterinario WHERE idveterinario = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idveterinario]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
}

?>