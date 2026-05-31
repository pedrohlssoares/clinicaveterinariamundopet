<?php
session_start();

$base = __DIR__ . '/../'; 

include_once $base . "config/conexao.php";
include_once $base . "model/entity/veterinario.php";
include_once $base . "model/dao/veterinarioDao.php";

$vdao = new veterinarioDao();

if (isset($_GET["idveterinario"])) {
    $resultado = $vdao->delete($_GET["idveterinario"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $vet = new veterinario(
        $_POST["idveterinario"],
        $_POST["crmv"],
        $_POST["funcionarioveterinariofk"] ?? null,
        $_POST["descricao"]
    );

    if ($_POST["idveterinario"] == "") {
        $resultado = $vdao->create($vet);
        $_SESSION["mensagem"] = "Cadastro realizado com sucesso!";
    } else {
        $resultado = $vdao->update($vet);
        $_SESSION["mensagem"] = "Alteração realizada com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../view/index.php"); 
    exit();
}
?>