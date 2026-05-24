<?php

session_start();
$base = __DIR__ . '/../../';


include_once $base . "config/conexao.php";
include_once $base . "model/entity/forma_pagamento.php";
include_once $base . "model/dao/forma_pagamentodao.php";

$fpdao = new forma_pagamentodao();


if (isset($_GET["idforma_pagamento"])) {
    $resultado = $fpdao->delete($_GET["idforma_pagamento"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $fp = new forma_pagamento(
        $_POST["idforma_pagamento"],
        $_POST["tipo"],
        $_POST["descricao"]
    );

    if ($_POST["idforma_pagamento"] == "") {
        $resultado = $fpdao->create($fp);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $fpdao->update($fp);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}