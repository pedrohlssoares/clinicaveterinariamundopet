<?php
session_start();

$base = __DIR__ . '/../';  

include_once $base . "config/conexao.php";
include_once $base . "model/entity/cliente.php";
include_once $base . "model/dao/clientedao.php";
include_once $base . "model/entity/endereco.php";
include_once $base . "model/dao/enderecodao.php";

include __DIR__ . "/topo.html";

$cdao = new clientedao();
$edao = new enderecodao();

if (isset($_SESSION["resultado"])) {
    $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
    echo "<div class='alert {$classe}'>{$_SESSION["mensagem"]}</div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}

if (isset($_GET["idcliente"])) {
    $res_cli = $cdao->readId($_GET["idcliente"]);
    $res_end = $edao->readId($res_cli["enderecoclientefk"]);
} else {
    $res_cli = ["idcliente" => "", "nome" => "", "cpf" => "", "email" => "", "celular" => "", "enderecoclientefk" => ""];
    $res_end = ["idendereco" => "", "rua" => "", "cidade" => "", "bairro" => "", "numero" => "", "complemento" => ""];
}
?>

<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 pt-4">
            <h2 class="text-center fw-light" style="color: var(--pet-green);">🐾 Cadastro de Cliente e Endereço</h2>
        </div>
        <div class="card-body p-4">
            <form method="post" action="../controller/clientecontroller.php">
                
                <input type="hidden" name="idcliente" value="<?php echo $res_cli["idcliente"] ?>">
                <input type="hidden" name="idendereco" value="<?php echo $res_end["idendereco"] ?>">

                <div class="row justify-content-center">
                    <div class="col-md-5 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Dados Pessoais</h4>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="nome" placeholder="Nome completo" value="<?php echo $res_cli["nome"] ?>" required></div>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="cpf" placeholder="CPF" value="<?php echo $res_cli["cpf"] ?>" required></div>
                        <div class="mb-3"><input type="email" class="form-control custom-input" name="email" placeholder="E-mail" value="<?php echo $res_cli["email"] ?>"></div>
                        <div class="mb-3"><input type="tel" class="form-control custom-input" name="celular" placeholder="Celular/WhatsApp" value="<?php echo $res_cli["celular"] ?>"></div>
                    </div>

                    <div class="col-md-5 px-4 border-start">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Endereço</h4>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="rua" placeholder="Rua" value="<?php echo $res_end["rua"] ?>"></div>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="bairro" placeholder="Bairro" value="<?php echo $res_end["bairro"] ?>"></div>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="cidade" placeholder="Cidade" value="<?php echo $res_end["cidade"] ?>"></div>
                        <div class="row g-2">
                            <div class="col-4"><input type="text" class="form-control custom-input" name="numero" placeholder="Nº" value="<?php echo $res_end["numero"] ?>"></div>
                            <div class="col-8"><input type="text" class="form-control custom-input" name="complemento" placeholder="Complemento" value="<?php echo $res_end["complemento"] ?>"></div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Gravar Informações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-5 mb-5">
        <h3 class="h4 mb-3 fw-light" style="color: var(--pet-dark);">Clientes Cadastrados</h3>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle mb-0 bg-white">
                <thead class="custom-thead text-white">
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>E-mail</th>
                        <th>Cidade</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $cdao->read();
                    if (is_null($result) || empty($result)) {
                        echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Nenhum cliente encontrado no sistema.</td></tr>";
                    } else {
                        foreach ($result as $item) {
                            $end_list = $edao->readId($item->enderecoclientefk);
                            $cidade = $end_list ? $end_list["cidade"] : "Não informado";

                            echo "<tr>";
                            echo "<td class='fw-bold'>{$item->nome}</td>";
                            echo "<td>{$item->cpf}</td>";
                            echo "<td>{$item->email}</td>";
                            echo "<td><span class='badge bg-light text-dark border'>{$cidade}</span></td>";
                            echo "<td class='text-center'>";
                            echo "<a href='index.php?idcliente={$item->idcliente}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                            echo "<a href='../controller/clientecontroller.php?idcliente={$item->idcliente}' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Deseja realmente excluir este cliente?\")' title='Excluir'><img src='img/apagar.png' width='16'></a>";
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
