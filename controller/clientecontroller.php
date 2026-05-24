<?php

session_start();
$base = __DIR__ . '/../../';

include_once $base . "config/conexao.php";
include_once $base . "model/entity/cliente.php";
include_once $base . "model/dao/clientedao.php";

$cdao = new clientedao();


if (isset($_GET["idcliente"])) {
    $resultado = $cdao->delete($_GET["idcliente"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $c = new cliente(
        $_POST["idcliente"],
        $_POST["nome"],
        $_POST["cpf"],
        $_POST["email"],
        $_POST["celular"],
        $_POST["enderecoclientefk"] ?? null
    );

    if ($_POST["idcliente"] == "") {
        $resultado = $cdao->create($c);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $cdao->update($c);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}