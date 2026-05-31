<?php
session_start();

$base = __DIR__ . '/../'; 

include_once $base . "config/conexao.php";
include_once $base . "model/entity/funcionario.php";
include_once $base . "model/dao/funcionariodao.php";
include_once $base . "model/entity/endereco.php";
include_once $base . "model/dao/enderecodao.php";

$fdao = new funcionariodao();
$edao = new enderecodao();

if (isset($_GET["idfuncionario"])) {
    $resultado = $fdao->delete($_GET["idfuncionario"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/index.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    
    $end = new endereco(
        $_POST["idendereco"],
        $_POST["rua"],
        $_POST["cidade"],
        $_POST["bairro"],
        $_POST["numero"],
        $_POST["complemento"]
    );

    if ($_POST["idendereco"] == "") {
        $idEnderecoGerado = $edao->create($end); 
    } else {
        $edao->update($end);
        $idEnderecoGerado = $_POST["idendereco"];
    }

    $func = new funcionario(
        $_POST["idfuncionario"],
        $_POST["nome"],
        $_POST["celular"],
        $_POST["cpf"],
        $_POST["salario"],
        $idEnderecoGerado 
    );

    if ($_POST["idfuncionario"] == "") {
        $resultado = $fdao->create($func);
        $_SESSION["mensagem"] = "Cadastro realizado com sucesso!";
    } else {
        $resultado = $fdao->update($func);
        $_SESSION["mensagem"] = "Alteração realizada com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    
    header("location:../view/index.php"); 
    exit();
}
?>
