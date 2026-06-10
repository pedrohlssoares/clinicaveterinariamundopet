<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/produto.php";
include_once $base . "entity/dao/produtodao.php";

include __DIR__ . "/topo.html";

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
        <h2 class="fw-light" style="color: var(--pet-dark);">Gerenciar Produtos</h2>
        <a href="cadastroproduto.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> Novo Produto
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th>Nome do Produto</th>
                    <th>Quantidade</th>
                    <th>Descrição</th>
                    <th>Preço Unitário</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $prodao->read();
                
                if (is_null($result) || empty($result)) {
                    echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Nenhum produto cadastrado no sistema.</td></tr>";
                } else {
                    foreach ($result as $item) {
                        $badge_estoque = ($item->quantidade <= 5) ? "bg-danger" : "bg-light text-dark border";

                        echo "<tr>";
                        echo "<td class='fw-bold'>{$item->nome}</td>";
                        echo "<td><span class='badge {$badge_estoque}'>{$item->quantidade} un</span></td>";
                        echo "<td>{$item->descricao}</td>";
                        echo "<td class='text-success fw-bold'>R$ " . number_format($item->preco, 2, ',', '.') . "</td>";
                        echo "<td class='text-center'>";
                        echo "<a href='editarproduto.php?idproduto={$item->idproduto}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                        echo "<a href='../controller/produtocontroller.php?idproduto={$item->idproduto}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Deseja realmente excluir este produto?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
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
