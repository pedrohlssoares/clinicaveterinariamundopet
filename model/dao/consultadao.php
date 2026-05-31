<?php

include_once __DIR__ . "/../../config/conexao.php";

class consultaDao {

    public function create(consulta $consulta) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO consulta(petconsultafk, veterinarioconsultafk, salaconsultafk, data, horario, processos_feitos) VALUES (?, ?, ?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $consulta->petconsultafk,
                $consulta->veterinarioconsultafk,
                $consulta->salaconsultafk,
                $consulta->data,
                $consulta->horario, 
                $consulta->processos_feitos
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false; 
        }
    }

    // Traz TODAS as consultas do banco
    public function read() {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT 
                        con.idconsulta, 
                        con.data, 
                        con.horario, 
                        con.processos_feitos,
                        p.petcolnome AS petcolnome,
                        f.nome AS nome_veterinario,
                        s.numero AS numero_sala
                    FROM consulta con
                    INNER JOIN pet p ON con.petconsultafk = p.idpet
                    INNER JOIN veterinario v ON con.veterinarioconsultafk = v.idveterinario
                    INNER JOIN funcionario f ON v.funcionarioveterinariofk = f.idfuncionario
                    INNER JOIN sala s ON con.salaconsultafk = s.numero
                    ORDER BY con.data, con.horario"; 
            $result = $pdo->query($sql);
            $lista = [];
            foreach ($result as $linha) {
                $lista[] = new consulta(
                    $linha["idconsulta"],
                    null,
                    null,
                    null,
                    $linha["data"],
                    $linha["horario"], 
                    $linha["processos_feitos"],
                    $linha["petcolnome"],
                    $linha["nome_veterinario"],
                    $linha["numero_sala"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch (PDOException $exception) {
            return null;
        }
    }

    // Traz as consultas de um dia ESPECÍFICO
    public function readPorData($data) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT 
                        con.idconsulta, 
                        con.data, 
                        con.horario, 
                        con.processos_feitos,
                        p.petcolnome AS petcolnome,
                        f.nome AS nome_veterinario,
                        s.numero AS numero_sala
                    FROM consulta con
                    INNER JOIN pet p ON con.petconsultafk = p.idpet
                    INNER JOIN veterinario v ON con.veterinarioconsultafk = v.idveterinario
                    INNER JOIN funcionario f ON v.funcionarioveterinariofk = f.idfuncionario
                    INNER JOIN sala s ON con.salaconsultafk = s.numero
                    WHERE con.data = ?
                    ORDER BY con.horario"; 
            $query = $pdo->prepare($sql);
            $query->execute([$data]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $lista = [];
            foreach ($result as $linha) {
                $lista[] = new consulta(
                    $linha["idconsulta"],
                    null,
                    null,
                    null,
                    $linha["data"],
                    $linha["horario"], 
                    $linha["processos_feitos"],
                    $linha["petcolnome"],
                    $linha["nome_veterinario"],
                    $linha["numero_sala"]
                );
            }       
            conexao::desconectar();
            return $lista;
        } catch (PDOException $exception) {
            return null;
        }
    }

    // Traz o histórico de consultas de um PET específico
    public function readPorPet($petconsultafk) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT 
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
            $query = $pdo->prepare($sql);
            $query->execute([$petconsultafk]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $lista = [];
            foreach ($result as $linha) {
                $lista[] = new consulta(
                    $linha["idconsulta"],
                    null,
                    null,
                    null,
                    $linha["data"],
                    $linha["horario"], 
                    $linha["processos_feitos"],
                    null,
                    $linha["nome_veterinario"],
                    null
                );
            }       
            conexao::desconectar();
            return $lista;
        } catch (PDOException $exception) {
            return null;
        }
    }

    public function readID($idconsulta) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT 
                        con.idconsulta, 
                        con.data, 
                        con.horario, 
                        con.processos_feitos,
                        p.petcolnome AS petcolnome,
                        f.nome AS nome_veterinario,
                        s.numero AS numero_sala
                    FROM consulta con
                    INNER JOIN pet p ON con.petconsultafk = p.idpet
                    INNER JOIN veterinario v ON con.veterinarioconsultafk = v.idveterinario
                    INNER JOIN funcionario f ON v.funcionarioveterinariofk = f.idfuncionario
                    INNER JOIN sala s ON con.salaconsultafk = s.numero
                    WHERE con.idconsulta = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idconsulta]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();

            if ($linha) {
                return new consulta(
                    $linha["idconsulta"],
                    null,
                    null,
                    null,
                    $linha["data"],
                    $linha["horario"], 
                    $linha["processos_feitos"],
                    $linha["petcolnome"],
                    $linha["nome_veterinario"],
                    $linha["numero_sala"]
                );
            }
            return null;
        } catch (PDOException $exception) {
            return null;
        }
    }

    public function update(consulta $consulta) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE consulta SET 
                        petconsultafk = ?,
                        veterinarioconsultafk = ?,
                        salaconsultafk = ?,
                        data = ?,
                        horario = ?, 
                        processos_feitos = ?
                    WHERE idconsulta = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $consulta->petconsultafk, 
                $consulta->veterinarioconsultafk,
                $consulta->salaconsultafk,
                $consulta->data,
                $consulta->horario, 
                $consulta->processos_feitos,
                $consulta->idconsulta
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function delete($idconsulta) {
        try {
            $pdo = conexao::conectar();
            $sql = "DELETE FROM consulta WHERE idconsulta = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idconsulta]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
}
?>