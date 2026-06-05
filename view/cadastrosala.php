<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "model/entity/sala.php";
include_once $base . "model/dao/saladao.php";

include __DIR__ . "/topo.html";
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-green);">🚪 Nova Sala</h2>
        <a href="gerenciasala.php" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-list"></i> Ver Salas Cadastradas
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/salacontroller.php">
                
                <input type="hidden" name="numero" value="">

                <div class="row justify-content-center">
                    <div class="col-md-8 px-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Tipo de Sala</label>
                            <input type="text" class="form-control custom-input" name="tipo" placeholder="Ex: Consultório, Bloco Cirúrgico, Internação" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Descrição / Equipamentos</label>
                            <textarea class="form-control custom-input" name="descricao" rows="4" placeholder="Descreva os equipamentos e a utilidade desta sala..." required></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Cadastrar Sala
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>