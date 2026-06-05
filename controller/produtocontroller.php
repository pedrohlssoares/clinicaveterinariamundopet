<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";
include_once $base . "model/entity/produto.php";
include_once $base . "model/dao/produtodao.php";

$prodao = new produtodao();

if (isset($_GET["idproduto"])) {
    $resultado = $prodao->delete($_GET["idproduto"]);
    $_SESSION["mensagem"] = $resultado ? "Produto excluído com sucesso!" : "Erro ao excluir o produto. Verifique se ele não está vinculado a uma vacina ou venda.";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciaproduto.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    $pro = new produto(
        $_POST["idproduto"],
        $_POST["nome"],
        $_POST["quantidade"],
        $_POST["descricao"],
        $_POST["preco"]
    );

    if (empty($_POST["idproduto"])) {
        $resultado = $prodao->create($pro);
        $_SESSION["mensagem"] = $resultado ? "Produto cadastrado com sucesso!" : "Erro ao cadastrar produto.";
    } else {
        $resultado = $prodao->update($pro);
        $_SESSION["mensagem"] = $resultado ? "Produto atualizado com sucesso!" : "Erro ao alterar produto.";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciaproduto.php");
    exit();
}
?>
