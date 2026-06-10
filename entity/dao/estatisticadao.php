<?php
include_once __DIR__ . "/../../config/conexao.php";

class estatisticaDao {
    
    public function obterIndicadoresGerais() {
        try {
            $pdo = conexao::conectar();
            $indicadores = [];

            $sql = "SELECT SUM(valor) as total FROM pagamento";
            $res = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            $indicadores['total_faturado'] = $res['total'] ? floatval($res['total']) : 0.0;

            $sql = "SELECT SUM(preco) as total FROM despesa";
            $res = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            $indicadores['total_despesas'] = $res['total'] ? floatval($res['total']) : 0.0;

            $indicadores['balanco_liquido'] = $indicadores['total_faturado'] - $indicadores['total_despesas'];


            $sql = "SELECT SUM(quantidade * valor_unitario) as total FROM venda";
            $res = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            $indicadores['faturamento_vendas'] = $res['total'] ? floatval($res['total']) : 0.0;

            $sql = "SELECT SUM(quantidade) as total FROM venda";
            $res = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            $indicadores['qtd_itens_vendidos'] = $res['total'] ? intval($res['total']) : 0;

            $sql = "SELECT COUNT(*) as total FROM produto";
            $res = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            $indicadores['total_produtos'] = intval($res['total']);

            $sql = "SELECT SUM(quantidade) as total FROM produto";
            $res = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            $indicadores['estoque_total_produtos'] = $res['total'] ? intval($res['total']) : 0;

            $sql = "SELECT COUNT(*) as total FROM cliente";
            $res = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            $indicadores['total_clientes'] = intval($res['total']);

            $sql = "SELECT COUNT(*) as total FROM pet";
            $res = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            $indicadores['total_pets'] = intval($res['total']);

            $sql = "SELECT COUNT(*) as total FROM consulta";
            $res = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            $indicadores['total_consultas'] = intval($res['total']);

            $sql = "SELECT COUNT(*) as total FROM remedio";
            $res = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            $indicadores['total_remedios'] = intval($res['total']);

            $sql = "SELECT COUNT(*) as total FROM vacina";
            $res = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            $indicadores['total_vacinas'] = intval($res['total']);

            $sql = "SELECT COUNT(*) as total FROM historico_vacinacao";
            $res = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
            $indicadores['total_aplicacoes_vacina'] = intval($res['total']);

            conexao::desconectar();
            return $indicadores;

        } catch(PDOException $e) {
            return null;
        }
    }
}
?>