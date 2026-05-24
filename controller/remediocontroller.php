<?php

session_start();
$base = __DIR__ . '/../../';


include_once $base . "config/conexao.php";
include_once $base . "model/entity/remedio.php";
include_once $base . "model/dao/remediodao.php";

$rdao = new remediodao();


if (isset($_GET["idremedio"])) {
    $resultado = $rdao->delete($_GET["idremedio"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $r = new remedio(
        $_POST["idremedio"],
        $_POST["produtoremediofk"] ?? null,
        $_POST["ativo"],
        $_POST["lote"]
    );

    if ($_POST["idremedio"] == "") {
        $resultado = $rdao->create($r);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $rdao->update($r);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}