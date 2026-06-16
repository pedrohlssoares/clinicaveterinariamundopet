<?php

session_start();
$base = __DIR__ . '/../../';


include_once $base . "config/conexao.php";
include_once $base . "model/entity/funcionario.php";
include_once $base . "model/dao/funcionariodao.php";

$prdao = new prescricaoDao();


if (isset($_GET["idprescricao"])) {
    $resultado = $prdao->delete($_GET["idprescricao"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $pr = new prescricao(
        $_POST["idprescricao"],
        $_POST["consultaprescricaofk"] ?? null,
        $_POST["remedioprescricaofk"] ?? null,
        $_POST["vacinaprescricaofk"] ??  null,
        $_POST["dosagem"]
    );

    if ($_POST["idprescricao"] == "") {
        $resultado = $prdao->create($pr);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $prdao->update($pr);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../gerenciaprescricao.php");
    exit();
}