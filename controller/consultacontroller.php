<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";
include_once $base . "model/entity/consulta.php";
include_once $base . "model/dao/consultadao.php";

$codao = new consultadao();

// Se receber um parâmetro de filtro de data via GET
if (isset($_GET["txtDataFiltro"])) {
    // Nota: O método readPorData precisa existir no seu consultadao.php
    $resultado = $codao->readPorData($_GET["txtDataFiltro"]);
    $_SESSION["consultas_filtradas"] = $resultado;
    header("location:../view/gerenciaconsulta.php");
    exit();
}

// Se receber requisição de exclusão via GET
if (isset($_GET["idconsulta"])) {
    $resultado = $codao->delete($_GET["idconsulta"]);
    $_SESSION["mensagem"] = $resultado ? "Consulta cancelada/excluída com sucesso!" : "Erro ao excluir a consulta.";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciaconsulta.php");
    exit();
}

// Se receber requisição de salvar (Criar ou Editar) via POST
if (isset($_POST["btGravar"])) {
    
    // CORREÇÃO: Passando os 9 parâmetros exigidos pela classe consulta
    $co = new consulta(
        $_POST["idconsulta"],
        $_POST["petconsultafk"],
        $_POST["veterinarioconsultafk"] ?? null,
        $_POST["salaconsultafk"] ?? null,
        null, // 5º Parâmetro: pagamentoconsultafk (null pois ainda não foi pago)
        $_POST["data"],
        $_POST["horario"], 
        'Agendada', // 8º Parâmetro: status inicial da consulta
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
    // Sempre redireciona para a tela de gerência
    header("location:../view/gerenciaconsulta.php");
    exit();
}
?>