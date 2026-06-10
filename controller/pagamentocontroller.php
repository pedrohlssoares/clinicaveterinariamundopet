<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";

include_once $base . "entity/model/pagamento.php";
include_once $base . "entity/dao/pagamentodao.php";

$pdao = new pagamentoDao();

if (isset($_GET["idpagamento"])) {
    $resultado = $pdao->delete($_GET["idpagamento"]);
    $_SESSION["mensagem"] = $resultado ? "Pagamento excluído com sucesso!" : "Erro ao excluir o pagamento.";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciapagamento.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $consultafk = !empty($_POST["consultapagamentofk"]) ? $_POST["consultapagamentofk"] : null;
    $prescricaofk = !empty($_POST["prescricaopagamentofk"]) ? $_POST["prescricaopagamentofk"] : null;
    
    $valor = str_replace(',', '.', $_POST["valor"]);
    $valor = floatval($valor);

    $pag = new pagamento(
        $_POST["idpagamento"],
        intval($_POST["prestacoes"]),
        $valor,
        $_POST["data_pagamento"],
        $_POST["formapagamentofk"],
        $_POST["clientepagamentofk"],
        $consultafk,
        $prescricaofk
    );

    if (empty($_POST["idpagamento"])) {
        $resultado = $pdao->create($pag);
        $_SESSION["mensagem"] = $resultado ? "Pagamento registrado com sucesso!" : "Erro ao registrar o pagamento.";
    } else {
        $resultado = $pdao->update($pag);
        $_SESSION["mensagem"] = $resultado ? "Pagamento atualizado com sucesso!" : "Erro ao atualizar o pagamento.";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciapagamento.php");
    exit();
}
?>