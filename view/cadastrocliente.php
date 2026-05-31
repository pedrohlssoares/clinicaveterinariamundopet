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

<div class="container mt-4">
    <h2 class="text-center">Cadastro de Cliente e Endereço</h2>
    <form method="post" action="../controller/clientecontroller.php">
        
        <input type="hidden" name="idcliente" value="<?php echo $res_cli["idcliente"] ?>">
        <input type="hidden" name="idendereco" value="<?php echo $res_end["idendereco"] ?>">

        <div class="row justify-content-center">
            <div class="col-md-5 border-end">
                <h4>Dados Pessoais</h4>
                <div class="p-1"><input type="text" class="form-control" name="nome" placeholder="Nome:" value="<?php echo $res_cli["nome"] ?>" required></div>
                <div class="p-1"><input type="text" class="form-control" name="cpf" placeholder="CPF:" value="<?php echo $res_cli["cpf"] ?>" required></div>
                <div class="p-1"><input type="email" class="form-control" name="email" placeholder="E-mail:" value="<?php echo $res_cli["email"] ?>"></div>
                <div class="p-1"><input type="tel" class="form-control" name="celular" placeholder="Celular:" value="<?php echo $res_cli["celular"] ?>"></div>
            </div>

            <div class="col-md-5">
                <h4>Endereço</h4>
                <div class="p-1"><input type="text" class="form-control" name="rua" placeholder="Rua:" value="<?php echo $res_end["rua"] ?>"></div>
                <div class="p-1"><input type="text" class="form-control" name="bairro" placeholder="Bairro:" value="<?php echo $res_end["bairro"] ?>"></div>
                <div class="p-1"><input type="text" class="form-control" name="cidade" placeholder="Cidade:" value="<?php echo $res_end["cidade"] ?>"></div>
                <div class="row p-1">
                    <div class="col-4"><input type="text" class="form-control" name="numero" placeholder="Nº:" value="<?php echo $res_end["numero"] ?>"></div>
                    <div class="col-8"><input type="text" class="form-control" name="complemento" placeholder="Comp.:" value="<?php echo $res_end["complemento"] ?>"></div>
                </div>
            </div>
        </div>

        <div class="col-md-10 offset-md-1 text-center mt-3">
            <input type="submit" class="btn btn-primary w-50" value="Gravar Tudo" name="btGravar">
        </div>
    </form>
</div>

<hr>

<table class="table table-hover mt-4">
    <thead class="table-dark">
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>E-mail</th>
            <th>Cidade</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $cdao->read();
        if (is_null($result) || empty($result)) {
            echo "<tr><td colspan='5' class='text-center'>Nenhum cliente cadastrado.</td></tr>";
        } else {
            foreach ($result as $item) {
                $end_list = $edao->readId($item->enderecoclientefk);
                $cidade = $end_list ? $end_list["cidade"] : "Não informado";

                echo "<tr>";
                echo "<td>{$item->nome}</td>";
                echo "<td>{$item->cpf}</td>";
                echo "<td>{$item->email}</td>";
                echo "<td>{$cidade}</td>";
                echo "<td>";
                echo "<a href='index.php?idcliente={$item->idcliente}' class='me-2'><img src='img/alterar.png' width='18'></a>";
                echo "<a href='../controller/clientecontroller.php?idcliente={$item->idcliente}' onclick='return confirm(\"Deseja excluir?\")'><img src='img/apagar.png' width='18'></a>";
                echo "</td>";
                echo "</tr>";
            }
        }
        ?>
    </tbody>
</table>

<?php include __DIR__ . "/rodape.html"; ?>
