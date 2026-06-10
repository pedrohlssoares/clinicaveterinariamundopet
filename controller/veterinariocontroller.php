<?php
session_start();

$base = __DIR__ . '/../'; 

include_once $base . "config/conexao.php";
include_once $base . "entity/model/veterinario.php";
include_once $base . "entity/dao/veterinarioDao.php";

$vdao = new veterinarioDao();

if (isset($_GET["idveterinario"])) {
    $resultado = $vdao->delete($_GET["idveterinario"]);
    $_SESSION["mensagem"] = $resultado ? "Excluído com sucesso!" : "Erro ao excluir o veterinário. Ele pode estar associado a alguma consulta.";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciaveterinario.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $vet = new veterinario(
        $_POST["idveterinario"],
        $_POST["crmv"],
        $_POST["funcionarioveterinariofk"] ?? null,
        $_POST["descricao"]
    );

    if (empty($_POST["idveterinario"])) {
        $resultado = $vdao->create($vet);
        $_SESSION["mensagem"] = $resultado ? "Cadastro realizado com sucesso!" : "Erro ao cadastrar veterinário.";
    } else {
        $resultado = $vdao->update($vet);
        $_SESSION["mensagem"] = $resultado ? "Alteração realizada com sucesso!" : "Erro ao alterar veterinário.";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciaveterinario.php"); 
    exit();
}
?>
