<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/venda.php";
include_once $base . "entity/dao/vendadao.php";
include_once $base . "entity/model/produto.php";
include_once $base . "entity/dao/produtodao.php";

include __DIR__ . "/topo.html";

$vdao = new vendaDao();
$prodao = new produtodao();

if (isset($_SESSION["resultado"])) {
    $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
    echo "<div class='container mt-3'><div class='alert {$classe} shadow-sm'>{$_SESSION["mensagem"]}</div></div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-dark);">Gerenciamento de Vendas (Balcão)</h2>
        <a href="cadastrovenda.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i>Lançar Nova Venda
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th>Código da Venda</th>
                    <th>Produto Vendido</th>
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
                    echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Nenhum item de venda lançado.</td></tr>";
                } else {
                    foreach ($lista as $item) {
                        $idvenda = is_object($item) ? $item->idvenda : $item["idvenda"];
                        $produtofk = is_object($item) ? $item->produtovendafk : $item["produtovendafk"];
                        $qtd = is_object($item) ? $item->quantidade : $item["quantidade"];
                        $preco = is_object($item) ? $item->valor_unitario : $item["valor_unitario"];

                        $prod_obj = $prodao->readId($produtofk);
                        $nome_produto = $prod_obj ? (is_object($prod_obj) ? $prod_obj->nome : $prod_obj["nome"]) : "Produto Removido";

                        $subtotal = $qtd * $preco;

                        echo "<tr>";
                        echo "<td><span class='badge bg-light text-dark border'>Venda #{$idvenda}</span></td>";
                        echo "<td class='text-primary fw-bold'>{$nome_produto}</td>";
                        echo "<td>{$qtd} un</td>";
                        echo "<td>R$ " . number_format($preco, 2, ',', '.') . "</td>";
                        echo "<td class='fw-bold text-success'>R$ " . number_format($subtotal, 2, ',', '.') . "</td>";
                        echo "<td class='text-center'>";
                        echo "<a href='editarvenda.php?idvenda={$idvenda}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                        echo "<a href='../controller/vendacontroller.php?idvenda={$idvenda}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Deseja excluir esta venda?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
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
