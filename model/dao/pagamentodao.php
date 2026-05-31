<?php

include_once __DIR__ . "/../../config/conexao.php";

class pagamentoDao {

    public function create(pagamento $pagamento) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO pagamento(pretacoes, valor, formapagamentofk) VALUES (?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $pagamento->pretacoes,
                $pagamento->valor,
                $pagamento->formapagamentofk
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
            $sql = "SELECT 
                        p.idpagamento, 
                        p.pretacoes, 
                        p.valor,
                        f.tipo AS nome_forma_pagamento
                    FROM pagamento p
                    INNER JOIN forma_pagamento f ON p.formapagamentofk = f.idforma_pagamento
                    ORDER BY p.idpagamento";
            $result = $pdo->query($sql);
            $lista = [];
            foreach ($result as $linha) {
                $lista[] = new pagamento(
                    $linha["idpagamento"],    
                    $linha["pretacoes"],
                    $linha["valor"],
                    null,
                    $linha["nome_forma_pagamento"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch (PDOException $exception) {
            return null;
        }
    }

    public function readID($idpagamento) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT 
                        p.*,
                        f.tipo AS nome_forma_pagamento
                    FROM pagamento p
                    INNER JOIN forma_pagamento f ON p.formapagamentofk = f.idforma_pagamento
                    WHERE p.idpagamento = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idpagamento]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();

            if ($linha) {
                return new pagamento(
                    $linha["idpagamento"],    
                    $linha["pretacoes"],
                    $linha["valor"],
                    null,
                    $linha["nome_forma_pagamento"]
                );
            }
            return null;
        } catch (PDOException $exception) {
            return null;
        }
    }

    public function update(pagamento $pagamento) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE pagamento SET 
                        pretacoes = ?,
                        valor = ?,
                        formapagamentofk = ?
                    WHERE idpagamento = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $pagamento->pretacoes, 
                $pagamento->valor,
                $pagamento->formapagamentofk,
                $pagamento->idpagamento
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