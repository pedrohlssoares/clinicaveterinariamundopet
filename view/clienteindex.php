<?php
session_start();

$base = __DIR__ . '/../';  

include_once $base . "config/conexao.php";
include_once $base . "model/entity/cliente.php";
include_once $base . "model/dao/clientedao.php";

include __DIR__ . "/topo.html";

$cdao = new clientedao();

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

    if (isset($_GET["idcliente"])) {
        $result = $cdao->readId($_GET["idcliente"]);

    } else {
        $result = ["idcliente" => "", "nome" => "", "cpf" => "", "email" => "", "celular" => ""];
    }
?>

<form method="post" action="controller/clientecontroller.php">

    <input type="hidden" class="form-control" name="idcliente" value="<?php echo $result["idcliente"] ?>">
    <div class="col-md-4 offset-md-4 p-1">
        <input type="text" class="form-control" name="nome" placeholder="Digite o nome:" value="<?php echo $result["nome"] ?>">
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="text" class="form-control" name="cpf" placeholder="Digite o CPF:" value="<?php echo $result["cpf"] ?>">
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="email" class="form-control" name="email" placeholder="Digite o email:" value="<?php echo $result["email"] ?>">
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="tel" class="form-control" name="celular" placeholder="Digite o número de celular:" value="<?php echo $result["celular"] ?>">
    </div>
    <div class="col-md-4 offset-md-4 p-1">
        <input type="submit" value="Gravar" name="btGravar">
    </div>
</form>

<table class="table table-hover">
    <tr>
        <th>Nome</th>
        <th>CPF</th>
        <th>E-mail</th>
        <th>Celular</th>
    </tr>

    <?php
    $result = $cdao->read();
 
    if (is_null($result)) {
        echo "<tr><td colspan='6'>Erro ao buscar os dados do banco</td></tr>";
    } else {

        foreach ($result as $item) {
            echo "<tr>";
            echo "<td>" . $item->nome . "</td>";
            echo "<td>" . $item->cpf . "</td>";
            echo "<td>" . $item->email . "</td>";
            echo "<td>" . $item->celular . "</td>";
            echo "<td>";
            //link para alterar
            echo "<a href='index.php?idcliente={$item->idcliente}'><img src='img/alterar.png' width='18'></a>";
            //link para deletar
            echo "<a href='controller/clientecontroller.php?idcliente={$item->idcliente}'><img src='img/apagar.png' width='18'></a>";
            echo "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>
<?php
include __DIR__ . "/rodape.html";
?>