<?php
session_start();
$base = __DIR__ . '/../'; 

include_once $base . "config/conexao.php";
include_once $base . "model/entity/cliente.php";
include_once $base . "model/dao/clientedao.php";
include_once $base . "model/entity/endereco.php";
include_once $base . "model/dao/enderecodao.php";

$cdao = new clienteDao();
$edao = new enderecoDao();

if (isset($_GET["idcliente"])) {
    $resultado = $cdao->delete($_GET["idcliente"]);
    $_SESSION["mensagem"] = $resultado ? "Excluído com sucesso!" : "Erro ao excluir. O cliente possui vínculos (Pets/Consultas).";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciacliente.php");
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

    $cli = new cliente(
        $_POST["idcliente"],
        $_POST["nome"],
        $_POST["cpf"],
        $_POST["email"],
        $_POST["celular"],
        $idEnderecoGerado
    );

    if (empty($_POST["idcliente"])) {
        $resultado = $cdao->create($cli);
        $_SESSION["mensagem"] = $resultado ? "Cliente cadastrado com sucesso!" : "Erro ao cadastrar cliente.";
    } else {
        $resultado = $cdao->update($cli);
        $_SESSION["mensagem"] = $resultado ? "Cliente atualizado com sucesso!" : "Erro ao atualizar cliente.";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciacliente.php"); 
    exit();
}
?>
