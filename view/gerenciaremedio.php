<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "model/entity/remedio.php";
include_once $base . "model/dao/remediodao.php";
include_once $base . "model/entity/produto.php";
include_once $base . "model/dao/produtodao.php";
include __DIR__ . "/topo.html";

$redao = new remediodao();
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
        <h2 class="fw-light" style="color: var(--pet-dark);">Gerenciar Remédios</h2>
        <a href="cadastroremedio.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> Novo Remédio
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th>Princípio Ativo</th>
                    <th>Lote</th>
                    <th>Produto Vinculado</th>
                    <th>Preço Unitário</th>
                    <th>Estoque Restante</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $redao->read();
                if (is_null($result) || empty($result)) {
                    echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Nenhum remédio cadastrado no sistema.</td></tr>";
                } else {
                    foreach ($result as $item) {
                        // Tolerância a Array ou Objeto da lista de Remédios
                        $fk_produto = is_object($item) ? $item->produtoremediofk : $item["produtoremediofk"];
                        $id_remedio = is_object($item) ? $item->idremedio : $item["idremedio"];
                        $ativo = is_object($item) ? $item->ativo : $item["ativo"];
                        $lote = is_object($item) ? $item->lote : $item["lote"];

                        $produto = $prodao->readId($fk_produto);
                        
                        // Tolerância a Array ou Objeto ao ler o Produto vinculado
                        $nomeProduto = "Não vinculado";
                        $precoProduto = "—";
                        $qtdProduto = "—";
                        
                        if ($produto) {
                            $nomeProduto = is_object($produto) ? $produto->nome : $produto["nome"];
                            $preco = is_object($produto) ? $produto->preco : $produto["preco"];
                            $qtdProduto = is_object($produto) ? $produto->quantidade : $produto["quantidade"];
                            $precoProduto = "R$ " . number_format($preco, 2, ',', '.');
                        }

                        echo "<tr>";
                        echo "<td class='fw-bold'>{$ativo}</td>";
                        echo "<td>{$lote}</td>";
                        echo "<td><span class='badge bg-light text-dark border'>{$nomeProduto}</span></td>";
                        echo "<td class='text-success fw-bold'>{$precoProduto}</td>";
                        
                        $badge_class = ($qtdProduto !== "—" && $qtdProduto <= 5) ? "bg-danger" : "bg-info text-dark";
                        echo "<td><span class='badge {$badge_class}'>{$qtdProduto} un</span></td>";
                        
                        echo "<td class='text-center'>";
                        echo "<a href='editarremedio.php?idremedio={$id_remedio}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                        echo "<a href='../controller/remediocontroller.php?idremedio={$id_remedio}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Deseja realmente excluir este remédio?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
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
