<?php

include_once __DIR__ . "/../../config/conexao.php";

class consultaDao{


public function create(consulta $consulta){
    try{
        $pdo = conexao::conectar();
        $sql = "INSERT INTO consulta(petconsultafk, veterinarioconsultafk, salaconsultafk, data, processos_feitos) VALUES (?, ?, ?, ?, ?)";
        $query = $pdo->prepare($sql);
        $query->execute([
            $consulta->petconsultafk,
            $consulta->veterinarioconsultafk,
            $consulta->salaconsultafk,
            $consulta->data,
            $consulta->processos_feitos]);
        conexao::desconectar();
        return True;
    }catch(PDOException $exception){
        return False; 
    }
}

public function read(){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT 
                    con.idconsulta, 
                    con.data, 
                    con.processos_feitos,
                    p.nome AS nome_pet,
                    f.nome AS nome_veterinario,
                    s.numero AS numero_sala
                FROM consulta con
                INNER JOIN pet p ON con.petconsultafk = p.idpet
                INNER JOIN veterinario v ON con.veterinarioconsultafk = v.idveterinario
                INNER JOIN funcionario f ON v.funcionarioveterinariofk = f.idfuncionario
                INNER JOIN sala s ON con.salaconsultafk = s.numero
                ORDER BY con.data";
        $result = $pdo->query($sql);
        $lista = [];
        foreach($result as $linha){
            $lista[] = new consulta(
                $linha["idconsulta"],
                null,
                null,
                null,
                $linha["data"],
                $linha["processos_feitos"],
                $linha["nome_pet"],
                $linha["nome_veterinario"],
                $linha["numero_sala"]
            );
        }
        
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return Null;
    }
}

public function readID($idconsulta){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT * FROM consulta WHERE idconsulta = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idconsulta]);
        $lista = $query->fetch(PDO::FETCH_ASSOC);
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return null;
    }
}

public function readPorPet($petconsultafk){
    try{
        $pdo = conexao::conectar();
        $sql = "SELECT 
                    con.idconsulta,
                    con.data,
                    con.processos_feitos,
                    f.nome AS nome_veterinario
                FROM consulta con
                INNER JOIN veterinario v ON con.veterinarioconsultafk = v.idveterinario
                INNER JOIN funcionario f ON v.funcionarioveterinariofk = f.idfuncionario
                WHERE con.petconsultafk = ?
                ORDER BY con.data DESC";
        $query = $pdo->prepare($sql);
        $query->execute([$petconsultafk]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $lista = [];
        foreach($result as $linha){
            $lista[] = new consulta(
                $linha["idconsulta"],
                null,
                null,
                null,
                $linha["data"],
                $linha["processos_feitos"],
                null,
                $linha["nome_veterinario"],
                null
            );
        }       
        conexao::desconectar();
        return $lista;
    }catch(PDOException $exception){
        return Null;
    }
}

public function update(consulta $consulta){
    try{
        $pdo = conexao::conectar();
        $sql = "UPDATE consulta SET 
        petconsultafk = ?,
        veterinarioconsultafk = ?,
        salaconsultafk = ?,
        data = ?,
        processos_feitos = ?
        WHERE idconsulta = ?";
        $query = $pdo->prepare($sql);
        $query->execute([
            $consulta->petconsultafk, 
            $consulta->veterinarioconsultafk,
            $consulta->salaconsultafk,
            $consulta->data,
            $consulta->processos_feitos,
            $consulta->idconsulta]);
        conexao::desconectar();
        return true;
    }catch (PDOException $exception){
        return false;
    }
}

public function delete($idconsulta){
    try{
        $pdo = conexao::conectar();
        $sql = "DELETE FROM consulta WHERE idconsulta = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$idconsulta]);
        conexao::desconectar();
        return true;
    } catch (PDOException $exception){
        return false;
    }

}
}

?>