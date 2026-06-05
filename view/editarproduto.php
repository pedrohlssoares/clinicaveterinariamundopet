<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "model/entity/produto.php";
include_once $base . "model/dao/produtodao.php";

include __DIR__ . "/topo.html";

$prodao = new produtodao();

if (!isset($_GET["idproduto"])) {
    header("location: gerenciaproduto.php");
    exit();
}

$pro_obj = $prodao->readId($_GET["idproduto"]);

if (!$pro_obj) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Produto não encontrado!</div></div>";
    include __DIR__ . "/rodape.html";
    exit();
}
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light text-primary">✏️ Editar Produto</h2>
        <a href="gerenciaproduto.php" class="btn btn-outline-secondary shadow-sm">
            Cancelar / Voltar
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/produtocontroller.php">
                
                <input type="hidden" name="idproduto" value="<?php echo $pro_obj->idproduto ?>">

                <div class="row justify-content-center">
                    <div class="col-md-6 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Dados do Produto</h4>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Nome do Produto</label>
                            <input type="text" class="form-control custom-input" name="nome" value="<?php echo htmlspecialchars($pro_obj->nome) ?>" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Preço (R$)</label>
                                <input type="number" step="0.01" class="form-control custom-input" name="preco" value="<?php echo $pro_obj->preco ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Qtd em Estoque</label>
                                <input type="number" class="form-control custom-input" name="quantidade" value="<?php echo $pro_obj->quantidade ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Descrição do Produto</label>
                            <textarea class="form-control custom-input" name="descricao" rows="3"><?php echo htmlspecialchars($pro_obj->descricao) ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Atualizar Dados do Produto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>
