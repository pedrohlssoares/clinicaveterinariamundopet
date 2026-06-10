<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";

include_once $base ."entity/model/venda.php";
include_once $base ."entity/dao/vendadao.php";

$vdao = new vendaDao();

if (isset($_GET["idvenda"])) {
    $resultado = $vdao->delete($_GET["idvenda"]);
    $_SESSION["mensagem"] = $resultado ? "Item de venda excluído com sucesso!" : "Erro ao excluir o item de venda.";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciavenda.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $valor_unitario = str_replace(',', '.', $_POST["valor_unitario"]);
    $valor_unitario = floatval($valor_unitario);

    $vd = new venda(
        $_POST["idvenda"],
        $_POST["pagamentovendafk"],
        $_POST["produtovendafk"],
        intval($_POST["quantidade"]),
        $valor_unitario
    );

    if (empty($_POST["idvenda"])) {
        $resultado = $vdao->create($vd);
        $_SESSION["mensagem"] = $resultado ? "Venda registrada com sucesso!" : "Erro ao registrar a venda.";
    } else {
        $resultado = $vdao->update($vd);
        $_SESSION["mensagem"] = $resultado ? "Venda atualizada com sucesso!" : "Erro ao atualizar a venda.";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciavenda.php");
    exit();
}
?>