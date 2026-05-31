<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";
include_once $base . "model/entity/funcionario.php";
include_once $base . "model/dao/funcionariodao.php";
include_once $base . "model/entity/endereco.php";
include_once $base . "model/dao/enderecodao.php";

include __DIR__ . "/topo.html";

$cfdao = new funcionariodao();
$edao = new enderecodao();
?>

<div class="container mt-5">
    <?php
    if (isset($_SESSION["resultado"])) {
        $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
        echo "<div class='alert {$classe} shadow-sm'>{$_SESSION["mensagem"]}</div>";
        $_SESSION["resultado"] = null;
        $_SESSION["mensagem"] = null;
    }
    ?>

    <?php
    if (isset($_GET["idfuncionario"])) {
        $result = $cfdao->readId($_GET["idfuncionario"]);
        $res_end = $edao->readId($result["enderecofuncionariofk"]); 
    } else {
        $result = ["idfuncionario" => "", "nome" => "", "celular" => "", "cpf" => "", "salario" => "", "enderecofuncionariofk" => ""];
        $res_end = ["idendereco" => "", "rua" => "", "cidade" => "", "bairro" => "", "numero" => "", "complemento" => ""];
    }
    ?>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 pt-4">
            <h2 class="text-center fw-light" style="color: var(--pet-green);">🐾 Cadastro de Funcionário e Endereço</h2>
        </div>
        <div class="card-body p-4">
            <form method="post" action="../controller/funcionariocontroller.php">

                <input type="hidden" name="idfuncionario" value="<?php echo $result["idfuncionario"] ?>">
                <input type="hidden" name="idendereco" value="<?php echo $res_end["idendereco"] ?>">

                <div class="row justify-content-center">
                    <div class="col-md-5 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Dados Profissionais</h4>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="nome" placeholder="Nome Completo" value="<?php echo $result["nome"] ?>" required></div>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="cpf" placeholder="CPF" value="<?php echo $result["cpf"] ?>" required></div>
                        <div class="mb-3"><input type="tel" class="form-control custom-input" name="celular" placeholder="Celular" value="<?php echo $result["celular"] ?>" required></div>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="salario" placeholder="Salário (R$)" value="<?php echo $result["salario"] ?>" required></div>
                    </div>

                    <div class="col-md-5 px-4 border-start">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Endereço Residencial</h4>
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
                        Salvar Funcionário
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-5 mb-5">
        <h3 class="h4 mb-3 fw-light" style="color: var(--pet-dark);">Equipe Mundo Pet</h3>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle mb-0 bg-white">
                <thead class="custom-thead text-white">
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Celular</th>
                        <th>Salário</th>
                        <th>Cidade</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $lista = $cfdao->read();
                    if (is_null($lista) || empty($lista)) {
                        echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Nenhum funcionário cadastrado.</td></tr>";
                    } else {
                        foreach ($lista as $item) {
                            $end_item = $edao->readId($item->enderecofuncionariofk);
                            $cidade = $end_item ? $end_item["cidade"] : "---";

                            echo "<tr>";
                            echo "<td class='fw-bold'>{$item->nome}</td>";
                            echo "<td>{$item->cpf}</td>";
                            echo "<td>{$item->celular}</td>";
                            echo "<td>R$ " . number_format($item->salario, 2, ',', '.') . "</td>";
                            echo "<td><span class='badge bg-light text-dark border'>{$cidade}</span></td>";
                            echo "<td class='text-center'>";
                            echo "<a href='index.php?idfuncionario={$item->idfuncionario}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                            echo "<a href='../controller/funcionariocontroller.php?idfuncionario={$item->idfuncionario}' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Deseja excluir este funcionário?\")' title='Excluir'><img src='img/apagar.png' width='16'></a>";
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
