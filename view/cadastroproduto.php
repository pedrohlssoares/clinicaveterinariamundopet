<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "model/entity/produto.php";
include_once $base . "model/dao/produtodao.php";
include __DIR__ . "/topo.html";
$prodao = new produtodao();

if (isset($_SESSION["resultado"])) {
    $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
    echo "<div class='alert {$classe}'>{$_SESSION["mensagem"]}</div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}

if (isset($_GET["idproduto"])) {
    $result = $prodao->readId($_GET["idproduto"]);
} else {
    $result = ["idproduto" => "", "nome" => "", "quantidade" => "", "descricao" => "", "preco" => ""];
}
?>

<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 pt-4">
            <h2 class="text-center fw-light" style="color: var(--pet-green);">Cadastro de Produto</h2>
        </div>
        <div class="card-body p-4">
            <form method="post" action="/clinicaveterinariamundopet/controller/produtocontroller.php">
                <input type="hidden" name="idproduto" value="<?php echo $result["idproduto"] ?>">

                <div class="row justify-content-center">
                    <div class="col-md-6 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Dados do Produto</h4>
                        <div class="mb-3">
                            <input type="text" class="form-control custom-input" name="nome" placeholder="Nome do produto" value="<?php echo $result["nome"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control custom-input" name="quantidade" placeholder="Quantidade em estoque" value="<?php echo $result["quantidade"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control custom-input" name="descricao" placeholder="Descrição do produto" value="<?php echo $result["descricao"] ?>">
                        </div>
                        <div class="mb-3">
                            <input type="number" step="0.01" class="form-control custom-input" name="preco" placeholder="Preço (R$)" value="<?php echo $result["preco"] ?>" required>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Salvar Produto
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-5 mb-5">
        <h3 class="h4 mb-3 fw-light" style="color: var(--pet-dark);">Produtos Cadastrados</h3>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle mb-0 bg-white">
                <thead class="custom-thead text-white">
                    <tr>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Descrição</th>
                        <th>Preço</th>
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
                            echo "<tr>";
                            echo "<td class='fw-bold'>{$item->nome}</td>";
                            echo "<td>{$item->quantidade}</td>";
                            echo "<td>{$item->descricao}</td>";
                            echo "<td>R$ " . number_format($item->preco, 2, ',', '.') . "</td>";
                            echo "<td class='text-center'>";
                            echo "<a href='cadastroproduto.php?idproduto={$item->idproduto}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                            echo "<a href='/clinicaveterinariamundopet/controller/produtocontroller.php?idproduto={$item->idproduto}' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Deseja realmente excluir este produto?\")' title='Excluir'><img src='img/apagar.png' width='16'></a>";
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

<?php 
include __DIR__ . "/rodape.html"; 
?>