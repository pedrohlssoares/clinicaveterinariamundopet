<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";
include_once $base . "model/entity/consulta.php";
include_once $base . "model/dao/consultadao.php";

$codao = new consultadao();

if (isset($_GET["txtDataFiltro"])) {
    $resultado = $codao->readPorData($_GET["txtDataFiltro"]);
    $_SESSION["consultas_filtradas"] = $resultado;
    header("location:../view/gerenciaconsulta.php");
    exit();
}

if (isset($_GET["idconsulta"])) {
    $resultado = $codao->delete($_GET["idconsulta"]);
    $_SESSION["mensagem"] = $resultado ? "Consulta cancelada/excluída com sucesso!" : "Erro ao excluir a consulta.";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciaconsulta.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    
    $co = new consulta(
        $_POST["idconsulta"],
        $_POST["petconsultafk"],
        $_POST["veterinarioconsultafk"] ?? null,
        $_POST["salaconsultafk"] ?? null,
        null,
        $_POST["data"],
        $_POST["horario"], 
        'Agendada',
        $_POST["processos_feitos"] ?? null
    );

    if (empty($_POST["idconsulta"])) {
        $resultado = $codao->create($co);
        $_SESSION["mensagem"] = $resultado ? "Agendamento realizado com sucesso!" : "Erro ao agendar consulta.";
    } else {
        $resultado = $codao->update($co);
        $_SESSION["mensagem"] = $resultado ? "Consulta atualizada com sucesso!" : "Erro ao alterar consulta.";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciaconsulta.php");
    exit();
}
?>
