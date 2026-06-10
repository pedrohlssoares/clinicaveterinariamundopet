<?php
include_once __DIR__ . "/../../config/conexao.php";

class pagamentoDao {
    public function create(pagamento $pagamento) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO pagamento(prestacoes, valor, data_pagamento, formapagamentofk, clientepagamentofk, consultapagamentofk, prescricaopagamentofk) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $pagamento->prestacoes,
                $pagamento->valor,
                $pagamento->data_pagamento,
                $pagamento->formapagamentofk,
                $pagamento->clientepagamentofk,
                $pagamento->consultapagamentofk,
                $pagamento->prescricaopagamentofk
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
            $sql = "SELECT idpagamento, prestacoes, valor, data_pagamento, formapagamentofk, clientepagamentofk, consultapagamentofk, prescricaopagamentofk FROM pagamento ORDER BY data_pagamento DESC";
            $result = $pdo->query($sql);
            $lista = [];
            foreach($result as $linha) {
                $lista[] = new pagamento(
                    $linha["idpagamento"], $linha["prestacoes"], $linha["valor"], 
                    $linha["data_pagamento"], $linha["formapagamentofk"], $linha["clientepagamentofk"],
                    $linha["consultapagamentofk"], $linha["prescricaopagamentofk"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function readID($idpagamento) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT idpagamento, prestacoes, valor, data_pagamento, formapagamentofk, clientepagamentofk, consultapagamentofk, prescricaopagamentofk FROM pagamento WHERE idpagamento = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idpagamento]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            if ($linha) {
                return new pagamento(
                    $linha["idpagamento"], $linha["prestacoes"], $linha["valor"], 
                    $linha["data_pagamento"], $linha["formapagamentofk"], $linha["clientepagamentofk"],
                    $linha["consultapagamentofk"], $linha["prescricaopagamentofk"]
                );
            }
            return null;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function update(pagamento $pagamento) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE pagamento SET prestacoes = ?, valor = ?, data_pagamento = ?, formapagamentofk = ?, clientepagamentofk = ?, consultapagamentofk = ?, prescricaopagamentofk = ? WHERE idpagamento = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $pagamento->prestacoes, $pagamento->valor, $pagamento->data_pagamento, 
                $pagamento->formapagamentofk, $pagamento->clientepagamentofk,
                $pagamento->consultapagamentofk, $pagamento->prescricaopagamentofk, $pagamento->idpagamento
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function delete($idpagamento) {
        try {
            $pdo = conexao::conectar();
            $sql = "DELETE FROM pagamento WHERE idpagamento = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idpagamento]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
}
?>