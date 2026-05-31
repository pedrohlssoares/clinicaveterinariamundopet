<?php
session_start();

// CORREÇÃO DE CAMINHO: Como este arquivo está em /controller, 
// voltamos apenas UM nível para chegar na raiz do projeto.
$base = __DIR__ . '/../'; 

include_once $base . "config/conexao.php";
include_once $base . "model/entity/cliente.php";
include_once $base . "model/dao/clientedao.php";
include_once $base . "model/entity/endereco.php";
include_once $base . "model/dao/enderecodao.php";

$cdao = new clientedao();
$edao = new enderecodao();

// AÇÃO DE EXCLUIR (via GET)
if (isset($_GET["idcliente"])) {
    $resultado = $cdao->delete($_GET["idcliente"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/index.php");
    exit();
}

// AÇÃO DE GRAVAR (via POST)
if (isset($_POST["btGravar"])) {
    
    // 1. Grava o Endereço primeiro
    $end = new endereco(
        $_POST["idendereco"],
        $_POST["rua"],
        $_POST["cidade"],
        $_POST["bairro"],
        $_POST["numero"],
        $_POST["complemento"]
    );

    if ($_POST["idendereco"] == "") {
        // O seu enderecodao->create deve retornar o lastInsertId()
        $idEnderecoGerado = $edao->create($end); 
    } else {
        $edao->update($end);
        $idEnderecoGerado = $_POST["idendereco"];
    }

    // 2. Grava o Cliente usando o ID do endereço
    $cli = new cliente(
        $_POST["idcliente"],
        $_POST["nome"],
        $_POST["cpf"],
        $_POST["email"],
        $_POST["celular"],
        $idEnderecoGerado
    );

    if ($_POST["idcliente"] == "") {
        $resultado = $cdao->create($cli);
        $_SESSION["mensagem"] = "Cadastro realizado com sucesso!";
    } else {
        $resultado = $cdao->update($cli);
        $_SESSION["mensagem"] = "Alteração realizada com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    
    // CORREÇÃO DE REDIRECIONAMENTO: Volta para a view correta
    header("location:../view/index.php"); 
    exit();
}