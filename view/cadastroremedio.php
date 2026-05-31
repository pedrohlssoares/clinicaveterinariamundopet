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
    echo "<div class='alert {$classe}'>{$_SESSION["mensagem"]}</div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}

if (isset($_GET["idremedio"])) {
    $result = $redao->readId($_GET["idremedio"]);
} else {
    $result = ["idremedio" => "", "ativo" => "", "lote" => "", "produtoremediofk" => ""];
}

$produtos = $prodao->read();
?>

<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 pt-4">
            <h2 class="text-center fw-light" style="color: var(--pet-green);">Cadastro de Remédio</h2>
        </div>
        <div class="card-body p-4">
            <form method="post" action="/clinicaveterinariamundopet/controller/remediocontroller.php">
                <input type="hidden" name="idremedio" value="<?php echo $result["idremedio"] ?>">

                <div class="row justify-content-center">
                    <div class="col-md-6 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Dados do Remédio</h4>
                        <div class="mb-3">
                            <input type="text" class="form-control custom-input" name="ativo" placeholder="Princípio ativo" value="<?php echo $result["ativo"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control custom-input" name="lote" placeholder="Número do lote" value="<?php echo $result["lote"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Produto vinculado</label>
                            <select class="form-select custom-input" name="produtoremediofk" required>
                                <option value="">— Selecione um produto —</option>
                                <?php foreach ($produtos as $produto): ?>
                                    <option value="<?php echo $produto->idproduto ?>"
                                        <?php echo ($result["produtoremediofk"] == $produto->idproduto) ? "selected" : "" ?>>
                                        <?php echo "[#{$produto->idproduto}] {$produto->nome} — R$ " . number_format($produto->preco, 2, ',', '.') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Salvar Remédio
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-5 mb-5">
        <h3 class="h4 mb-3 fw-light" style="color: var(--pet-dark);">Remédios Cadastrados</h3>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle mb-0 bg-white">
                <thead class="custom-thead text-white">
                    <tr>
                        <th>Ativo</th>
                        <th>Lote</th>
                        <th>Produto Vinculado</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
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
                            $produto = $prodao->readId($item->produtoremediofk);
                            $nomeProduto = $produto ? $produto["nome"] : "Não vinculado";
                            $precoProduto = $produto ? "R$ " . number_format($produto["preco"], 2, ',', '.') : "—";
                            $qtdProduto = $produto ? $produto["quantidade"] : "—";
                            echo "<tr>";
                            echo "<td class='fw-bold'>{$item->ativo}</td>";
                            echo "<td>{$item->lote}</td>";
                            echo "<td><span class='badge bg-light text-dark border'>{$nomeProduto}</span></td>";
                            echo "<td>{$precoProduto}</td>";
                            echo "<td>{$qtdProduto}</td>";
                            echo "<td class='text-center'>";
                            echo "<a href='cadastroremedio.php?idremedio={$item->idremedio}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                            echo "<a href='/clinicaveterinariamundopet/controller/remediocontroller.php?idremedio={$item->idremedio}' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Deseja realmente excluir este remédio?\")' title='Excluir'><img src='img/apagar.png' width='16'></a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>