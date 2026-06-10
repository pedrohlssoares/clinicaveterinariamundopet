<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/historico_vacinacao.php";
include_once $base . "entity/dao/historico_vacinacaodao.php";
include_once $base . "entity/model/pet.php";
include_once $base . "entity/dao/petdao.php";
include_once $base . "entity/model/vacina.php";
include_once $base . "entity/dao/vacinadao.php";

include __DIR__ . "/topo.html";

$petdao = new petdao();
$vactdao = new vacinadao();

$pets = $petdao->read();
$vacinas = $vactdao->read();
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-green);">💉 Registrar Aplicação de Vacina</h2>
        <a href="gerenciahistorico_vacinacao.php" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-list"></i> Ver Histórico
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/historico_vacinacaocontroller.php">
                <input type="hidden" name="idhistorico" value="">

                <div class="row justify-content-center">
                    <div class="col-md-5 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Informações da Aplicação</h4>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Paciente (Pet)</label>
                            <select class="form-select custom-input" name="pethistorico_vacinacaofk" required>
                                <option value="">— Selecione o Pet —</option>
                                <?php 
                                if($pets){
                                    foreach ($pets as $pet) {
                                        $id = is_object($pet) ? $pet->idpet : $pet["idpet"];
                                        $nome = is_object($pet) ? $pet->nome : $pet["nome"];
                                        echo "<option value='{$id}'>{$nome}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Vacina</label>
                            <select class="form-select custom-input" name="vacinahistorico_vacinacaofk" required>
                                <option value="">— Selecione a Vacina —</option>
                                <?php 
                                if($vacinas){
                                    foreach ($vacinas as $vac) {
                                        $id = is_object($vac) ? $vac->idvacina : $vac["idvacina"];
                                        // CORREÇÃO: Propriedade correta é 'ativo' e não 'nome'
                                        $ativo = is_object($vac) ? $vac->ativo : $vac["ativo"];
                                        echo "<option value='{$id}'>{$ativo}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-5 px-4 border-start">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Data e Dosagem</h4>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Data de Aplicação</label>
                            <input type="date" class="form-control custom-input" name="data_aplicacao" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Dosagem (Ex: 1 ml, 2 ml)</label>
                            <input type="text" class="form-control custom-input" name="dosagem" placeholder="Ex: 1 ml" required>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Salvar Registro
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>