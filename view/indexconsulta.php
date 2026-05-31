<?php
session_start();

$base = __DIR__ . '/../';  

include_once $base . "config/conexao.php";
include_once $base . "model/entity/consulta.php";
include_once $base . "model/dao/consultadao.php";

include __DIR__ . "/topo.html";

$codao = new consultadao();

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

    if (isset($_GET["idconsulta"])) {
        $result = $codao->readId($_GET["idconsulta"]);

    } else {
        $result = ["idconsulta" => "", "data" => "", "processos_feitos" => ""];
    }

?>

<form method="post" action="controller/consultacontroller.php">

    <input type="hidden" class="form-control" name="idconsulta" value="<?php echo $result["idconsulta"] ?>">
    <div class="col-md-4 offset-md-4 p-1">
        <input type="date" class="form-control" name="data" placeholder="Data da consulta:" value="<?php echo $result["data"] ?>" required>
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="textarea" class="form-control" name="processos_feitos" placeholder="Procedimentos realizados durante a consulta:" value="<?php echo $result["processos_feitos"] ?>" required>
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="submit" value="Salvar" name="btGravar">
    </div>
</form>

<table class="table table-hover">
    <tr>
        <th>Data da consulta</th>
        <th>Procedimentos realizados</th>
    </tr>

    <?php
    $result = $codao->read();
 
    if (is_null($result)) {
        echo "<tr><td colspan='6'>Erro ao buscar os dados do banco</td></tr>";
    } else {

        foreach ($result as $item) {
            echo "<tr>";
            echo "<td>" . $item->data . "</td>";
            echo "<td>" . $item->processos_feitos . "</td>";
            echo "<td>";
            //link para alterar
            echo "<a href='index.php?idconsulta={$item->idconsulta}'><img src='img/alterar.png' width='18'></a>";
            //link para deletar
            echo "<a href='controller/consultacontroller.php?idconsulta={$item->idconsulta}'><img src='img/apagar.png' width='18'></a>";
            echo "</td>";
            echo "</tr>";
        }
    }

    ?>
</table>
<?php
include __DIR__ . "/rodape.html";
?>