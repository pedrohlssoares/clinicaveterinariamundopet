<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";

include_once $base . "entity/model/prescricao.php";
include_once $base . "entity/dao/prescricaodao.php";


$prdao = new prescricaoDao();

if (isset($_GET["idprescricao"])) {
    $_SESSION["mensagem"] = "Acesso Negado: Não é permitida a exclusão de prescrições médicas por motivos de auditoria clínica.";
    $_SESSION["resultado"] = false;
    header("location:../view/gerenciaprescricao.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $consultafk = !empty($_POST["consultaprescricaofk"]) ? $_POST["consultaprescricaofk"] : null;
    $remediofk = !empty($_POST["remedioprescricaofk"]) ? $_POST["remedioprescricaofk"] : null;
    $vacinafk = !empty($_POST["vacinaprescricaofk"]) ? $_POST["vacinaprescricaofk"] : null;

    $pr = new prescricao(
        $_POST["idprescricao"],
        $consultafk,
        $remediofk,
        $vacinafk,
        $_POST["dosagem"]
    );

    if (empty($_POST["idprescricao"])) {
        $resultado = $prdao->create($pr);
        if ($resultado === true) {
            $_SESSION["mensagem"] = "Prescrição cadastrada com sucesso!";
            $_SESSION["resultado"] = true;
        } else {
            $_SESSION["mensagem"] = "FALHA NO MYSQL: " . $resultado;
            $_SESSION["resultado"] = false;
        }
    } else {
        $resultado = $prdao->update($pr);
        if ($resultado === true) {
            $_SESSION["mensagem"] = "Prescrição atualizada com sucesso!";
            $_SESSION["resultado"] = true;
        } else {
            $_SESSION["mensagem"] = "FALHA NO MYSQL: " . $resultado;
            $_SESSION["resultado"] = false;
        }
    }

    header("location:../view/gerenciaprescricao.php");
    exit();
}
?>