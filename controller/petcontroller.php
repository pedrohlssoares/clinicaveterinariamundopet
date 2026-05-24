<?php

session_start();
$base = __DIR__ . '/../../';

include_once $base . "config/conexao.php";
include_once $base . "model/entity/pet.php";
include_once $base . "model/dao/petdao.php";

$petdao = new petdao();

if (isset($_GET["idpet"])) {
    $resultado = $petdao->delete($_GET["idpet"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $pet = new pet(
        $_POST["idpet"],
        $_POST["petcolnome"],
        $_POST["especie"],
        $_POST["raca"],
        $_POST["idade"],
        $_POST["clientepetfk"] ?? null
    );

    if ($_POST["idpet"] == "") {
        $resultado = $petdao->create($pet);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $petdao->update($pet);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}