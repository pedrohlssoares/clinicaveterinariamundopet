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

if (isset($_SESSION["resultado"])) {
    $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
    echo "<div class='container mt-3'><div class='alert {$classe} shadow-sm'>{$_SESSION["mensagem"]}</div></div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-dark);">Gerenciar Pets</h2>
        <a href="cadastropet.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> Novo Pet
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th>Nome do Pet</th>
                    <th>Espécie / Raça</th>
                    <th>Idade</th>
                    <th>Dono (Cliente)</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lista_pets = $petdao->read();
                
                if (is_null($lista_pets) || empty($lista_pets)) {
                    echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Nenhum pet cadastrado no sistema.</td></tr>";
                } else {
                    foreach ($lista_pets as $item) {
                        
                        $cliente_obj = $cdao->readId($item->clientepetfk);
                        $nome_dono = $cliente_obj ? $cliente_obj->nome : "Sem Tutor";

                        echo "<tr>";
                        echo "<td class='fw-bold'>" . $item->nome . "</td>";
                        echo "<td>" . $item->especie . " - " . $item->raca . "</td>";
                        echo "<td>" . $item->idade . " anos</td>";
                        echo "<td><span class='badge bg-light text-dark border'>" . $nome_dono . "</span></td>";
                        echo "<td class='text-center'>";
                        echo "<a href='editarpet.php?idpet={$item->idpet}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                        echo "<a href='../controller/petcontroller.php?idpet={$item->idpet}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Deseja realmente excluir este pet?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>
