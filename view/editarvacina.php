<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/vacina.php";
include_once $base . "entity/dao/vacinadao.php";
include_once $base . "entity/model/produto.php";
include_once $base . "entity/dao/produtodao.php";

include __DIR__ . "/topo.html";

$vacdao = new vacinaDao();
$prodao = new produtodao();

if (!isset($_GET["idvacina"])) {
    header("location: gerenciavacina.php");
    exit();
}

$vac_obj = $vacdao->readId($_GET["idvacina"]);

if (!$vac_obj) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Vacina não encontrada!</div></div>";
    include __DIR__ . "/rodape.html";
    exit();
}

$idvacina = is_object($vac_obj) ? $vac_obj->idvacina : $vac_obj["idvacina"];
$ativo = is_object($vac_obj) ? $vac_obj->ativo : $vac_obj["ativo"];
$lote = is_object($vac_obj) ? $vac_obj->lote : $vac_obj["lote"];
$produtovacinafk = is_object($vac_obj) ? $vac_obj->produtovacinafk : $vac_obj["produtovacinafk"];

$produtos = $prodao->read();
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light text-primary">✏️ Editar Vacina</h2>
        <a href="gerenciavacina.php" class="btn btn-outline-secondary shadow-sm">
            Cancelar / Voltar
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/vacinacontroller.php">
                <input type="hidden" name="idvacina" value="<?php echo $idvacina ?>">

                <div class="row justify-content-center">
                    <div class="col-md-6 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Detalhes da Vacina</h4>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Princípio Ativo / Nome da Vacina</label>
                            <input type="text" class="form-control custom-input" name="ativo" value="<?php echo htmlspecialchars($ativo) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Número do Lote</label>
                            <input type="text" class="form-control custom-input" name="lote" value="<?php echo htmlspecialchars($lote) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Vincular a um Produto (Estoque / Valor)</label>
                            <select class="form-select custom-input" name="produtovacinafk" required>
                                <option value="">— Selecione o Produto Base —</option>
                                <?php 
                                if($produtos) {
                                    foreach ($produtos as $prod) {
                                        $id_prod = is_object($prod) ? $prod->idproduto : $prod["idproduto"];
                                        $nome_prod = is_object($prod) ? $prod->nome : $prod["nome"];
                                        $sel = ($id_prod == $produtovacinafk) ? "selected" : "";
                                        echo "<option value='{$id_prod}' {$sel}>[#{$id_prod}] {$nome_prod}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Atualizar Vacina
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>
