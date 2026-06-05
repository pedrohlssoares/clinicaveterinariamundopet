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

if (!isset($_GET["idremedio"])) {
    header("location: gerenciaremedio.php");
    exit();
}

$rem_obj = $redao->readId($_GET["idremedio"]);

if (!$rem_obj) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Remédio não encontrado!</div></div>";
    include __DIR__ . "/rodape.html";
    exit();
}

// Suporte para o retorno ser um Array Associativo ou Objeto StdClass do DAO
$idremedio = is_object($rem_obj) ? $rem_obj->idremedio : $rem_obj["idremedio"];
$ativo = is_object($rem_obj) ? $rem_obj->ativo : $rem_obj["ativo"];
$lote = is_object($rem_obj) ? $rem_obj->lote : $rem_obj["lote"];
$produtoremediofk = is_object($rem_obj) ? $rem_obj->produtoremediofk : $rem_obj["produtoremediofk"];

$produtos = $prodao->read();
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light text-primary">✏️ Editar Remédio</h2>
        <a href="gerenciaremedio.php" class="btn btn-outline-secondary shadow-sm">
            Cancelar / Voltar
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/remediocontroller.php">
                <input type="hidden" name="idremedio" value="<?php echo $idremedio ?>">

                <div class="row justify-content-center">
                    <div class="col-md-6 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Dados do Remédio</h4>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Princípio Ativo</label>
                            <input type="text" class="form-control custom-input" name="ativo" value="<?php echo $ativo ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Número do Lote</label>
                            <input type="number" class="form-control custom-input" name="lote" value="<?php echo $lote ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Produto vinculado</label>
                            <select class="form-select custom-input" name="produtoremediofk" required>
                                <option value="">— Selecione um produto —</option>
                                <?php 
                                if ($produtos) {
                                    foreach ($produtos as $produto): 
                                        $id_prod = is_object($produto) ? $produto->idproduto : $produto["idproduto"];
                                        $nome_prod = is_object($produto) ? $produto->nome : $produto["nome"];
                                        $preco_prod = is_object($produto) ? $produto->preco : $produto["preco"];
                                        
                                        $selected = ($produtoremediofk == $id_prod) ? "selected" : "";
                                ?>
                                        <option value="<?php echo $id_prod ?>" <?php echo $selected ?>>
                                            <?php echo "[#{$id_prod}] {$nome_prod} — R$ " . number_format($preco_prod, 2, ',', '.') ?>
                                        </option>
                                <?php 
                                    endforeach; 
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Atualizar Remédio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>