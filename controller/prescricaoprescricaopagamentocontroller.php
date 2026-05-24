<?php

session_start();
$base = __DIR__ . '/../../';


include_once $base . "config/conexao.php";
include_once $base . "model/entity/prescricaoprescricaopagamento.php";
include_once $base . "model/dao/prescricaoprescricaopagamentodao.php";

$predao = new prescricaodao();


if (isset($_GET["idprescricao_pagamento"])) {
    $resultado = $predao->delete($_GET["idprescricao_pagamento"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $pre = new prescricao(
        $_POST["idprescricao_pagamento"],
        $_POST["prescricaoprescricaopagamentofk"] ?? null,
        $_POST["pagamentoprescricaopagamentofk"] ?? null
    );

    if ($_POST["idprescricao_pagamento"] == "") {
        $resultado = $predao->create($pre);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $predao->update($pre);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}