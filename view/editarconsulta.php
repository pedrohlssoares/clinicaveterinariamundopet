<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/consulta.php";
include_once $base . "entity/dao/consultadao.php";
include_once $base . "entity/model/pet.php";
include_once $base . "entity/dao/petdao.php";
include_once $base . "entity/model/veterinario.php";
include_once $base . "entity/dao/veterinariodao.php";
include_once $base . "entity/model/sala.php";
include_once $base . "entity/dao/saladao.php";
include_once $base . "entity/model/funcionario.php";
include_once $base . "entity/dao/funcionariodao.php";


include __DIR__ . "/topo.html";

$codao = new consultadao();
$petdao = new petdao();
$vetdao = new veterinariodao();
$fdao = new funcionarioDao();
$saladao = new saladao();

if (!isset($_GET["idconsulta"])) {
    header("location: gerenciaconsulta.php");
    exit();
}

$cons_obj = $codao->readId($_GET["idconsulta"]);

if (!$cons_obj) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Consulta não encontrada!</div></div>";
    include __DIR__ . "/rodape.html";
    exit();
}

$idconsulta = is_object($cons_obj) ? $cons_obj->idconsulta : $cons_obj["idconsulta"];
$petconsultafk = is_object($cons_obj) ? $cons_obj->petconsultafk : $cons_obj["petconsultafk"];
$veterinarioconsultafk = is_object($cons_obj) ? $cons_obj->veterinarioconsultafk : $cons_obj["veterinarioconsultafk"];
$salaconsultafk = is_object($cons_obj) ? $cons_obj->salaconsultafk : $cons_obj["salaconsultafk"];
$data_consulta = is_object($cons_obj) ? $cons_obj->data_consulta : $cons_obj["data_consulta"];
$horario = is_object($cons_obj) ? $cons_obj->horario : $cons_obj["horario"];
$status = is_object($cons_obj) ? $cons_obj->status : $cons_obj["status"];
$processos_feitos = is_object($cons_obj) ? $cons_obj->processos_feitos : $cons_obj["processos_feitos"];

$pets = $petdao->read();
$veterinarios = $vetdao->read();
$salas = $saladao->read();
$funcionarios = $fdao->read();

?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light text-primary">✏️ Editar Agendamento</h2>
        <a href="gerenciaconsulta.php" class="btn btn-outline-secondary shadow-sm">
            Cancelar / Voltar
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/consultacontroller.php">
                <input type="hidden" name="idconsulta" value="<?php echo $idconsulta; ?>">
                <input type="hidden" name="status" value="<?php echo htmlspecialchars($status); ?>">

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
                                        $sel = ($id == $petconsultafk) ? "selected" : "";
                                        echo "<option value='{$id}' {$sel}>{$nome}</option>";
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
                                    foreach ($veterinarios as $v) {
                                        $idvet = is_object($v) ? $v->idveterinario : $v["idveterinario"];
                                        $fk_func = is_object($v) ? $v->funcionarioveterinariofk : $v["funcionarioveterinariofk"];
                                        $func_obj = $fdao->readID($fk_func);
                                        $nome = $func_obj ? (is_object($func_obj) ? $func_obj->nome : $func_obj["nome"]) : "Desconhecido";
                                        $sel = ($idvet == $veterinarioconsultafk) ? "selected" : "";
                                        echo "<option value='{$idvet}' {$sel}>{$nome}</option>";
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
                                        $sel = ($num == $salaconsultafk) ? "selected" : "";
                                        echo "<option value='{$num}' {$sel}>Sala {$num} - {$tipo}</option>";
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
                                <input type="date" class="form-control custom-input" name="data_consulta" value="<?php echo date('Y-m-d', strtotime($data_consulta)) ?>" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted small">Horário</label>
                                <input type="time" class="form-control custom-input" name="horario" value="<?php echo date('H:i', strtotime($horario)) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Processos / Motivo / Anamnese</label>
                            <textarea class="form-control custom-input" name="processos_feitos" rows="4"><?php echo htmlspecialchars($processos_feitos) ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Atualizar Agendamento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>