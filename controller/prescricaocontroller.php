<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";

if (file_exists($base . "model/entity/prescricao.php")) {
    include_once $base . "model/entity/prescricao.php";
    include_once $base . "model/dao/prescricaodao.php";
} else {
    include_once $base . "entity/model/prescricao.php";
    include_once $base . "entity/dao/prescricaodao.php";
}

$prdao = new prescricaoDao();

if (isset($_GET["idprescricao"])) {
    $resultado = $prdao->delete($_GET["idprescricao"]);
    $_SESSION["mensagem"] = ($resultado === true) ? "Prescrição excluída com sucesso!" : "Erro SQL: " . $resultado;
    $_SESSION["resultado"] = ($resultado === true);
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
            // AQUI É A MÁGICA: O DAO VAI DEVOLVER O ERRO DO MYSQL PARA A TELA!
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