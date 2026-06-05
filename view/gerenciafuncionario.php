<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "model/entity/funcionario.php";
include_once $base . "model/dao/funcionariodao.php";
include_once $base . "model/entity/endereco.php";
include_once $base . "model/dao/enderecodao.php";

include __DIR__ . "/topo.html";

$fdao = new funcionarioDao();
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
        <h2 class="fw-light" style="color: var(--pet-dark);">Gerenciar Funcionário</h2>
        <a href="cadastrofuncionario.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> + Novo Funcionário
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th>Nome</th>
                    <th>Celular</th>
                    <th>CPF</th>
                    <th>Salário</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $fdao->read();
                
                if (is_null($result) || empty($result)) {
                    echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Nenhum cliente encontrado no sistema.</td></tr>";
                } else {
                    foreach ($result as $item) {
                        $end_list = $edao->readId($item->enderecofuncionariofk);
                        $cidade = $end_list ? $end_list->cidade : "Não informado";

                        echo "<tr>";
                        echo "<td class='fw-bold'>{$item->nome}</td>";
                        echo "<td>{$item->celular}</td>";
                        echo "<td>{$item->cpf}</td>";
                        echo "<td>{$item->salario}</td>";
                        echo "<td class='text-center'>";
                        echo "<a href='editarfuncionario.php?idfuncionario={$item->idfuncionario}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                        echo "<a href='../controller/funcionariocontroller.php?idfuncionario={$item->idfuncionario}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Deseja realmente excluir este funcionário?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
                        echo "</td>";
                        echo "</tr>";
                    } 
                } 
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
include __DIR__ . "/rodape.html"; 
?>