<?php

session_start();
$base = __DIR__ . '/../../';

include_once $base . "config/conexao.php";
include_once $base . "model/entity/pet.php";
include_once $base . "model/dao/petdao.php";

$pdao = new petdao();

// Se receber requisição de exclusão via GET
if (isset($_GET["idpet"])) {
    $resultado = $pdao->delete($_GET["idpet"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

// Se receber requisição de salvar (Criar ou Editar) via POST
if (isset($_POST["btGravar"])) {
    $p = new pet(
        $_POST["idpet"],
        $_POST["petcolnome"],
        $_POST["especie"],
        $_POST["raca"],
        $_POST["idade"],
        $_POST["clientepetfk"] ?? null
    );

    if ($_POST["idpet"] == "") {
        $resultado = $pdao->create($p);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $pdao->update($p);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}
?>