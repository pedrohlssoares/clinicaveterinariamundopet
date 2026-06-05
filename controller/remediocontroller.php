<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";
include_once $base . "model/entity/remedio.php";
include_once $base . "model/dao/remediodao.php";

$rdao = new remediodao();

if (isset($_GET["idremedio"])) {
    $resultado = $rdao->delete($_GET["idremedio"]);
    $_SESSION["mensagem"] = $resultado ? "Excluído com sucesso!" : "Erro ao excluir o remédio. Verifique possíveis vínculos com prescrições médicas.";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciaremedio.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $r = new remedio(
        $_POST["idremedio"],
        $_POST["produtoremediofk"] ?? null,
        $_POST["ativo"],
        $_POST["lote"]
    );

    if (empty($_POST["idremedio"])) {
        $resultado = $rdao->create($r);
        $_SESSION["mensagem"] = $resultado ? "Cadastrado com sucesso!" : "Erro ao cadastrar remédio.";
    } else {
        $resultado = $rdao->update($r);
        $_SESSION["mensagem"] = $resultado ? "Alterado com sucesso!" : "Erro ao alterar remédio.";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciaremedio.php");
    exit();
}
?>
