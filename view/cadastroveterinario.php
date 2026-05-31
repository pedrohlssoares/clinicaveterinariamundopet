<?php
session_start();

//select para escolher o funcionario a cadastrar como veterinario


$base = __DIR__ . '/../';  

include_once $base . "config/conexao.php";
include_once $base . "model/entity/veterinario.php";
include_once $base . "model/dao/veterinariodao.php";


include __DIR__ . "/topo.html";

$vetdao = new veterinariodao();

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

    if (isset($_GET["idveterinario"])) {
        $result = $vetdao->readId($_GET["idveterinario"]);

    } else {
        $result = ["idveterinario" => "", "crmv" => "", "descricao" => ""];
    }

?>

<form method="post" action="controller/veterinariocontroller.php">

    <input type="hidden" class="form-control" name="idveterinario" value="<?php echo $result["idveterinario"] ?>">
    <div class="col-md-4 offset-md-4 p-1">
        <input type="text" class="form-control" name="crmv" placeholder="Digite o CRMV:" value="<?php echo $result["crmv"] ?>" required>
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="textarea" class="form-control" name="descricao" placeholder="Digite a descrição:" value="<?php echo $result["descricao"] ?>">
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="submit" value="Salvar" name="btGravar">
    </div>
</form>

<table class="table table-hover">
    <tr>
        <th>CRMV</th>
        <th>Descrição</th>
    </tr>

    <?php
    $result = $vetdao->read();
 
    if (is_null($result)) {
        echo "<tr><td colspan='6'>Erro ao buscar os dados do banco</td></tr>";
    } else {

        foreach ($result as $item) {
            echo "<tr>";
            echo "<td>" . $item->crmv . "</td>";
            echo "<td>" . $item->descricao . "</td>";
            echo "<td>";
            //link para alterar
            echo "<a href='index.php?idveterinario={$item->idveterinario}'><img src='img/alterar.png' width='18'></a>";
            //link para deletar
            echo "<a href='controller/veterinariocontroller.php?idveterinario={$item->idveterinario}'><img src='img/apagar.png' width='18'></a>";
            echo "</td>";
            echo "</tr>";
        }
    }

    ?>
</table>
<?php
include __DIR__ . "/rodape.html";
?>