<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";
include_once $base . "model/entity/vacina.php";
include_once $base . "model/dao/vacinadao.php";

// CORREÇÃO CRÍTICA 1: Instanciar o DAO corretamente (estava new vacina() no código original)
$vdao = new vacinaDao();

if (isset($_GET["idvacina"])) {
    $resultado = $vdao->delete($_GET["idvacina"]);
    $_SESSION["mensagem"] = $resultado ? "Excluído com sucesso!" : "Erro ao excluir a vacina.";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciavacina.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    
    // CORREÇÃO CRÍTICA 2 e 3: Consistência na variável $v e nomes corretos do form ('ativo' e 'lote')
    $v = new vacina(
        $_POST["idvacina"],
        $_POST["produtovacinafk"] ?? null,
        $_POST["ativo"],
        $_POST["lote"]
    );

    if (empty($_POST["idvacina"])) {
        $resultado = $vdao->create($v);
        $_SESSION["mensagem"] = $resultado ? "Vacina cadastrada com sucesso!" : "Erro ao cadastrar vacina.";
    } else {
        $resultado = $vdao->update($v);
        $_SESSION["mensagem"] = $resultado ? "Vacina atualizada com sucesso!" : "Erro ao alterar vacina.";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciavacina.php");
    exit();
}
?>