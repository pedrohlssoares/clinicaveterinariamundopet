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

$codao = new consultadao();
$petdao = new petdao();
$vetdao = new veterinariodao();
$saladao = new saladao();

if (isset($_SESSION["resultado"])) {
    $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
    echo "<div class='alert {$classe}'>{$_SESSION["mensagem"]}</div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}

if (isset($_GET["idconsulta"])) {
    $result = $codao->readID($_GET["idconsulta"]);
} else {
    $result = ["idconsulta" => "", "petconsultafk" => "", "veterinarioconsultafk" => "", "salaconsultafk" => "", "data" => "", "horario" => "", "processos_feitos" => ""];
}

$pets = $petdao->read();
$veterinarios = $vetdao->read();
$salas = $saladao->read();

// Se $result for objeto (vindo do readID), converte para array
if (is_object($result)) {
    $result = [
        "idconsulta" => $result->idconsulta,
        "petconsultafk" => $result->petconsultafk,
        "veterinarioconsultafk" => $result->veterinarioconsultafk,
        "salaconsultafk" => $result->salaconsultafk,
        "data" => $result->data,
        "horario" => $result->horario,
        "processos_feitos" => $result->processos_feitos,
    ];
}
?>

<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 pt-4">
            <h2 class="text-center fw-light" style="color: var(--pet-green);">📋 Cadastro de Consulta</h2>
        </div>
        <div class="card-body p-4">
            <form method="post" action="/clinicaveterinariamundopet/controller/consultacontroller.php">
                <input type="hidden" name="idconsulta" value="<?php echo $result["idconsulta"] ?>">

                <div class="row justify-content-center">
                    <div class="col-md-5 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Dados da Consulta</h4>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Data da consulta</label>
                            <input type="date" class="form-control custom-input" name="data" value="<?php echo $result["data"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Horário</label>
                            <input type="time" class="form-control custom-input" name="horario" value="<?php echo $result["horario"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Procedimentos realizados</label>
                            <textarea class="form-control custom-input" name="processos_feitos" rows="3" placeholder="Descreva os procedimentos realizados..." required><?php echo $result["processos_feitos"] ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-5 px-4 border-start">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Vínculos</h4>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Pet</label>
                            <select class="form-select custom-input" name="petconsultafk" required>
                                <option value="">— Selecione um pet —</option>
                                <?php foreach ($pets as $pet): ?>
                                    <option value="<?php echo $pet->idpet ?>"
                                        <?php echo ($result["petconsultafk"] == $pet->idpet) ? "selected" : "" ?>>
                                        <?php echo "[#{$pet->idpet}] {$pet->petcolnome} — {$pet->especie}" ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Veterinário</label>
                            <select class="form-select custom-input" name="veterinarioconsultafk" required>
                                <option value="">— Selecione um veterinário —</option>
                                <?php foreach ($veterinarios as $vet): ?>
                                    <option value="<?php echo $vet->idveterinario ?>"
                                        <?php echo ($result["veterinarioconsultafk"] == $vet->idveterinario) ? "selected" : "" ?>>
                                        <?php echo "[CRMV: {$vet->crmv}] {$vet->nome_veterinario}" ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Sala</label>
                            <select class="form-select custom-input" name="salaconsultafk" required>
                                <option value="">— Selecione uma sala —</option>
                                <?php foreach ($salas as $sala): ?>
                                    <option value="<?php echo $sala->numero ?>"
                                        <?php echo ($result["salaconsultafk"] == $sala->numero) ? "selected" : "" ?>>
                                        <?php echo "Sala {$sala->numero} — {$sala->tipo}" ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Salvar Consulta
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-5 mb-5">
        <h3 class="h4 mb-3 fw-light" style="color: var(--pet-dark);">Consultas Cadastradas</h3>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle mb-0 bg-white">
                <thead class="custom-thead text-white">
                    <tr>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Pet</th>
                        <th>Veterinário</th>
                        <th>Sala</th>
                        <th>Procedimentos</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $lista = $codao->read();
                    if (is_null($lista) || empty($lista)) {
                        echo "<tr><td colspan='7' class='text-center py-4 text-muted'>Nenhuma consulta cadastrada no sistema.</td></tr>";
                    } else {
                        foreach ($lista as $item) {
                            $dataFormatada = date("d/m/Y", strtotime($item->data));
                            echo "<tr>";
                            echo "<td>{$dataFormatada}</td>";
                            echo "<td>{$item->horario}</td>";
                            echo "<td class='fw-bold'>{$item->petcolnome}</td>";
                            echo "<td>{$item->nome_veterinario}</td>";
                            echo "<td><span class='badge bg-light text-dark border'>Sala {$item->numero_sala}</span></td>";
                            echo "<td>{$item->processos_feitos}</td>";
                            echo "<td class='text-center'>";
                            echo "<a href='cadastroconsulta.php?idconsulta={$item->idconsulta}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                            echo "<a href='/clinicaveterinariamundopet/controller/consultacontroller.php?idconsulta={$item->idconsulta}' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Deseja realmente excluir esta consulta?\")' title='Excluir'><img src='img/apagar.png' width='16'></a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>