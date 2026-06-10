<?php
include_once __DIR__ . "/../../config/conexao.php";

class historico_vacinacaoDao {
    public function create(historico_vacinacao $historico) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO historico_vacinacao(pethistorico_vacinacaofk, vacinahistorico_vacinacaofk, data_aplicacao, dosagem) VALUES (?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $historico->pethistorico_vacinacaofk,
                $historico->vacinahistorico_vacinacaofk,
                $historico->data_aplicacao,
                $historico->dosagem
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
            $sql = "SELECT idhistorico, pethistorico_vacinacaofk, vacinahistorico_vacinacaofk, data_aplicacao, dosagem FROM historico_vacinacao ORDER BY data_aplicacao DESC";
            $result = $pdo->query($sql);
            $lista = [];
            foreach($result as $linha) {
                $lista[] = new historico_vacinacao(
                    $linha["idhistorico"], $linha["pethistorico_vacinacaofk"], 
                    $linha["vacinahistorico_vacinacaofk"], $linha["data_aplicacao"], $linha["dosagem"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function readID($idhistorico) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT idhistorico, pethistorico_vacinacaofk, vacinahistorico_vacinacaofk, data_aplicacao, dosagem FROM historico_vacinacao WHERE idhistorico = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idhistorico]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();

            if ($linha) {
                return new historico_vacinacao(
                    $linha["idhistorico"], $linha["pethistorico_vacinacaofk"], 
                    $linha["vacinahistorico_vacinacaofk"], $linha["data_aplicacao"], $linha["dosagem"]
                );
            }
            return null;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function update(historico_vacinacao $historico) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE historico_vacinacao SET pethistorico_vacinacaofk = ?, vacinahistorico_vacinacaofk = ?, data_aplicacao = ?, dosagem = ? WHERE idhistorico = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $historico->pethistorico_vacinacaofk, $historico->vacinahistorico_vacinacaofk, 
                $historico->data_aplicacao, $historico->dosagem, $historico->idhistorico
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function delete($idhistorico) {
        try {
            $pdo = conexao::conectar();
            $sql = "DELETE FROM historico_vacinacao WHERE idhistorico = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idhistorico]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
}
?>