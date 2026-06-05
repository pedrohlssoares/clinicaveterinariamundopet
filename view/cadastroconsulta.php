<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "model/entity/consulta.php";
include_once $base . "model/dao/consultadao.php";
include_once $base . "model/entity/pet.php";
include_once $base . "model/dao/petdao.php";
include_once $base . "model/entity/veterinario.php";
include_once $base . "model/dao/veterinariodao.php";
include_once $base . "model/entity/sala.php";
include_once $base . "model/dao/saladao.php";

include __DIR__ . "/topo.html";

$petdao = new petdao();
$vetdao = new veterinariodao();
$saladao = new saladao();

$pets = $petdao->read();
$veterinarios = $vetdao->read();
$salas = $saladao->read();
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-green);">📅 Agendar Nova Consulta</h2>
        <a href="gerenciaconsulta.php" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-list"></i> Ver Agenda de Consultas
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/consultacontroller.php">
                <input type="hidden" name="idconsulta" value="">

                <div class="row justify-content-center">
                    <div class="col-md-5 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Detalhes do Agendamento</h4>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Paciente (Pet)</label>
                            <select class="form-select custom-input" name="petconsultafk" required>
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
                            <label class="form-label text-muted small">Médico Veterinário</label>
                            <select class="form-select custom-input" name="veterinarioconsultafk" required>
                                <option value="">— Selecione o Veterinário —</option>
                                <?php 
                                if($veterinarios){
                                    foreach ($veterinarios as $vet) {
                                        $id = is_object($vet) ? $vet->idveterinario : $vet["idveterinario"];
                                        $crmv = is_object($vet) ? $vet->crmv : $vet["crmv"];
                                        echo "<option value='{$id}'>CRMV: {$crmv}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Sala de Atendimento</label>
                            <select class="form-select custom-input" name="salaconsultafk" required>
                                <option value="">— Selecione a Sala —</option>
                                <?php 
                                if($salas){
                                    foreach ($salas as $sala) {
                                        $num = is_object($sala) ? $sala->numero : $sala["numero"];
                                        $tipo = is_object($sala) ? $sala->tipo : $sala["tipo"];
                                        echo "<option value='{$num}'>Sala {$num} - {$tipo}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-5 px-4 border-start">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Data, Hora e Prontuário</h4>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted small">Data da Consulta</label>
                                <input type="date" class="form-control custom-input" name="data" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted small">Horário</label>
                                <input type="time" class="form-control custom-input" name="horario" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Processos / Motivo / Anamnese</label>
                            <textarea class="form-control custom-input" name="processos_feitos" rows="4" placeholder="Descreva os sintomas, procedimentos ou motivo da visita..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Agendar Consulta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>