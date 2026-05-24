<?php

session_start();
$base = __DIR__ . '/../../';


include_once $base . "config/conexao.php";
include_once $base . "model/entity/produto.php";
include_once $base . "model/dao/produtodao.php";

$prodao = new produtodao();


if (isset($_GET["idproduto"])) {
    $resultado = $prodao->delete($_GET["idproduto"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $pro = new produto(
        $_POST["idproduto"],
        $_POST["nome"],
        $_POST["quantidade"],
        $_POST["descricao"],
        $_POST["preco"]
    );

    if ($_POST["idproduto"] == "") {
        $resultado = $prodao->create($pro);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $prodao->update($pro);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}