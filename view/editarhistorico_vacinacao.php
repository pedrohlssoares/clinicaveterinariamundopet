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

$hvdao = new historico_vacinacaoDao();
$petdao = new petdao();
$vactdao = new vacinadao();

if (!isset($_GET["idhistorico"])) {
    header("location: gerenciahistorico_vacinacao.php");
    exit();
}

$hv_obj = method_exists($hvdao, 'readID') ? $hvdao->readID($_GET["idhistorico"]) : $hvdao->readId($_GET["idhistorico"]);

if (!$hv_obj) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Registro de vacinação não encontrado!</div></div>";
    include __DIR__ . "/rodape.html";
    exit();
}

$idhistorico = is_object($hv_obj) ? $hv_obj->idhistorico : $hv_obj["idhistorico"];
$pethistorico_vacinacaofk = is_object($hv_obj) ? $hv_obj->pethistorico_vacinacaofk : $hv_obj["pethistorico_vacinacaofk"];
$vacinahistorico_vacinacaofk = is_object($hv_obj) ? $hv_obj->vacinahistorico_vacinacaofk : $hv_obj["vacinahistorico_vacinacaofk"];
$data_aplicacao = is_object($hv_obj) ? $hv_obj->data_aplicacao : $hv_obj["data_aplicacao"];
$dosagem = is_object($hv_obj) ? $hv_obj->dosagem : $hv_obj["dosagem"];

$pets = $petdao->read();
$vacinas = $vactdao->read();
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light text-primary">✏️ Editar Registro de Vacinação</h2>
        <a href="gerenciahistorico_vacinacao.php" class="btn btn-outline-secondary shadow-sm">
            Cancelar / Voltar
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/historico_vacinacaocontroller.php">
                <input type="hidden" name="idhistorico" value="<?php echo $idhistorico; ?>">

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
                                        $sel = ($id == $pethistorico_vacinacaofk) ? "selected" : "";
                                        echo "<option value='{$id}' {$sel}>{$nome}</option>";
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
                                        $sel = ($id == $vacinahistorico_vacinacaofk) ? "selected" : "";
                                        echo "<option value='{$id}' {$sel}>{$ativo}</option>";
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
                            <input type="date" class="form-control custom-input" name="data_aplicacao" value="<?php echo date('Y-m-d', strtotime($data_aplicacao)); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Dosagem</label>
                            <input type="text" class="form-control custom-input" name="dosagem" value="<?php echo htmlspecialchars($dosagem); ?>" required>
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

<?php include __DIR__ . "/rodape.html"; ?>