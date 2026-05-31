<?php
session_start();

$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";
include_once $base . "model/entity/funcionario.php";
include_once $base . "model/dao/funcionariodao.php";


include __DIR__ . "/topo.html";

$cfdao = new funcionariodao();

?>

<?php
    if (isset($_SESSION["resultado"])) {
        if ($_SESSION["resultado"] == true) {
            echo "<p>{$_SESSION["mensagem"]}</p>";
        } else {
            echo "<p>Erro ao efetuar a operação.</p>";
        }
        $_SESSION["resultado"] = null;
        $_SESSION["mensagem"] = null;
    }

    if (isset($_GET["idfuncionario"])) {
        $result = $cfdao->readId($_GET["idfuncionario"]);

    } else {
        $result = ["idfuncionario" => "", "nome" => "", "celular" => "", "cpf" => "", "salario" => ""];
    }

?>

<form method="post" action="controller/funcionariocontroller.php">

    <input type="hidden" class="form-control" name="idfuncionario" value="<?php echo $result["idfuncionario"] ?>">
    <div class="col-md-4 offset-md-4 p-1">
        <input type="text" class="form-control" name="nome" placeholder="Digite o nome:" value="<?php echo $result["nome"] ?>" required>
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="text" class="form-control" name="cpf" placeholder="Digite o CPF:" value="<?php echo $result["cpf"] ?>" required>
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="tel" class="form-control" name="celular" placeholder="Digite o celular:" value="<?php echo $result["celular"] ?>" required>
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="tel" class="form-control" name="salario" placeholder="Digite o valor do salário:" value="<?php echo $result["salario"] ?>" required>
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="submit" value="Salvar" name="btGravar">
    </div>
</form>

<table class="table table-hover">
    <tr>
        <th>Nome</th>
        <th>CPF</th>
        <th>Celular</th>
        <th>Salário</th>
    </tr>

    <?php
    $result = $cfdao->read();
 
    if (is_null($result)) {
        echo "<tr><td colspan='6'>Erro ao buscar os dados do banco</td></tr>";
    } else {

        foreach ($result as $item) {
            echo "<tr>";
            echo "<td>" . $item->nome . "</td>";
            echo "<td>" . $item->cpf . "</td>";
            echo "<td>" . $item->celular . "</td>";
            echo "<td>" . $item->salario . "</td>";
            echo "<td>";
            //link para alterar
            echo "<a href='index.php?idfuncionario={$item->idfuncionario}'><img src='img/alterar.png' width='18'></a>";
            //link para deletar
            echo "<a href='controller/funcionariocontroller.php?idfuncionario={$item->idfuncionario}'><img src='img/apagar.png' width='18'></a>";
            echo "</td>";
            echo "</tr>";
        }
    }

    ?>
</table>
<?php
include __DIR__ . "/rodape.html";
?>