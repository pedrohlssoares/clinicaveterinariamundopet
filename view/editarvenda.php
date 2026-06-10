<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";

include_once $base ."entity/model/venda.php";
include_once $base ."entity/dao/vendadao.php";
include_once $base ."entity/model/produto.php";
include_once $base ."entity/dao/produtodao.php";
include_once $base ."entity/model/pagamento.php";
include_once $base ."entity/dao/pagamentodao.php";
include_once $base ."entity/model/cliente.php";
include_once $base ."entity/dao/clientedao.php";

include __DIR__ . "/topo.html";

$vdao = new vendaDao();
$prodao = new produtodao();
$pagdao = new pagamentoDao();
$clidao = new clienteDao();

if (!isset($_GET["idvenda"])) {
    header("location: gerenciavenda.php");
    exit();
}

$venda_obj = method_exists($vdao, 'readID') ? $vdao->readID($_GET["idvenda"]) : $vdao->readId($_GET["idvenda"]);

if (!$venda_obj) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Registro de item de venda não encontrado!</div></div>";
    include __DIR__ . "/rodape.html";
    exit();
}

$idvenda = is_object($venda_obj) ? $venda_obj->idvenda : $venda_obj["idvenda"];
$pagamentovendafk = is_object($venda_obj) ? $venda_obj->pagamentovendafk : $venda_obj["pagamentovendafk"];
$produtovendafk = is_object($venda_obj) ? $venda_obj->produtovendafk : $venda_obj["produtovendafk"];
$quantidade = is_object($venda_obj) ? $venda_obj->quantidade : $venda_obj["quantidade"];
$valor_unitario = is_object($venda_obj) ? $venda_obj->valor_unitario : $venda_obj["valor_unitario"];

$produtos = $prodao->read();
$pagamentos = $pagdao->read();
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light text-primary">✏️ Editar Item de Venda</h2>
        <a href="gerenciavenda.php" class="btn btn-outline-secondary shadow-sm">
            Cancelar / Voltar
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/vendacontroller.php">
                <input type="hidden" name="idvenda" value="<?php echo $idvenda; ?>">

                <div class="row justify-content-center">
                    <div class="col-md-5 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Associação de Faturamento</h4>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Vincular ao Pagamento / Fatura</label>
                            <select class="form-select custom-input" name="pagamentovendafk" required>
                                <option value="">— Selecione a Fatura —</option>
                                <?php 
                                if($pagamentos){
                                    foreach ($pagamentos as $pag) {
                                        $idpag = is_object($pag) ? $pag->idpagamento : $pag["idpagamento"];
                                        $clifk = is_object($pag) ? $pag->clientepagamentofk : $pag["clientepagamentofk"];
                                        $val = is_object($pag) ? $pag->valor : $pag["valor"];
                                        
                                        $cli = $clidao->readId($clifk);
                                        $nomeCli = $cli ? (is_object($cli) ? $cli->nome : $cli["nome"]) : "Cliente";
                                        
                                        $sel = ($idpag == $pagamentovendafk) ? "selected" : "";
                                        echo "<option value='{$idpag}' {$sel}>Fatura #{$idpag} — {$nomeCli} (R$ " . number_format($val, 2, ',', '.') . ")</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Produto do Petshop</label>
                            <select class="form-select custom-input" name="produtovendafk" id="produtoSelect" required onchange="atualizarPrecoUnitario()">
                                <option value="">— Selecione o Produto —</option>
                                <?php 
                                if($produtos){
                                    foreach ($produtos as $prod) {
                                        $id = is_object($prod) ? $prod->idproduto : $prod["idproduto"];
                                        $nome = is_object($prod) ? $prod->nome : $prod["nome"];
                                        $preco = is_object($prod) ? $prod->preco : $prod["preco"];
                                        $sel = ($id == $produtovendafk) ? "selected" : "";
                                        echo "<option value='{$id}' data-preco='{$preco}' {$sel}>{$nome}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-5 px-4 border-start">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Quantidades e Valores</h4>
                        
                        <div class="row g-2">
                            <div class="col-6 mb-3">
                                <label class="form-label text-muted small">Quantidade</label>
                                <input type="number" class="form-control custom-input" name="quantidade" value="<?php echo $quantidade; ?>" min="1" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label text-muted small">Preço Unitário (R$)</label>
                                <input type="number" step="0.01" class="form-control custom-input" name="valor_unitario" id="precoInput" value="<?php echo $valor_unitario; ?>" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Atualizar Registro
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