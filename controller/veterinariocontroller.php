<?php

session_start();
$base = __DIR__ . '/../../';


include_once $base . "config/conexao.php";
include_once $base . "model/entity/veterinario.php";
include_once $base . "model/dao/veterinariodao.php";

$vetdao = new veterinariodao();


if (isset($_GET["idveterinario"])) {
    $resultado = $vetdao->delete($_GET["idveterinario"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $vet = new veterinario(
        $_POST["idveterinario"],
        $_POST["crmv"],
        $_POST["funcionarioveterinariofk"] ?? null,
        $_POST["descricao"]
    );

    if ($_POST["idveterinario"] == "") {
        $resultado = $vetdao->create($vet);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $vetdao->update($vet);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}