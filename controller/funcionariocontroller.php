<?php
session_start();

// Caminho relativo correto: volta um nível para sair de /controller e chegar na raiz
$base = __DIR__ . '/../'; 

include_once $base . "config/conexao.php";
include_once $base . "model/entity/funcionario.php";
include_once $base . "model/dao/funcionariodao.php";
include_once $base . "model/entity/endereco.php";
include_once $base . "model/dao/enderecodao.php";

$fdao = new funcionariodao();
$edao = new enderecodao();

// AÇÃO DE EXCLUIR (via GET)
if (isset($_GET["idfuncionario"])) {
    $resultado = $fdao->delete($_GET["idfuncionario"]);
    $_SESSION["mensagem"] = "Excluído com sucesso!";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/index.php");
    exit();
}

// AÇÃO DE GRAVAR (via POST)
if (isset($_POST["btGravar"])) {
    
    // 1. Instancia o objeto Endereço com os dados do formulário
    $end = new endereco(
        $_POST["idendereco"],
        $_POST["rua"],
        $_POST["cidade"],
        $_POST["bairro"],
        $_POST["numero"],
        $_POST["complemento"]
    );

    // Se for um novo cadastro, cria o endereço e pega o ID gerado
    if ($_POST["idendereco"] == "") {
        // Lembrete: o método create do seu enderecodao deve retornar $pdo->lastInsertId();
        $idEnderecoGerado = $edao->create($end); 
    } else {
        // Se for edição, apenas atualiza o endereço existente e mantém o ID que veio do POST
        $edao->update($end);
        $idEnderecoGerado = $_POST["idendereco"];
    }

    // 2. Instancia o objeto Funcionário usando o ID do endereço obtido acima
    $func = new funcionario(
        $_POST["idfuncionario"],
        $_POST["nome"],
        $_POST["celular"],
        $_POST["cpf"],
        $_POST["salario"],
        $idEnderecoGerado // Vincula a FK gerada ou existente
    );

    // Salva ou atualiza o funcionário no banco
    if ($_POST["idfuncionario"] == "") {
        $resultado = $fdao->create($func);
        $_SESSION["mensagem"] = "Cadastro realizado com sucesso!";
    } else {
        $resultado = $fdao->update($func);
        $_SESSION["mensagem"] = "Alteração realizada com sucesso!";
    }

    $_SESSION["resultado"] = $resultado;
    
    // Redireciona para a view correta dentro da estrutura de pastas
    header("location:../view/index.php"); 
    exit();
}
?>