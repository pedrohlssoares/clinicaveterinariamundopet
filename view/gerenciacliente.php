<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "model/entity/cliente.php";
include_once $base . "model/dao/clientedao.php";
include_once $base . "model/entity/endereco.php";
include_once $base . "model/dao/enderecodao.php";

include __DIR__ . "/topo.html";

$cdao = new clienteDao();
$edao = new enderecoDao();

if (isset($_SESSION["resultado"])) {
    $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
    echo "<div class='container mt-3'><div class='alert {$classe} shadow-sm'>{$_SESSION["mensagem"]}</div></div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-dark);">Gerenciar Clientes</h2>
        <a href="cadastrocliente.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> + Novo Cliente
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>E-mail</th>
                    <th>Celular</th>
                    <th>Cidade</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $cdao->read();
                
                if (is_null($result) || empty($result)) {
                    echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Nenhum cliente encontrado no sistema.</td></tr>";
                } else {
                    foreach ($result as $item) {
                        $end_list = $edao->readId($item->enderecoclientefk);
                        $cidade = $end_list ? $end_list->cidade : "Não informado";

                        echo "<tr>";
                        echo "<td class='fw-bold'>{$item->nome}</td>";
                        echo "<td>{$item->cpf}</td>";
                        echo "<td>{$item->email}</td>";
                        echo "<td>{$item->celular}</td>";
                        echo "<td><span class='badge bg-light text-dark border'>{$cidade}</span></td>";
                        echo "<td class='text-center'>";
                        echo "<a href='editarcliente.php?idcliente={$item->idcliente}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                        echo "<a href='../controller/clientecontroller.php?idcliente={$item->idcliente}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Deseja realmente excluir este cliente?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
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