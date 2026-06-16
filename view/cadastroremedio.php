<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/remedio.php";
include_once $base . "entity/dao/remediodao.php";
include_once $base . "entity/model/produto.php";
include_once $base . "entity/dao/produtodao.php";
include __DIR__ . "/topo.html";

$prodao = new produtodao();
$produtos = $prodao->read();
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-green);">💊 Novo Remédio</h2>
        <a href="gerenciaremedio.php" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-list"></i> Ver Remédios Cadastrados
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/remediocontroller.php">
                <input type="hidden" name="idremedio" value="">

                <div class="row justify-content-center">
                    <div class="col-md-6 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Dados do Remédio</h4>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Vincular a um Produto (Estoque)</label>
                            <select class="form-select custom-input" name="produtoremediofk" required>
                                <option value="">— Selecione um produto —</option>
                                <?php 
                                if ($produtos) {
                                    foreach ($produtos as $produto): 
                                        // Tratamento para caso o DAO devolva Array ou Objeto
                                        $id_prod = is_object($produto) ? $produto->idproduto : $produto["idproduto"];
                                        $nome_prod = is_object($produto) ? $produto->nome : $produto["nome"];
                                        $preco_prod = is_object($produto) ? $produto->preco : $produto["preco"];
                                ?>
                                        <option value="<?php echo $id_prod ?>">
                                            <?php echo "[#{$id_prod}] {$nome_prod} — R$ " . number_format($preco_prod, 2, ',', '.') ?>
                                        </option>
                                <?php 
                                    endforeach; 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Princípio Ativo</label>
                            <input type="text" class="form-control custom-input" name="ativo" placeholder="Ex: Meloxicam 10mg" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Número do Lote</label>
                            <input type="number" class="form-control custom-input" name="lote" placeholder="Ex: 102938" required>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Cadastrar Remédio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>