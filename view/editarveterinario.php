<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/veterinario.php";
include_once $base . "entity/dao/veterinariodao.php";
include_once $base . "entity/model/funcionario.php";
include_once $base . "entity/dao/funcionariodao.php";

include __DIR__ . "/topo.html";

$vetdao = new veterinariodao();
$fundao = new funcionariodao();

if (!isset($_GET["idveterinario"])) {
    header("location: gerenciaveterinario.php");
    exit();
}

$vet_obj = $vetdao->readId($_GET["idveterinario"]);

if (!$vet_obj) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Veterinário não encontrado!</div></div>";
    include __DIR__ . "/rodape.html";
    exit();
}

$funcionarios = $fundao->read();
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light text-primary">✏️ Editar Veterinário</h2>
        <a href="gerenciaveterinario.php" class="btn btn-outline-secondary shadow-sm">
            Cancelar / Voltar
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/veterinariocontroller.php">
                
                <input type="hidden" name="idveterinario" value="<?php echo $vet_obj->idveterinario ?>">

                <div class="row justify-content-center">
                    <div class="col-md-8 px-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small">CRMV</label>
                            <input type="text" class="form-control custom-input" name="crmv" value="<?php echo $vet_obj->crmv ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Vincular a um Funcionário (Obrigatório)</label>
                            <select class="form-select custom-input" name="funcionarioveterinariofk" required>
                                <option value="">— Selecione o Funcionário —</option>
                                <?php 
                                if($funcionarios) {
                                    foreach ($funcionarios as $func) {
                                        $selected = ($vet_obj->funcionarioveterinariofk == $func->idfuncionario) ? "selected" : "";
                                        echo "<option value='{$func->idfuncionario}' {$selected}>{$func->nome} (CPF: {$func->cpf})</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Descrição / Especialidade</label>
                            <textarea class="form-control custom-input" name="descricao" rows="3"><?php echo $vet_obj->descricao ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Atualizar Veterinário
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>