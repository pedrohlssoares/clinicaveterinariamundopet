<?php
session_start();

$base = __DIR__ . '/../'; 

include_once $base . "config/conexao.php";
include_once $base . "entity/model/funcionario.php";
include_once $base . "entity/dao/funcionariodao.php";
include_once $base . "entity/model/endereco.php";
include_once $base . "entity/dao/enderecodao.php";

$fdao = new funcionarioDao();
$edao = new enderecoDao();

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

    if (empty($_POST["idendereco"])) {
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

    if (empty($_POST["idfuncionario"])) {
        $resultado = $fdao->create($func);
        $_SESSION["mensagem"] = $resultado ? "Funcionário cadastrado com sucesso!" : "Erro ao cadastrar funcionário.";
    } else {
        $resultado = $fdao->update($func);
        $_SESSION["mensagem"] = $resultado ? "Funcionário atualizado com sucesso!" : "Erro ao atualizar funcionário.";
    }
    
    header("location:../view/index.php"); 
    exit();
}
?>
