<?php

include_once __DIR__ . "/../../config/conexao.php";

class prescricaoprescricaopagamentoDao {

    public function create(prescricaoprescricaopagamento $prescricaoprescricaopagamento) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO prescricaoprescricaopagamento(prescricaoprescricaopagamentofk, pagamentoprescricaopagamentofk) VALUES (?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $prescricaoprescricaopagamento->prescricaoprescricaopagamentofk,
                $prescricaoprescricaopagamento->pagamentoprescricaopagamentofk
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
            $sql = "SELECT * FROM prescricaoprescricaopagamento ORDER BY idprescricao_pagamento";
            $result = $pdo->query($sql);
            $lista = [];
            foreach ($result as $linha) {
                $lista[] = new prescricaoprescricaopagamento(
                    $linha["idprescricao_pagamento"],    
                    $linha["prescricaoprescricaopagamentofk"],
                    $linha["pagamentoprescricaopagamentofk"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch (PDOException $exception) {
            return null;
        }
    }

    public function readID($idprescricao_pagamento) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT * FROM prescricaoprescricaopagamento WHERE idprescricao_pagamento = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idprescricao_pagamento]);
            $lista = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $lista;
        } catch (PDOException $exception) {
            return null;
        }
    }

    public function update(prescricaoprescricaopagamento $prescricaoprescricaopagamento) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE prescricaoprescricaopagamento SET 
                    prescricaoprescricaopagamentofk = ?,
                    pagamentoprescricaopagamentofk = ?
                    WHERE idprescricao_pagamento = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $prescricaoprescricaopagamento->prescricaoprescricaopagamentofk, 
                $prescricaoprescricaopagamento->pagamentoprescricaopagamentofk,
                $prescricaoprescricaopagamento->idprescricao_pagamento
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function delete($idprescricao_pagamento) {
        try {
            $pdo = conexao::conectar();
            $sql = "DELETE FROM prescricaoprescricaopagamento WHERE idprescricao_pagamento = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idprescricao_pagamento]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
}

?>