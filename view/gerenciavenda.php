<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";

include_once $base ."entity/model/venda.php";
include_once $base ."entity/dao/vendadao.php";
include_once $base ."entity/model/produto.php";
include_once $base ."entity/dao/produtodao.php";
include_once $base ."entity/model/pagamento.php";
include_once $base ."entity/dao/pagamentodao.php";
include_once $base ."entity/model/cliente.php";
include_once $base ."entity/dao/clientedao.php";

include __DIR__ . "/topo.html";

$vdao = new vendaDao();
$prodao = new produtodao();
$pagdao = new pagamentoDao();
$clidao = new clienteDao();

if (isset($_SESSION["resultado"])) {
    $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
    echo "<div class='container mt-3'><div class='alert {$classe} shadow-sm'>{$_SESSION["mensagem"]}</div></div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-dark);">Gerenciamento de Itens Vendidos (Itens de Cupom)</h2>
        <a href="cadastrovenda.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i>Lançar Item de Venda
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th>Fatura Origem</th>
                    <th>Cliente / Comprador</th>
                    <th>Produto</th>
                    <th>Qtd</th>
                    <th>Preço Unitário</th>
                    <th>Subtotal</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lista = $vdao->read();
                
                if (is_null($lista) || empty($lista)) {
                    echo "<tr><td colspan='7' class='text-center py-4 text-muted'>Nenhum item de venda lançado.</td></tr>";
                } else {
                    foreach ($lista as $item) {
                        $idvenda = is_object($item) ? $item->idvenda : $item["idvenda"];
                        $pagamentofk = is_object($item) ? $item->pagamentovendafk : $item["pagamentovendafk"];
                        $produtofk = is_object($item) ? $item->produtovendafk : $item["produtovendafk"];
                        $qtd = is_object($item) ? $item->quantidade : $item["quantidade"];
                        $preco = is_object($item) ? $item->valor_unitario : $item["valor_unitario"];

                        // Relacional: Busca dados do produto
                        $prod_obj = $prodao->readId($produtofk);
                        $nome_produto = $prod_obj ? (is_object($prod_obj) ? $prod_obj->nome : $prod_obj["nome"]) : "Produto Removido";

                        // Relacional: Busca dados do pagamento e comprador
                        $pag_obj = method_exists($pagdao, 'readID') ? $pagdao->readID($pagamentofk) : $pagdao->readId($pagamentofk);
                        $nome_cliente = "Desconhecido";
                        if ($pag_obj) {
                            $clifk = is_object($pag_obj) ? $pag_obj->clientepagamentofk : $pag_obj["clientepagamentofk"];
                            $cli_obj = $clidao->readId($clifk);
                            $nome_cliente = $cli_obj ? (is_object($cli_obj) ? $cli_obj->nome : $cli_obj["nome"]) : "Cliente";
                        }

                        $subtotal = $qtd * $preco;

                        echo "<tr>";
                        echo "<td><span class='badge bg-light text-dark border'>Fatura #{$pagamentofk}</span></td>";
                        echo "<td class='fw-bold'>{$nome_cliente}</td>";
                        echo "<td class='text-primary'>{$nome_produto}</td>";
                        echo "<td>{$qtd} un</td>";
                        echo "<td>R$ " . number_format($preco, 2, ',', '.') . "</td>";
                        echo "<td class='fw-bold text-success'>R$ " . number_format($subtotal, 2, ',', '.') . "</td>";
                        echo "<td class='text-center'>";
                        echo "<a href='editarvenda.php?idvenda={$idvenda}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                        echo "<a href='../controller/vendacontroller.php?idvenda={$idvenda}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Deseja excluir este item de venda?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>