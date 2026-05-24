<?php

session_start();
$base = __DIR__ . '/../../';


include_once $base . "config/conexao.php";
include_once $base . "model/entity/pagamento.php";
include_once $base . "model/dao/pagamentodao.php";

$padao = new pagamentodao();


if (isset($_GET["idpagamento"])) {
    $resultado = $padao->delete($_GET["idpagamento"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $pa = new pagamento(
        $_POST["idpagamento"],
        $_POST["prestacoes"],
        $_POST["valor"],
        $_POST["formapagamentofk"] ?? null
    );

    if ($_POST["idpagamento"] == "") {
        $resultado = $padao->create($p);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $padao->update($p);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}