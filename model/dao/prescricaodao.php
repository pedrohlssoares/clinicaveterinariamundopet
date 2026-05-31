<?php

include_once __DIR__ . "/../../config/conexao.php";

class prescricaoDao {

    public function create(prescricao $prescricao) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO prescricao(consultaprescricaofk, remedioprescricaofk, dosagem) VALUES (?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $prescricao->consultaprescricaofk,
                $prescricao->remedioprescricaofk,
                $prescricao->dosagem
            ]);
            conexao::desconectar();
            return true;
        } catch(PDOException $exception) {
            return false; 
        }
    }

    public function readPorprescricao($idconsulta) {
        try {
            $pdo = conexao::conectar();
            
            $sql = "SELECT 
                        pre.idprescricao,
                        pre.dosagem,
                        prod.nome AS nome_medicamento,
                        prod.descricao AS descricao_produto,
                        rem.ativo AS principio_ativo
                    FROM prescricao pre
                    INNER JOIN remedio rem ON pre.remedioprescricaofk = rem.idremedio
                    INNER JOIN produto prod ON rem.produtoremediofk = prod.idproduto
                    WHERE pre.consultaprescricaofk = ?
                    ORDER BY prod.nome";
                    
            $query = $pdo->prepare($sql);
            $query->execute([$idconsulta]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            
            $lista = [];
            foreach($result as $linha) {
                $lista[] = new prescricao(
                    $linha["idprescricao"],
                    null,
                    null,
                    $linha["dosagem"],
                    $linha["nome_medicamento"],
                    $linha["principio_ativo"],
                    $linha["descricao_produto"]
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
            $sql = "SELECT 
                        pre.*,
                        prod.nome AS nome_medicamento,
                        prod.descricao AS descricao_produto,
                        rem.ativo AS principio_ativo
                    FROM prescricao pre
                    INNER JOIN remedio rem ON pre.remedioprescricaofk = rem.idremedio
                    INNER JOIN produto prod ON rem.produtoremediofk = prod.idproduto
                    WHERE pre.idprescricao = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idprescricao]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();

            if ($linha) {
                return new prescricao(
                    $linha["idprescricao"],
                    null,
                    null,
                    $linha["dosagem"],
                    $linha["nome_medicamento"],
                    $linha["principio_ativo"],
                    $linha["descricao_produto"]
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
            $sql = "UPDATE prescricao SET 
                        consultaprescricaofk = ?,
                        remedioprescricaofk = ?,
                        dosagem = ?
                    WHERE idprescricao = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $prescricao->consultaprescricaofk, 
                $prescricao->remedioprescricaofk,
                $prescricao->dosagem,
                $prescricao->idprescricao
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