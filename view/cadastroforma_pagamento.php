<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/forma_pagamento.php";
include_once $base . "entity/dao/forma_pagamentodao.php";

include __DIR__ . "/topo.html";
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-green);">💳 Nova Forma de Pagamento</h2>
        <a href="gerenciaforma_pagamento.php" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-list"></i> Ver Formas de Pagamento
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/forma_pagamentocontroller.php">
                <input type="hidden" name="idforma_pagamento" value="">

                <div class="row justify-content-center">
                    <div class="col-md-6 px-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Tipo (Ex: Cartão de Crédito, Pix)</label>
                            <input type="text" class="form-control custom-input" name="tipo" placeholder="Digite o tipo de pagamento" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Descrição / Regras</label>
                            <textarea class="form-control custom-input" name="descricao" rows="3" placeholder="Ex: Parcelamento em até 3x sem juros..." required></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Cadastrar Método
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>