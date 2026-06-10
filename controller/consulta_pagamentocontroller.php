<?php

session_start();
$base = __DIR__ . '/../../';


include_once $base . "config/conexao.php";
include_once $base . "entity/model/consulta_pagamento.php";
include_once $base . "entity/dao/consulta_pagamentodao.php";

$conpdao = new consulta_pagamentodao();


if (isset($_GET["idconsulta_pagamento"])) {
    $resultado = $conpdao->delete($_GET["idconsulta_pagamento"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $conp = new consulta_pagamento(
        $_POST["pagamentoconsulta_pagamentofk"] ?? null,
        $_POST["consultaconsulta_pagamentofk"] ?? null,
    );

    if ($_POST["idconsulta_pagamento"] == "") {
        $resultado = $conpdao->create($conp);
        $_SESSION["mensagem"] = "Cadastrado com sucesso!";
    } else {
        $resultado = $conpdao->update($conp);
        $_SESSION["mensagem"] = "Alterado com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../index.php");
    exit();
}