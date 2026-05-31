<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "model/entity/veterinario.php";
include_once $base . "model/dao/veterinariodao.php";
include_once $base . "model/entity/funcionario.php";
include_once $base . "model/dao/funcionariodao.php";
include __DIR__ . "/topo.html";
$vetdao = new veterinariodao();
$fundao = new funcionariodao();

if (isset($_SESSION["resultado"])) {
    $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
    echo "<div class='alert {$classe}'>{$_SESSION["mensagem"]}</div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}

if (isset($_GET["idveterinario"])) {
    $result = $vetdao->readId($_GET["idveterinario"]);
} else {
    $result = ["idveterinario" => "", "crmv" => "", "funcionarioveterinariofk" => "", "descricao" => ""];
}

$funcionarios = $fundao->read();
?>

<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 pt-4">
            <h2 class="text-center fw-light" style="color: var(--pet-green);">🩺 Cadastro de Veterinário</h2>
        </div>
        <div class="card-body p-4">
            <form method="post" action="/clinicaveterinariamundopet/controller/veterinariocontroller.php">
                <input type="hidden" name="idveterinario" value="<?php echo $result["idveterinario"] ?>">

                <div class="row justify-content-center">
                    <div class="col -md-6 px-4">
                            <label class="form-label text-muted small">Funcionário vinculado</label>
                            <select class="form-select custom-input" name="funcionarioveterinariofk" required>
                                <option value="">— Selecione um funcionário —</option>
                                <?php foreach ($funcionarios as $func): ?>
                                    <option value="<?php echo $func->idfuncionario ?>"
                                        <?php echo ($result["funcionarioveterinariofk"] == $func->idfuncionario) ? "selected" : "" ?>>
                                        <?php echo "[#{$func->idfuncionario}] {$func->nome}" ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <div class="col-md-6 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Dados do Veterinário</h4>
                        <div class="mb-3">
                            <input type="text" class="form-control custom-input" name="crmv" placeholder="CRMV" value="<?php echo $result["crmv"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control custom-input" name="descricao" placeholder="Descrição / Especialidade" rows="3"><?php echo $result["descricao"] ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Salvar Veterinário
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-5 mb-5">
        <h3 class="h4 mb-3 fw-light" style="color: var(--pet-dark);">Veterinários Cadastrados</h3>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle mb-0 bg-white">
                <thead class="custom-thead text-white">
                    <tr>
                        <th>CRMV</th>
                        <th>Descrição</th>
                        <th>Funcionário Vinculado</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $vetdao->read();
                    if (is_null($result) || empty($result)) {
                        echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Nenhum veterinário cadastrado no sistema.</td></tr>";
                    } else {
                        foreach ($result as $item) {
                            $func = $fundao->readId($item->funcionarioveterinariofk);
                            $nomeFuncionario = $func ? $func["nome"] : "Não vinculado";
                            echo "<tr>";
                            echo "<td class='fw-bold'>{$item->crmv}</td>";
                            echo "<td>{$item->descricao}</td>";
                            echo "<td><span class='badge bg-light text-dark border'>{$nomeFuncionario}</span></td>";
                            echo "<td class='text-center'>";
                            echo "<a href='cadastroveterinario.php?idveterinario={$item->idveterinario}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                            echo "<a href='/clinicaveterinariamundopet/controller/veterinariocontroller.php?idveterinario={$item->idveterinario}' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Deseja realmente excluir este veterinário?\")' title='Excluir'><img src='img/apagar.png' width='16'></a>";
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

<?php 
include __DIR__ . "/rodape.html"; 
?>