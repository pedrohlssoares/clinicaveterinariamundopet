<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/sala.php";
include_once $base . "entity/dao/saladao.php";

include __DIR__ . "/topo.html";

$sdao = new salaDao();

if (!isset($_GET["numero"])) {
    header("location: gerenciasala.php");
    exit();
}

$sala_obj = $sdao->readId($_GET["numero"]);

if (!$sala_obj) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Sala não encontrada!</div></div>";
    include __DIR__ . "/rodape.html";
    exit();
}
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light text-primary">✏️ Editar Sala</h2>
        <a href="gerenciasala.php" class="btn btn-outline-secondary shadow-sm">
            Cancelar / Voltar
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/salacontroller.php">
                
                <input type="hidden" name="numero" value="<?php echo $sala_obj->numero ?>">

                <div class="row justify-content-center">
                    <div class="col-md-8 px-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Número da Sala (Gerado Automaticamente)</label>
                            <input type="text" class="form-control custom-input bg-light" value="Sala <?php echo $sala_obj->numero ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Tipo de Sala</label>
                            <input type="text" class="form-control custom-input" name="tipo" value="<?php echo $sala_obj->tipo ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Descrição / Equipamentos</label>
                            <textarea class="form-control custom-input" name="descricao" rows="4" required><?php echo $sala_obj->descricao ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Atualizar Dados da Sala
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>
