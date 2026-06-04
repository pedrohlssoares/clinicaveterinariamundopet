<?php
include_once __DIR__ . "/../../config/conexao.php";

class vendaDao {
    public function create(venda $venda) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO venda(pagamentovendafk, produtovendafk, quantidade, valor_unitario) VALUES (?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $venda->pagamentovendafk,
                $venda->produtovendafk,
                $venda->quantidade,
                $venda->valor_unitario
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
            $sql = "SELECT idvenda, pagamentovendafk, produtovendafk, quantidade, valor_unitario FROM venda";
            $result = $pdo->query($sql);
            $lista = [];
            foreach($result as $linha) {
                $lista[] = new venda(
                    $linha["idvenda"], $linha["pagamentovendafk"], 
                    $linha["produtovendafk"], $linha["quantidade"], $linha["valor_unitario"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function readID($idvenda) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT idvenda, pagamentovendafk, produtovendafk, quantidade, valor_unitario FROM venda WHERE idvenda = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idvenda]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();

            if ($linha) {
                return new venda(
                    $linha["idvenda"], $linha["pagamentovendafk"], 
                    $linha["produtovendafk"], $linha["quantidade"], $linha["valor_unitario"]
                );
            }
            return null;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function update(venda $venda) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE venda SET pagamentovendafk = ?, produtovendafk = ?, quantidade = ?, valor_unitario = ? WHERE idvenda = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $venda->pagamentovendafk, $venda->produtovendafk, 
                $venda->quantidade, $venda->valor_unitario, $venda->idvenda
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function delete($idvenda) {
        try {
            $pdo = conexao::conectar();
            $sql = "DELETE FROM venda WHERE idvenda = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idvenda]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
}
?>