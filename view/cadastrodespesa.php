<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";

include __DIR__ . "/topo.html";
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light text-danger"><i class="bi bi-graph-down-arrow"></i> Registrar Nova Despesa</h2>
        <a href="gerenciadespesa.php" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-list"></i> Ver Despesas
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/despesacontroller.php">
                <input type="hidden" name="iddespesa" value="">

                <div class="row justify-content-center">
                    <div class="col-md-6 px-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Descrição da Despesa</label>
                            <input type="text" class="form-control custom-input" name="descricao" placeholder="Ex: Conta de Luz, Compra de Insumos, Manutenção..." required>
                        </div>
                        
                        <div class="row g-2">
                            <div class="col-6 mb-3">
                                <label class="form-label text-muted small">Valor da Despesa (R$)</label>
                                <input type="number" step="0.01" class="form-control custom-input" name="preco" placeholder="0,00" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label text-muted small">Data do Vencimento / Pagamento</label>
                                <input type="date" class="form-control custom-input" name="despesadata" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-danger btn-lg px-5 shadow-sm" name="btGravar">
                        Registrar Saída
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>