<?php
include_once __DIR__ . "/../../config/conexao.php";

class historicoPetDao {
    
    public function buscarPetECliente($idpet) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT p.idpet, p.nome as pet_nome, p.raca, p.idade, p.especie, 
                           c.nome as dono_nome, c.cpf as dono_cpf, c.celular as dono_celular 
                    FROM pet p 
                    INNER JOIN cliente c ON p.clientepetfk = c.idcliente 
                    WHERE p.idpet = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idpet]);
            $resultado = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $resultado;
        } catch(PDOException $e) {
            return null;
        }
    }

    public function listarConsultas($idpet) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT c.idconsulta, c.data_consulta, c.horario, c.status, c.processos_feitos,
                           s.numero as sala_numero, s.tipo as sala_tipo
                    FROM consulta c 
                    LEFT JOIN sala s ON c.salaconsultafk = s.numero 
                    WHERE c.petconsultafk = ? 
                    ORDER BY c.data_consulta DESC, c.horario DESC";
            $query = $pdo->prepare($sql);
            $query->execute([$idpet]);
            $lista = $query->fetchAll(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $lista;
        } catch(PDOException $e) {
            return [];
        }
    }

    public function listarVacinas($idpet) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT hv.idhistorico, hv.data_aplicacao, hv.dosagem, v.ativo as vacina_nome 
                    FROM historico_vacinacao hv 
                    INNER JOIN vacina v ON hv.vacinahistorico_vacinacaofk = v.idvacina 
                    WHERE hv.pethistorico_vacinacaofk = ? 
                    ORDER BY hv.data_aplicacao DESC";
            $query = $pdo->prepare($sql);
            $query->execute([$idpet]);
            $lista = $query->fetchAll(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $lista;
        } catch(PDOException $e) {
            return [];
        }
    }

    public function listarVendas($idpet) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT v.idvenda, v.quantidade, v.valor_unitario, p.nome as produto_nome, pag.data_pagamento
                    FROM venda v 
                    INNER JOIN produto p ON v.produtovendafk = p.idproduto 
                    INNER JOIN pagamento pag ON v.pagamentovendafk = pag.idpagamento 
                    INNER JOIN consulta c ON pag.consultapagamentofk = c.idconsulta 
                    WHERE c.petconsultafk = ? 
                    ORDER BY pag.data_pagamento DESC";
            $query = $pdo->prepare($sql);
            $query->execute([$idpet]);
            $lista = $query->fetchAll(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $lista;
        } catch(PDOException $e) {
            return [];
        }
    }

    public function calcularTotalGasto($idpet) {
        try {
            $pdo = conexao::conectar();
            $sql = "SELECT SUM(pag.valor) as total_gasto 
                    FROM pagamento pag 
                    INNER JOIN consulta c ON pag.consultapagamentofk = c.idconsulta 
                    WHERE c.petconsultafk = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$idpet]);
            $linha = $query->fetch(PDO::FETCH_ASSOC);
            conexao::desconectar();
            return $linha["total_gasto"] ? floatval($linha["total_gasto"]) : 0.0;
        } catch(PDOException $e) {
            return 0.0;
        }
    }
}
?>