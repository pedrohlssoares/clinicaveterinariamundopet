<?php
include_once __DIR__ . "/../../config/conexao.php";

class pagamentoDao {
    public function create(pagamento $pagamento) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO pagamento(prestacoes, valor, data_pagamento, formapagamentofk, clientepagamentofk, consultapagamentofk, prescricaopagamentofk, vendapagamentofk) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            
            $query->bindValue(1, $pagamento->prestacoes, PDO::PARAM_INT);
            $query->bindValue(2, $pagamento->valor, PDO::PARAM_STR);
            $query->bindValue(3, $pagamento->data_pagamento, PDO::PARAM_STR);
            $query->bindValue(4, $pagamento->formapagamentofk, PDO::PARAM_INT);
            $query->bindValue(5, $pagamento->clientepagamentofk, PDO::PARAM_INT);

            // Campos Opcionais (FKs) - Devem enviar NULL real para o BD se vazios
            $v_cons = empty($pagamento->consultapagamentofk) ? null : $pagamento->consultapagamentofk;
            $v_pres = empty($pagamento->prescricaopagamentofk) ? null : $pagamento->prescricaopagamentofk;
            $v_ven = empty($pagamento->vendapagamentofk) ? null : $pagamento->vendapagamentofk;

            if ($v_cons) $query->bindValue(6, $v_cons, PDO::PARAM_INT); else $query->bindValue(6, null, PDO::PARAM_NULL);
            if ($v_pres) $query->bindValue(7, $v_pres, PDO::PARAM_INT); else $query->bindValue(7, null, PDO::PARAM_NULL);
            if ($v_ven) $query->bindValue(8, $v_ven, PDO::PARAM_INT); else $query->bindValue(8, null, PDO::PARAM_NULL);

            $query->execute();
            conexao::desconectar();
            return true;
        } catch(PDOException $exception) {
            return false; 
        }
    }

    public function read() {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT idpagamento, prestacoes, valor, data_pagamento, formapagamentofk, clientepagamentofk, consultapagamentofk, prescricaopagamentofk, vendapagamentofk FROM pagamento ORDER BY data_pagamento DESC";
            $result = $pdo->query($sql);
            $lista = [];
            foreach($result as $linha) {
                $lista[] = new pagamento(
                    $linha["idpagamento"], $linha["prestacoes"], $linha["valor"], $linha["data_pagamento"], 
                    $linha["formapagamentofk"], $linha["clientepagamentofk"],
                    $linha["consultapagamentofk"], $linha["prescricaopagamentofk"], $linha["vendapagamentofk"]
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
            $sql = "SELECT idpagamento, prestacoes, valor, data_pagamento, formapagamentofk, clientepagamentofk, consultapagamentofk, prescricaopagamentofk, vendapagamentofk FROM pagamento WHERE idpagamento = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idpagamento]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            if ($linha) {
                return new pagamento(
                    $linha["idpagamento"], $linha["prestacoes"], $linha["valor"], $linha["data_pagamento"], 
                    $linha["formapagamentofk"], $linha["clientepagamentofk"],
                    $linha["consultapagamentofk"], $linha["prescricaopagamentofk"], $linha["vendapagamentofk"]
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
            $sql = "UPDATE pagamento SET prestacoes = ?, valor = ?, data_pagamento = ?, formapagamentofk = ?, clientepagamentofk = ?, consultapagamentofk = ?, prescricaopagamentofk = ?, vendapagamentofk = ? WHERE idpagamento = ?";
            $query = $pdo->prepare($sql);
            
            $query->bindValue(1, $pagamento->prestacoes, PDO::PARAM_INT);
            $query->bindValue(2, $pagamento->valor, PDO::PARAM_STR);
            $query->bindValue(3, $pagamento->data_pagamento, PDO::PARAM_STR);
            $query->bindValue(4, $pagamento->formapagamentofk, PDO::PARAM_INT);
            $query->bindValue(5, $pagamento->clientepagamentofk, PDO::PARAM_INT);

            $v_cons = empty($pagamento->consultapagamentofk) ? null : $pagamento->consultapagamentofk;
            $v_pres = empty($pagamento->prescricaopagamentofk) ? null : $pagamento->prescricaopagamentofk;
            $v_ven = empty($pagamento->vendapagamentofk) ? null : $pagamento->vendapagamentofk;

            if ($v_cons) $query->bindValue(6, $v_cons, PDO::PARAM_INT); else $query->bindValue(6, null, PDO::PARAM_NULL);
            if ($v_pres) $query->bindValue(7, $v_pres, PDO::PARAM_INT); else $query->bindValue(7, null, PDO::PARAM_NULL);
            if ($v_ven) $query->bindValue(8, $v_ven, PDO::PARAM_INT); else $query->bindValue(8, null, PDO::PARAM_NULL);
            
            $query->bindValue(9, $pagamento->idpagamento, PDO::PARAM_INT);

            $query->execute();
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
