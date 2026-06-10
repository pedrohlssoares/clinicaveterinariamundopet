<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";
include_once $base . "model/dao/estatisticadao.php";

$edao = new estatisticaDao();

if (isset($_GET["action"]) && $_GET["action"] == "recalcular") {
    $dados_atualizados = $edao->obterIndicadoresGerais();
    if ($dados_atualizados !== null) {
        $_SESSION["indicadores_cache"] = $dados_atualizados;
        $_SESSION["mensagem_estatistica"] = "Métricas consolidadas com sucesso em tempo real!";
        $_SESSION["resultado_estatistica"] = true;
    } else {
        $_SESSION["mensagem_estatistica"] = "Erro crítico ao processar cubos estatísticos.";
        $_SESSION["resultado_estatistica"] = false;
    }
    header("location:../view/gerenciaestatistica.php");
    exit();
}
?>