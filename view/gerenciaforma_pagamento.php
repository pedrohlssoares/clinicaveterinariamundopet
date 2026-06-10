<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/forma_pagamento.php";
include_once $base . "entity/dao/forma_pagamentodao.php";

include __DIR__ . "/topo.html";

$fpdao = new forma_pagamentoDao();

if (isset($_SESSION["resultado"])) {
    $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
    echo "<div class='container mt-3'><div class='alert {$classe} shadow-sm'>{$_SESSION["mensagem"]}</div></div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-dark);">Gerenciar Formas de Pagamento</h2>
        <a href="cadastroforma_pagamento.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i>Novo Método
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th>ID</th>
                    <th>Tipo de Pagamento</th>
                    <th>Descrição / Detalhes</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lista = $fpdao->read();
                
                if (is_null($lista) || empty($lista)) {
                    echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Nenhuma forma de pagamento cadastrada.</td></tr>";
                } else {
                    foreach ($lista as $item) {
                        $id = is_object($item) ? $item->idforma_pagamento : $item["idforma_pagamento"];
                        $tipo = is_object($item) ? $item->tipo : $item["tipo"];
                        $descricao = is_object($item) ? $item->descricao : $item["descricao"];

                        echo "<tr>";
                        echo "<td><span class='badge bg-secondary'>#{$id}</span></td>";
                        echo "<td class='fw-bold text-primary'>{$tipo}</td>";
                        echo "<td>{$descricao}</td>";
                        echo "<td class='text-center'>";
                        echo "<a href='editarforma_pagamento.php?idforma_pagamento={$id}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                        echo "<a href='../controller/forma_pagamentocontroller.php?idforma_pagamento={$id}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Tem a certeza que deseja excluir esta forma de pagamento?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
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