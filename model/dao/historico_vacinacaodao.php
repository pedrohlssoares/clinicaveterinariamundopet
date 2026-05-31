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
        } catch (PDOException $exception) {
            return false; 
        }
    }

    public function read() {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT 
                        h.idhistorico,
                        h.data_aplicacao,
                        h.dosagem,
                        p.petcolnome AS nome_pet,
                        prod.nome AS nome_vacina
                    FROM historico_vacinacao h
                    INNER JOIN pet p ON h.pethistorico_vacinacaofk = p.idpet
                    INNER JOIN vacina v ON h.vacinahistorico_vacinacaofk = v.idvacina
                    INNER JOIN produto prod ON v.produtovacinafk = prod.idproduto
                    ORDER BY h.data_aplicacao DESC";
            $result = $pdo->query($sql);
            $lista = [];
            foreach ($result as $linha) {
                $lista[] = new historico_vacinacao(
                    $linha["idhistorico"],    
                    null,
                    null,
                    $linha["data_aplicacao"],
                    $linha["dosagem"],
                    $linha["nome_pet"],
                    $linha["nome_vacina"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch (PDOException $exception) {
            return null;
        }
    }

    public function readID($idhistorico) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT 
                        h.*,
                        p.petcolnome AS nome_pet,
                        prod.nome AS nome_vacina
                    FROM historico_vacinacao h
                    INNER JOIN pet p ON h.pethistorico_vacinacaofk = p.idpet
                    INNER JOIN vacina v ON h.vacinahistorico_vacinacaofk = v.idvacina
                    INNER JOIN produto prod ON v.produtovacinafk = prod.idproduto
                    WHERE h.idhistorico = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idhistorico]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();

            if ($linha) {
                return new historico_vacinacao(
                    $linha["idhistorico"],    
                    null,
                    null,
                    $linha["data_aplicacao"],
                    $linha["dosagem"],
                    $linha["nome_pet"],
                    $linha["nome_vacina"]
                );
            }
            return null;
        } catch (PDOException $exception) {
            return null;
        }
    }

    public function update(historico_vacinacao $historico) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE historico_vacinacao SET 
                        pethistorico_vacinacaofk = ?,
                        vacinahistorico_vacinacaofk = ?,
                        data_aplicacao = ?,
                        dosagem = ?
                    WHERE idhistorico = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $historico->pethistorico_vacinacaofk, 
                $historico->vacinahistorico_vacinacaofk,
                $historico->data_aplicacao,
                $historico->dosagem,
                $historico->idhistorico
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