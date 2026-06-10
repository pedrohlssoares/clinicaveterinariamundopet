<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";


include_once $base . "entity/model/despesa.php";
include_once $base . "entity/dao/despesadao.php";


$ddao = new despesaDao();

// Rota de Exclusão
if (isset($_GET["iddespesa"])) {
    $resultado = $ddao->delete($_GET["iddespesa"]);
    $_SESSION["mensagem"] = $resultado ? "Despesa excluída com sucesso!" : "Erro ao excluir a despesa.";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciadespesa.php");
    exit();
}

// Rota de Inserção Única (Regra de Negócio: Bloqueado alterações pós-registro)
if (isset($_POST["btGravar"])) {
    if (!empty($_POST["iddespesa"])) {
        $_SESSION["mensagem"] = "Erro: Uma despesa lançada não pode ser alterada.";
        $_SESSION["resultado"] = false;
        header("location:../view/gerenciadespesa.php");
        exit();
    }

    $preco = str_replace(',', '.', $_POST["preco"]);
    $preco = floatval($preco);

    $d = new despesa(
        null, // ID nulo para auto_increment no banco
        $preco,
        $_POST["despesadata"],
        $_POST["descricao"]
    );

    $resultado = $ddao->create($d);
    $_SESSION["mensagem"] = $resultado ? "Despesa registrada com sucesso!" : "Erro ao registrar a despesa.";
    $_SESSION["resultado"] = $resultado;
    
    header("location:../view/gerenciadespesa.php");
    exit();
}
?>