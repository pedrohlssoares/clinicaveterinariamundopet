<?php

session_start();
$base = __DIR__ . '/../../';


include_once $base . "config/conexao.php";
include_once $base . "model/entity/consulta.php";
include_once $base . "model/dao/consultadao.php";

$codao = new consultadao();


if (isset($_GET["idconsulta"])) {
    $resultado = $codao->delete($_GET["idconsulta"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $co = new consulta(
        $_POST["idconsulta"],
        $_POST["petconsultafk"],
        $_POST["veterinarioconsultafk"] ?? null,
        $_POST["salaconsultafk"] ?? null,
        $_POST["data"],
        $_POST["processos_feitos"] ?? null
    );

    if ($_POST["idconsulta"] == "") {
        $resultado = $codao->create($co);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $codao->update($co);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}