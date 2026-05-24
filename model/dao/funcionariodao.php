<?php

include_once __DIR__ . "/../../config/conexao.php";

class funcionarioDao {

    public function create(funcionario $funcionario) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO funcionario(nome, celular, cpf, salario, enderecofuncionariofk) VALUES (?, ?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $funcionario->nome,
                $funcionario->celular,
                $funcionario->cpf,
                $funcionario->salario,
                $funcionario->enderecofuncionariofk
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
            $sql = "SELECT * FROM funcionario ORDER BY nome";
            $result = $pdo->query($sql);
            $lista = [];
            foreach ($result as $linha) {
                $lista[] = new funcionario(
                    $linha["idfuncionario"],    
                    $linha["nome"],
                    $linha["celular"],
                    $linha["cpf"],
                    $linha["salario"],
                    $linha["enderecofuncionariofk"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch (PDOException $exception) {
            return null;
        }
    }

    public function readID($idfuncionario) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT * FROM funcionario WHERE idfuncionario = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idfuncionario]);
            $lista = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $lista;
        } catch (PDOException $exception) {
            return null;
        }
    }

    public function update(funcionario $funcionario) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE funcionario SET 
                    nome = ?,
                    celular = ?,
                    cpf = ?,
                    salario = ?,
                    enderecofuncionariofk = ?
                    WHERE idfuncionario = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $funcionario->nome, 
                $funcionario->celular,
                $funcionario->cpf,
                $funcionario->salario,
                $funcionario->enderecofuncionariofk,
                $funcionario->idfuncionario
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function delete($idfuncionario) {
        try {
            $pdo = conexao::conectar();
            $sql = "DELETE FROM funcionario WHERE idfuncionario = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idfuncionario]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
}

?>