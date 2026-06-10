<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";

include_once $base . "entity/model/pet.php";
include_once $base . "entity/dao/petdao.php";

include __DIR__ . "/topo.html";

$pdao = new petdao();
$todosPets = $pdao->read();
?>

<div class="container mt-5 mb-5">
    <div class="text-center mb-5">
        <h2 class="display-6 fw-bold text-dark"><i class="bi bi-folder2-open text-primary"></i> Prontuário & Histórico Geral</h2>
        <p class="text-muted">Acesse a ficha médica consolidada, vacinações e relatórios financeiros por paciente.</p>
    </div>

    <?php if (isset($_SESSION["resultado"]) && $_SESSION["resultado"] === false): ?>
        <div class="alert alert-danger shadow-sm text-center max-width-form mx-auto mb-4">
            <?php echo $_SESSION["mensagem"]; $_SESSION["resultado"] = null; ?>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Formulário de Busca por Nome ou ID -->
            <div class="card shadow border-0 mb-4 rounded-4">
                <div class="card-body p-4">
                    <h5 class="card-title text-primary mb-3"><i class="bi bi-search"></i> Pesquisar por Nome ou ID</h5>
                    <form method="post" action="../controller/historicopetcontroller.php">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control custom-input py-2" name="termo_busca" placeholder="Digite o ID ou parte do nome do Pet..." required>
                            <button class="btn btn-primary px-4" type="submit" name="btBuscarPet">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Seleção Direta por Lista de Pacientes Cadastrados -->
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="card-title text-success mb-3"><i class="bi bi-list-stars"></i> Seleção Direta de Pacientes</h5>
                    <div class="mb-2">
                        <label class="small text-muted mb-1">Escolha um pet da listagem abaixo:</label>
                        <select class="form-select custom-input py-2" id="selectPetDireto" onchange="if(this.value) location.href='painel_pet.php?idpet='+this.value;">
                            <option value="">— Selecione um paciente para abrir o prontuário —</option>
                            <?php 
                            if($todosPets){
                                foreach ($todosPets as $p) {
                                    $id = is_object($p) ? $p->idpet : $p["idpet"];
                                    $nome = is_object($p) ? $p->nome : $p["nome"];
                                    $raca = is_object($p) ? $p->raca : $p["raca"];
                                    echo "<option value='{$id}'>[ID: #{$id}] — {$nome} ({$raca})</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>