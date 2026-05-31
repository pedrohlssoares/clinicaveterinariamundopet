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

    // Traz todos os funcionários com seus respectivos dados de endereço
    public function read() {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT 
                        f.idfuncionario,
                        f.nome,
                        f.celular,
                        f.cpf,
                        f.salario,
                        e.rua,
                        e.cidade,
                        e.bairro,
                        e.numero,
                        e.complemento
                    FROM funcionario f
                    INNER JOIN endereco e ON f.enderecofuncionariofk = e.idendereco
                    ORDER BY f.nome";
            $result = $pdo->query($sql);
            $lista = [];
            foreach ($result as $linha) {
                $lista[] = new funcionario(
                    $linha["idfuncionario"],
                    $linha["nome"],
                    $linha["celular"],
                    $linha["cpf"],
                    $linha["salario"],
                    null, // Chave estrangeira passada como nula
                    $linha["rua"],
                    $linha["cidade"],
                    $linha["bairro"],
                    $linha["numero"],
                    $linha["complemento"]
                );
            }
            conexao::desconectar();
            return $lista;
        } catch (PDOException $exception) {
            return null;
        }
    }

    // Traz um funcionário específico modificado para retornar o objeto
    public function readID($idfuncionario) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT 
                        f.idfuncionario,
                        f.nome,
                        f.celular,
                        f.cpf,
                        f.salario,
                        e.rua,
                        e.cidade,
                        e.bairro,
                        e.numero,
                        e.complemento
                    FROM funcionario f
                    INNER JOIN endereco e ON f.enderecofuncionariofk = e.idendereco
                    WHERE f.idfuncionario = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idfuncionario]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();

            if ($linha) {
                return new funcionario(
                    $linha["idfuncionario"],
                    $linha["nome"],
                    $linha["celular"],
                    $linha["cpf"],
                    $linha["salario"],
                    null, // Chave estrangeira passada como nula
                    $linha["rua"],
                    $linha["cidade"],
                    $linha["bairro"],
                    $linha["numero"],
                    $linha["complemento"]
                );
            }
            return null;
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