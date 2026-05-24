<?php

session_start();
$base = __DIR__ . '/../../';


include_once $base . "config/conexao.php";
include_once $base . "model/entity/funcionario.php";
include_once $base . "model/dao/funcionariodao.php";

$fdao = new funcionariodao();


if (isset($_GET["idfuncionario"])) {
    $resultado = $fdao->delete($_GET["idfuncionario"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $f = new funcionario(
        $_POST["idfuncionario"],
        $_POST["nome"],
        $_POST["celular"],
        $_POST["cpf"],
        $_POST["salario"],
        $_POST["enderecofuncionariofk"] ?? null
    );

    if ($_POST["idfuncionario"] == "") {
        $resultado = $fdao->create($f);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $fdao->update($f);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}