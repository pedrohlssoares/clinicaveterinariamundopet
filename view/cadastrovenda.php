<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";

include_once $base . "entity/model/venda.php";
include_once $base . "entity/dao/vendadao.php";
include_once $base . "entity/model/produto.php";
include_once $base . "entity/dao/produtodao.php";

include __DIR__ . "/topo.html";

$prodao = new produtodao();
$produtos = $prodao->read();
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-green);">📦 Lançar Item de Venda (Balcão)</h2>
        <a href="gerenciavenda.php" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-list"></i> Ver Itens Vendidos
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/vendacontroller.php">
                <input type="hidden" name="idvenda" value="">

                <div class="row justify-content-center">
                    <div class="col-md-6 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Detalhes do Produto</h4>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Produto do Petshop</label>
                            <select class="form-select custom-input" name="produtovendafk" id="produtoSelect" required onchange="atualizarPrecoUnitario()">
                                <option value="" data-preco="0">— Selecione o Produto —</option>
                                <?php 
                                if($produtos){
                                    foreach ($produtos as $prod) {
                                        $id = is_object($prod) ? $prod->idproduto : $prod["idproduto"];
                                        $nome = is_object($prod) ? $prod->nome : $prod["nome"];
                                        $preco = is_object($prod) ? $prod->preco : $prod["preco"];
                                        echo "<option value='{$id}' data-preco='{$preco}'>{$nome}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="row g-2">
                            <div class="col-6 mb-3">
                                <label class="form-label text-muted small">Quantidade</label>
                                <input type="number" class="form-control custom-input" name="quantidade" id="quantInput" value="1" min="1" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label text-muted small">Preço Unitário (R$)</label>
                                <input type="number" step="0.01" class="form-control custom-input" name="valor_unitario" id="precoInput" placeholder="0,00" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Confirmar Venda
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function atualizarPrecoUnitario() {
    var select = document.getElementById("produtoSelect");
    var preco = select.options[select.selectedIndex].getAttribute("data-preco");
    document.getElementById("precoInput").value = preco;
}
</script>

<?php include __DIR__ . "/rodape.html"; ?>
