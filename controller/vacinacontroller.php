<?php

session_start();
$base = __DIR__ . '/../../';


include_once $base . "config/conexao.php";
include_once $base . "model/entity/vacina.php";
include_once $base . "model/dao/vacinadao.php";

$vdao = new vacina();


if (isset($_GET["idvacina"])) {
    $resultado = $vdao->delete($_GET["idvacina"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $s = new vacina(
        $_POST["idvacina"],
        $_POST["produtovacinafk"] ?? null,
        $_POST["idativo"],
        $_POST["idlote"],
    );

    if ($_POST["idvacina"] == "") {
        $resultado = $vdao->create($v);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $vdao->update($v);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}