<?php
session_start();

$base = __DIR__ . '/../';  

include_once $base . "config/conexao.php";
include_once $base . "model/entity/pet.php";
include_once $base . "model/dao/petdao.php";


include __DIR__ . "/topo.html";

$petdao = new petdao();

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

    if (isset($_GET["idpet"])) {
        $result = $petdao->readId($_GET["idpet"]);

    } else {
        $result = ["idpet" => "", "petcolnome" => "", "especie" => "", "raca" => "", "idade" => ""];
    }

?>

<form method="post" action="controller/veterinariocontroller.php">

    <input type="hidden" class="form-control" name="idpet" value="<?php echo $result["idpet"] ?>">
    <div class="col-md-4 offset-md-4 p-1">
        <input type="text" class="form-control" name="petcolnome" placeholder="Digite o nome do pet:" value="<?php echo $result["petcolnome"] ?>" required>
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="text" class="form-control" name="especie" placeholder="Digite a espécie:" value="<?php echo $result["especie"] ?>" required>
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="text" class="form-control" name="raca" placeholder="Digite a raça:" value="<?php echo $result["raca"] ?>"> 
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="number" class="form-control" name="idade" placeholder="Digite a idade:" value="<?php echo $result["idade"] ?>" required>
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="submit" value="Salvar" name="btGravar">
    </div>
</form>

<table class="table table-hover">
    <tr>
        <th>Nome</th>
        <th>Espécie</th>
        <th>Raça</th>
        <th>Idade</th>
    </tr>

    <?php
    $result = $petdao->read();
 
    if (is_null($result)) {
        echo "<tr><td colspan='6'>Erro ao buscar os dados do banco</td></tr>";
    } else {

        foreach ($result as $item) {
            echo "<tr>";
            echo "<td>" . $item->petcolnome . "</td>";
            echo "<td>" . $item->especie . "</td>";
            echo "<td>" . $item->raca . "</td>";
            echo "<td>" . $item->idade . "</td>";
            echo "<td>";
            //link para alterar
            echo "<a href='index.php?idpet={$item->idpet}'><img src='img/alterar.png' width='18'></a>";
            //link para deletar
            echo "<a href='controller/petcontroller.php?idpet={$item->idpet}'><img src='img/apagar.png' width='18'></a>";
            echo "</td>";
            echo "</tr>";
        }
    }

    ?>
</table>
<?php
include __DIR__ . "/rodape.html";
?>