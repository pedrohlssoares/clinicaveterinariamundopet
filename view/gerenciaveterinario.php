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
    echo "<div class='container mt-3'><div class='alert {$classe} shadow-sm'>{$_SESSION["mensagem"]}</div></div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-dark);">Gerenciar Veterinários</h2>
        <a href="cadastroveterinario.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> Novo Veterinário
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th>CRMV</th>
                    <th>Nome do Profissional</th>
                    <th>Especialidade/Descrição</th>
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
                        $nomeFuncionario = $func ? $func->nome : "Não vinculado / Excluído";

                        echo "<tr>";
                        echo "<td class='fw-bold'>{$item->crmv}</td>";
                        echo "<td><span class='badge bg-light text-dark border'>{$nomeFuncionario}</span></td>";
                        echo "<td>{$item->descricao}</td>";
                        echo "<td class='text-center'>";
                        echo "<a href='editarveterinario.php?idveterinario={$item->idveterinario}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                        echo "<a href='../controller/veterinariocontroller.php?idveterinario={$item->idveterinario}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Deseja realmente excluir este veterinário?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>
