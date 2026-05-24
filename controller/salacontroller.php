<?php

session_start();
$base = __DIR__ . '/../../';


include_once $base . "config/conexao.php";
include_once $base . "model/entity/sala.php";
include_once $base . "model/dao/saladao.php";

$sdao = new sala();


if (isset($_GET["numero"])) {
    $resultado = $sdao->delete($_GET["numero"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $s = new sala(
        $_POST["numero"]
    );

    if ($_POST["numero"] == "") {
        $resultado = $sdao->create($s);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $sdao->update($s);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}