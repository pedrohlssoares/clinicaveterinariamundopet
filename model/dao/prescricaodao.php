<?php
include_once __DIR__ . "/../../config/conexao.php";

class prescricaoDao {
    public function create(prescricao $prescricao) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO prescricao(consultaprescricaofk, remedioprescricaofk, pagamentoprescricaofk, dosagem) VALUES (?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $prescricao->consultaprescricaofk,
                $prescricao->remedioprescricaofk,
                $prescricao->pagamentoprescricaofk,
                $prescricao->dosagem
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
            $sql = "SELECT idprescricao, consultaprescricaofk, remedioprescricaofk, pagamentoprescricaofk, dosagem FROM prescricao";
            $result = $pdo->query($sql);
            $lista = [];
            foreach($result as $linha) {
                $lista[] = new prescricao(
                    $linha["idprescricao"], $linha["consultaprescricaofk"], 
                    $linha["remedioprescricaofk"], $linha["pagamentoprescricaofk"], $linha["dosagem"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function readID($idprescricao) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT idprescricao, consultaprescricaofk, remedioprescricaofk, pagamentoprescricaofk, dosagem FROM prescricao WHERE idprescricao = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idprescricao]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();

            if ($linha) {
                return new prescricao(
                    $linha["idprescricao"], $linha["consultaprescricaofk"], 
                    $linha["remedioprescricaofk"], $linha["pagamentoprescricaofk"], $linha["dosagem"]
                );
            }
            return null;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function update(prescricao $prescricao) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE prescricao SET consultaprescricaofk = ?, remedioprescricaofk = ?, pagamentoprescricaofk = ?, dosagem = ? WHERE idprescricao = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $prescricao->consultaprescricaofk, $prescricao->remedioprescricaofk, 
                $prescricao->pagamentoprescricaofk, $prescricao->dosagem, $prescricao->idprescricao
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function delete($idprescricao) {
        try {
            $pdo = conexao::conectar();
            $sql = "DELETE FROM prescricao WHERE idprescricao = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idprescricao]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
}
?>