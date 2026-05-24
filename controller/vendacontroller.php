<?php

session_start();
$base = __DIR__ . '/../../';


include_once $base . "config/conexao.php";
include_once $base . "model/entity/venda.php";
include_once $base . "model/dao/vendadao.php";

$vedao = new venda();


if (isset($_GET["idvenda"])) {
    $resultado = $vedao->delete($_GET["idvenda"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $ve = new venda(
        $_POST["idvenda"],
        $_POST["pagamentovendafk"] ?? null,
        $_POST["produtovendafk"] ?? null
    );

    if ($_POST["idvenda"] == "") {
        $resultado = $vedao->create($ve);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $vedao->update($ve);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}