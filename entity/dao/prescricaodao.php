<?php
include_once __DIR__ . "/../../config/conexao.php";

class prescricaoDao {
    public function create(prescricao $prescricao) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO prescricao(consultaprescricaofk, remedioprescricaofk, vacinaprescricaofk, dosagem) VALUES (?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            
            $consulta = $prescricao->consultaprescricaofk;
            $remedio = $prescricao->remedioprescricaofk;
            $vacina = $prescricao->vacinaprescricaofk;
            $dosagem = $prescricao->dosagem;
            
            $query->bindValue(1, $consulta, PDO::PARAM_INT);
            
            if ($remedio == null || $remedio === "") {
                $query->bindValue(2, null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(2, $remedio, PDO::PARAM_INT);
            }
            
            if ($vacina == null || $vacina === "") {
                $query->bindValue(3, null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(3, $vacina, PDO::PARAM_INT);
            }
            
            $query->bindValue(4, $dosagem, PDO::PARAM_STR);
            
            $query->execute();
            conexao::desconectar();
            return true;
        } catch(PDOException $exception) {
            return $exception->getMessage(); 
        }
    }

    public function read() {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT idprescricao, consultaprescricaofk, remedioprescricaofk, vacinaprescricaofk, dosagem FROM prescricao";
            $result = $pdo->query($sql);
            $lista = [];
            foreach($result as $linha) {
                $lista[] = new prescricao(
                    $linha["idprescricao"], $linha["consultaprescricaofk"], 
                    $linha["remedioprescricaofk"], $linha["vacinaprescricaofk"], $linha["dosagem"]
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
            $sql = "SELECT idprescricao, consultaprescricaofk, remedioprescricaofk, vacinaprescricaofk, dosagem FROM prescricao WHERE idprescricao = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idprescricao]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            if ($linha) {
                return new prescricao(
                    $linha["idprescricao"], $linha["consultaprescricaofk"], 
                    $linha["remedioprescricaofk"], $linha["vacinaprescricaofk"], $linha["dosagem"]
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
            $sql = "UPDATE prescricao SET consultaprescricaofk = ?, remedioprescricaofk = ?, vacinaprescricaofk = ?, dosagem = ? WHERE idprescricao = ?";
            $query = $pdo->prepare($sql);
            
            $consulta = $prescricao->consultaprescricaofk;
            $remedio = $prescricao->remedioprescricaofk;
            $vacina = $prescricao->vacinaprescricaofk;
            $dosagem = $prescricao->dosagem;
            $id = $prescricao->idprescricao;
            
            $query->bindValue(1, $consulta, PDO::PARAM_INT);
            
            if ($remedio == null || $remedio === "") {
                $query->bindValue(2, null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(2, $remedio, PDO::PARAM_INT);
            }
            
            if ($vacina == null || $vacina === "") {
                $query->bindValue(3, null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(3, $vacina, PDO::PARAM_INT);
            }
            
            $query->bindValue(4, $dosagem, PDO::PARAM_STR);
            $query->bindValue(5, $id, PDO::PARAM_INT);
            
            $query->execute();
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return $exception->getMessage();
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
            return $exception->getMessage();
        }
    }
}
?>