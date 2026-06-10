<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";
include_once $base . "entity/model/forma_pagamento.php";
include_once $base . "entity/dao/forma_pagamentodao.php";

$fpdao = new forma_pagamentoDao();

// Rota de Exclusão
if (isset($_GET["idforma_pagamento"])) {
    $resultado = $fpdao->delete($_GET["idforma_pagamento"]);
    $_SESSION["mensagem"] = $resultado ? "Forma de pagamento excluída com sucesso!" : "Erro ao excluir a forma de pagamento.";
    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciaforma_pagamento.php");
    exit();
}

// Rota de Inserção / Atualização
if (isset($_POST["btGravar"])) {
    $fp = new forma_pagamento(
        $_POST["idforma_pagamento"],
        $_POST["tipo"],
        $_POST["descricao"]
    );

    if (empty($_POST["idforma_pagamento"])) {
        $resultado = $fpdao->create($fp);
        $_SESSION["mensagem"] = $resultado ? "Forma de pagamento cadastrada com sucesso!" : "Erro ao cadastrar forma de pagamento.";
    } else {
        $resultado = $fpdao->update($fp);
        $_SESSION["mensagem"] = $resultado ? "Forma de pagamento atualizada com sucesso!" : "Erro ao atualizar forma de pagamento.";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciaforma_pagamento.php");
    exit();
}
?>