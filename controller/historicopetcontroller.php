<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";
include_once $base . "entity/model/pet.php";
include_once $base . "entity/dao/petdao.php";

if (isset($_POST["btBuscarPet"])) {
    $termoBusca = trim($_POST["termo_busca"]);
    
    if (empty($termoBusca)) {
        $_SESSION["mensagem"] = "Por favor, digite o nome ou ID do Pet.";
        $_SESSION["resultado"] = false;
        header("location:../view/consultar_historico.php");
        exit();
    }

    $pdo = conexao::conectar();
    try {
        if (is_numeric($termoBusca)) {
            $sql = "SELECT idpet FROM pet WHERE idpet = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$termoBusca]);
        } else {
            $sql = "SELECT idpet FROM pet WHERE nome LIKE ? LIMIT 1";
            $query = $pdo->prepare($sql);
            $query->execute(["%{$termoBusca}%"]);
        }
        
        $pet = $query->fetch(PDO::FETCH_ASSOC);
        conexao::desconectar();

        if ($pet) {
            header("location:../view/painel_pet.php?idpet=" . $pet["idpet"]);
            exit();
        } else {
            $_SESSION["mensagem"] = "Nenhum Pet foi encontrado com o termo: '{$termoBusca}'.";
            $_SESSION["resultado"] = false;
            header("location:../view/consultar_historico.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION["mensagem"] = "Erro na busca: " . $e->getMessage();
        $_SESSION["resultado"] = false;
        header("location:../view/consultar_historico.php");
        exit();
    }
}
?>