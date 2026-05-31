
<?php

include_once __DIR__ . "/../../config/conexao.php";

class clienteDao {

    public function create(cliente $cliente) {
        try {
            $pdo = conexao::conectar();
            $sql = "INSERT INTO cliente(nome, cpf, email, celular, enderecoclientefk) VALUES (?, ?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([
                $cliente->nome,
                $cliente->cpf,
                $cliente->email,
                $cliente->celular,
                $cliente->enderecoclientefk
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false; 
        }
    }

    // Traz todos os clientes com seus respectivos dados de endereço
    public function read() {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT 
                        c.idcliente,
                        c.nome,
                        c.cpf,
                        c.email,
                        c.celular,
                        e.rua,
                        e.cidade,
                        e.bairro,
                        e.numero,
                        e.complemento
                    FROM cliente c
                    INNER JOIN endereco e ON c.enderecoclientefk = e.idendereco
                    ORDER BY c.nome";
            $result = $pdo->query($sql);
            $lista = [];
            foreach ($result as $linha) {
                $lista[] = new cliente(
                    $linha["idcliente"],
                    $linha["nome"],
                    $linha["cpf"],
                    $linha["email"],
                    $linha["celular"],
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

    // Traz um cliente específico com seus dados de endereço
    public function readID($idcliente) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT 
                        c.idcliente,
                        c.nome,
                        c.cpf,
                        c.email,
                        c.celular,
                        e.rua,
                        e.cidade,
                        e.bairro,
                        e.numero,
                        e.complemento
                    FROM cliente c
                    INNER JOIN endereco e ON c.enderecoclientefk = e.idendereco
                    WHERE c.idcliente = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idcliente]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();

            if ($linha) {
                return new cliente(
                    $linha["idcliente"],
                    $linha["nome"],
                    $linha["cpf"],
                    $linha["email"],
                    $linha["celular"],
                    null,
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

    public function update(cliente $cliente) {
        try {
            $pdo = conexao::conectar();
            $sql = "UPDATE cliente SET 
                        nome = ?,
                        cpf = ?,
                        email = ?,
                        celular = ?,
                        enderecoclientefk = ?
                    WHERE idcliente = ?";
            $query = $pdo->prepare($sql);
            $query->execute([
                $cliente->nome, 
                $cliente->cpf,
                $cliente->email,
                $cliente->celular,
                $cliente->enderecoclientefk,
                $cliente->idcliente
            ]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function delete($idcliente) {
        try {
            $pdo = conexao::conectar();
            $sql = "DELETE FROM cliente WHERE idcliente = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idcliente]);
            conexao::desconectar();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
}

?>