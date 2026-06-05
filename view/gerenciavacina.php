<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "model/entity/vacina.php";
include_once $base . "model/dao/vacinadao.php";
include_once $base . "model/entity/produto.php";
include_once $base . "model/dao/produtodao.php";

include __DIR__ . "/topo.html";

$vacdao = new vacinaDao();
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
        <h2 class="fw-light" style="color: var(--pet-dark);">Gerenciar Vacinas</h2>
        <a href="cadastrovacina.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> + Nova Vacina
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th>Nome / Princípio Ativo</th>
                    <th>Lote</th>
                    <th>Produto Vinculado (Estoque)</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $vacdao->read();
                
                if (is_null($result) || empty($result)) {
                    echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Nenhuma vacina cadastrada.</td></tr>";
                } else {
                    foreach ($result as $item) {
                        $idvacina = is_object($item) ? $item->idvacina : $item["idvacina"];
                        $ativo = is_object($item) ? $item->ativo : $item["ativo"];
                        $lote = is_object($item) ? $item->lote : $item["lote"];
                        $fk_prod = is_object($item) ? $item->produtovacinafk : $item["produtovacinafk"];

                        $prod_obj = $prodao->readId($fk_prod);
                        $nome_prod = "Desconhecido";
                        $qtd_prod = "—";
                        
                        if ($prod_obj) {
                            $nome_prod = is_object($prod_obj) ? $prod_obj->nome : $prod_obj["nome"];
                            $qtd_prod = is_object($prod_obj) ? $prod_obj->quantidade : $prod_obj["quantidade"];
                        }

                        $badge_estoque = ($qtd_prod !== "—" && $qtd_prod <= 5) ? "bg-danger" : "bg-info text-dark";

                        echo "<tr>";
                        echo "<td class='fw-bold'>{$ativo}</td>";
                        echo "<td>{$lote}</td>";
                        echo "<td>{$nome_prod} <span class='badge {$badge_estoque} ms-2'>Estoque: {$qtd_prod}</span></td>";
                        echo "<td class='text-center'>";
                        echo "<a href='editarvacina.php?idvacina={$idvacina}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                        echo "<a href='../controller/vacinacontroller.php?idvacina={$idvacina}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Deseja realmente excluir esta vacina?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
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