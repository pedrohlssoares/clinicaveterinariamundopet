<?php

include_once __DIR__ . "/../../config/conexao.php";

class petDao {

    public function create(pet $pet) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO pet(petcolnome, especie, raca, idade, clientepetfk) VALUES (?, ?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $pet->petcolnome,
                $pet->especie,
                $pet->raca,
                $pet->idade,
                $pet->clientepetfk
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
            $sql = "SELECT 
                        p.idpet,
                        p.petcolnome,
                        p.especie,
                        p.raca,
                        p.idade,
                        c.nome AS nome_dono
                    FROM pet p
                    INNER JOIN cliente c ON p.clientepetfk = c.idcliente
                    ORDER BY p.petcolnome";
            $result = $pdo->query($sql);
            $lista = [];
            foreach($result as $linha) {
                $lista[] = new pet(
                    $linha["idpet"],
                    $linha["petcolnome"],
                    $linha["especie"],
                    $linha["raca"],
                    $linha["idade"],
                    null,
                    $linha["nome_dono"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function readID($idpet) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT 
                        p.idpet,
                        p.petcolnome,
                        p.especie,
                        p.raca,
                        p.idade,
                        c.nome AS nome_dono
                    FROM pet p
                    INNER JOIN cliente c ON p.clientepetfk = c.idcliente
                    WHERE p.idpet = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idpet]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();

            if ($linha) {
                return new pet(
                    $linha["idpet"],
                    $linha["petcolnome"],
                    $linha["especie"],
                    $linha["raca"],
                    $linha["idade"],
                    null,
                    $linha["nome_dono"]
                );
            }
            return null;
        } catch(PDOException $exception) {
            return null;
        }
    }

    public function verHistorico($idpet) {
        try {
            $pdo = conexao::conectar();
            $historico = [
                "consultas" => [],
                "vacinas" => [],
                "prescricoes" => []
            ];

            $sqlConsultas = "SELECT 
                                con.idconsulta,
                                con.data,
                                con.horario,
                                con.processos_feitos,
                                f.nome AS nome_veterinario
                             FROM consulta con
                             INNER JOIN veterinario v ON con.veterinarioconsultafk = v.idveterinario
                             INNER JOIN funcionario f ON v.funcionarioveterinariofk = f.idfuncionario
                             WHERE con.petconsultafk = ?
                             ORDER BY con.data DESC, con.horario DESC";
            $queryConsultas = $pdo->prepare($sqlConsultas);
            $queryConsultas->execute([$idpet]);
            $historico["consultas"] = $queryConsultas->fetchAll(PDO::FETCH_ASSOC);

            $sqlVacinas = "SELECT 
                   prod.nome AS nome_vacina,
                   vac.lote,
                   vac.ativo,
                   h.data_aplicacao,
                   h.dosagem
                FROM historico_vacinacao h
                INNER JOIN vacina vac ON h.vacinahistorico_vacinacaofk = vac.idvacina
                INNER JOIN produto prod ON vac.produtovacinafk = prod.idproduto
                WHERE h.pethistorico_vacinacaofk = ?
                ORDER BY h.data_aplicacao DESC";

            $sqlPrescricoes = "SELECT 
                                   con.data AS data_consulta,
                                   prod.nome AS nome_remedio,
                                   pres.dosagem
                               FROM prescricao pres
                               INNER JOIN consulta con ON pres.consultaprescricaofk = con.idconsulta
                               INNER JOIN remedio rem ON pres.remedioprescricaofk = rem.idremedio
                               INNER JOIN produto prod ON rem.produtoremediofk = prod.idproduto
                               WHERE con.petconsultafk = ?
                               ORDER BY con.data DESC";
            $queryPrescricoes = $pdo->prepare($sqlPrescricoes);
            $queryPrescricoes->execute([$idpet]);
            $historico["prescricoes"] = $queryPrescricoes->fetchAll(PDO::FETCH_ASSOC);

            conexao::desconectar();
            return $historico;

        } catch (PDOException $exception) {
            return null;
        }
    }

    public function update(pet $pet) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE pet SET 
                        petcolnome = ?,
                        especie = ?,
                        raca = ?,
                        idade = ?,
                        clientepetfk = ?
                    WHERE idpet = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $pet->petcolnome, 
                $pet->especie,
                $pet->raca,
                $pet->idade,
                $pet->clientepetfk,
                $pet->idpet
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function delete($idpet) {
        try {
            $pdo = conexao::conectar();
            $sql = "DELETE FROM pet WHERE idpet = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idpet]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
}
?>