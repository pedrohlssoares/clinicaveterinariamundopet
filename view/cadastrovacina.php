<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/vacina.php";
include_once $base . "entity/dao/vacinadao.php";
include_once $base . "entity/model/produto.php";
include_once $base . "entity/dao/produtodao.php";

include __DIR__ . "/topo.html";

$prodao = new produtodao();
$produtos = $prodao->read();
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-green);">💉 Nova Vacina</h2>
        <a href="gerenciavacina.php" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-list"></i> Ver Vacinas Cadastradas
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/vacinacontroller.php">
                <input type="hidden" name="idvacina" value="">

                <div class="row justify-content-center">
                    <div class="col-md-6 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Detalhes da Vacina</h4>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Princípio Ativo / Nome da Vacina</label>
                            <input type="text" class="form-control custom-input" name="ativo" placeholder="Ex: Vacina V10" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Número do Lote</label>
                            <input type="text" class="form-control custom-input" name="lote" placeholder="Ex: L-48392" required>
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
                                        echo "<option value='{$id_prod}'>[#{$id_prod}] {$nome_prod}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Cadastrar Vacina
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>