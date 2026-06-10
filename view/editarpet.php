<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/pet.php";
include_once $base . "entity/dao/petdao.php";
include_once $base . "entity/model/cliente.php";
include_once $base . "entity/dao/clientedao.php";

include __DIR__ . "/topo.html";

$petdao = new petDao();
$cdao = new clienteDao();

if (!isset($_GET["idpet"])) {
    header("location: gerenciapet.php");
    exit();
}

$result_obj = $petdao->readId($_GET["idpet"]);
if (!$result_obj) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Pet não encontrado!</div></div>";
    include __DIR__ . "/rodape.html";
    exit();
}

$clientes = $cdao->read();
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light text-primary">✏️ Editar Pet</h2>
        <a href="gerenciapet.php" class="btn btn-outline-secondary shadow-sm">
            Cancelar / Voltar
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/petcontroller.php">
                <input type="hidden" name="idpet" value="<?php echo $result_obj->idpet ?>">

                <div class="row justify-content-center">
                    <div class="col-md-8 px-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Nome do Pet</label>
                            <input type="text" class="form-control custom-input" name="nome" placeholder="Digite o nome do pet" value="<?php echo $result_obj->nome ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Tutor (Cliente) Obrigatório</label>
                            <select class="form-select custom-input" name="clientepetfk" required>
                                <option value="">— Selecione o Dono do Pet —</option>
                                <?php 
                                if($clientes) {
                                    foreach ($clientes as $cli) {
                                        $selected = ($result_obj->clientepetfk == $cli->idcliente) ? "selected" : "";
                                        echo "<option value='{$cli->idcliente}' {$selected}>{$cli->nome} (CPF: {$cli->cpf})</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Espécie</label>
                                <input type="text" class="form-control custom-input" name="especie" value="<?php echo $result_obj->especie ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Raça</label>
                                <input type="text" class="form-control custom-input" name="raca" value="<?php echo $result_obj->raca ?>"> 
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Idade (Anos)</label>
                            <input type="number" class="form-control custom-input" name="idade" value="<?php echo $result_obj->idade ?>" required>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Atualizar Dados do Pet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>
