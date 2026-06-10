<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";
include_once $base . "entity/model/historico_vacinacao.php";
include_once $base . "entity/dao/historico_vacinacaodao.php";

$hvdao = new historico_vacinacaoDao();

if (isset($_GET["idhistorico"])) {
    $resultado = $hvdao->delete($_GET["idhistorico"]);
    $_SESSION["mensagem"] = $resultado ? "Registro de vacinação excluído com sucesso!" : "Erro ao excluir o registro de vacinação.";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciahistorico_vacinacao.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $hv = new historico_vacinacao(
        $_POST["idhistorico"],
        $_POST["pethistorico_vacinacaofk"],
        $_POST["vacinahistorico_vacinacaofk"],
        $_POST["data_aplicacao"],
        $_POST["dosagem"]
    );

    if (empty($_POST["idhistorico"])) {
        $resultado = $hvdao->create($hv);
        $_SESSION["mensagem"] = $resultado ? "Vacinação registrada com sucesso!" : "Erro ao registrar vacinação.";
    } else {
        $resultado = $hvdao->update($hv);
        $_SESSION["mensagem"] = $resultado ? "Registro de vacinação atualizado com sucesso!" : "Erro ao atualizar registro de vacinação.";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciahistorico_vacinacao.php");
    exit();
}
?>