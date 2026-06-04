<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";
include_once $base . "model/entity/pet.php";
include_once $base . "model/dao/petdao.php";

$pdao = new petDao();

if (isset($_GET["idpet"])) {
    $resultado = $pdao->delete($_GET["idpet"]);
    $_SESSION["mensagem"] = $resultado ? "Excluído com sucesso!" : "Erro ao excluir. Verifique vínculos na base de dados.";
    $_SESSION["resultado"] = $resultado;
    # Agora redireciona sempre para a tabela
    header("location:../view/gerenciapet.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $clientepetfk = !empty($_POST["clientepetfk"]) ? $_POST["clientepetfk"] : null;

    $p = new pet(
        $_POST["idpet"],
        $_POST["nome"], 
        $_POST["especie"],
        $_POST["raca"],
        $_POST["idade"],
        $clientepetfk
    );

    if (empty($_POST["idpet"])) {
        $resultado = $pdao->create($p);
        $_SESSION["mensagem"] = $resultado ? "Pet cadastrado com sucesso!" : "Erro ao cadastrar pet. Verifique os dados.";
    } else {
        $resultado = $pdao->update($p);
        $_SESSION["mensagem"] = $resultado ? "Pet alterado com sucesso!" : "Erro ao alterar pet.";
    }

    $_SESSION["resultado"] = $resultado;
    # Sempre redireciona para a tela de gerência para ver o resultado na tabela
    header("location:../view/gerenciapet.php");
    exit();
}
?>
