<?php
session_start();
$base = __DIR__ . '/../'; 

include_once $base . "config/conexao.php";
include_once $base . "model/entity/sala.php";
include_once $base . "model/dao/saladao.php";

$sdao = new salaDao();

// Diferente das outras tabelas, a chave primária de sala se chama "numero" e não "idsala"
if (isset($_GET["numero"])) {
    $resultado = $sdao->delete($_GET["numero"]);
    $_SESSION["mensagem"] = $resultado ? "Sala excluída com sucesso!" : "Erro ao excluir a sala. Pode existir alguma consulta agendada para ela.";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciasala.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $sala = new sala(
        $_POST["numero"],
        $_POST["tipo"],
        $_POST["descricao"]
    );

    if (empty($_POST["numero"])) {
        $resultado = $sdao->create($sala);
        $_SESSION["mensagem"] = $resultado ? "Sala cadastrada com sucesso!" : "Erro ao cadastrar a sala.";
    } else {
        $resultado = $sdao->update($sala);
        $_SESSION["mensagem"] = $resultado ? "Sala atualizada com sucesso!" : "Erro ao atualizar a sala.";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciasala.php"); 
    exit();
}
?>