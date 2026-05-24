<?php

session_start();
$base = __DIR__ . '/../../';


include_once $base . "config/conexao.php";
include_once $base . "model/entity/historico_vacinacao.php";
include_once $base . "model/dao/historico_vacinacaodao.php";

$hdao = new historico_vacinacaodao();


if (isset($_GET["idhistorico"])) {
    $resultado = $hdao->delete($_GET["idhistorico"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $h = new historico_vacinacao(
        $_POST["idhistorico"],
        $_POST["vacinahistorico_vacinacaofk"] ?? null,
        $_POST["pethistoricofk"] ?? null
    );

    if ($_POST["idhistorico"] == "") {
        $resultado = $hdao->create($h);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $hdao->update($h);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}