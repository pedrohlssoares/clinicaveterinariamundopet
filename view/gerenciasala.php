<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "model/entity/sala.php";
include_once $base . "model/dao/saladao.php";

include __DIR__ . "/topo.html";

$sdao = new salaDao();

if (isset($_SESSION["resultado"])) {
    $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
    echo "<div class='container mt-3'><div class='alert {$classe} shadow-sm'>{$_SESSION["mensagem"]}</div></div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-dark);">Gerenciar Salas</h2>
        <a href="cadastrosala.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> Nova Sala
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th width="10%">Número</th>
                    <th width="25%">Tipo</th>
                    <th width="50%">Descrição</th>
                    <th width="15%" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $sdao->read();
                
                if (is_null($result) || empty($result)) {
                    echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Nenhuma sala cadastrada no sistema.</td></tr>";
                } else {
                    foreach ($result as $item) {
                        echo "<tr>";
                        echo "<td class='fw-bold text-primary'>Sala {$item->numero}</td>";
                        echo "<td><span class='badge bg-light text-dark border'>{$item->tipo}</span></td>";
                        echo "<td>{$item->descricao}</td>";
                        echo "<td class='text-center'>";
                        echo "<a href='editarsala.php?numero={$item->numero}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                        echo "<a href='../controller/salacontroller.php?numero={$item->numero}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Deseja realmente excluir esta sala?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
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
