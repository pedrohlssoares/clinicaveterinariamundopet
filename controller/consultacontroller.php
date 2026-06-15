<?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";


include_once $base . "entity/model/consulta.php";
include_once $base . "entity/dao/consultadao.php";


$codao = new consultadao();

if (isset($_GET["txtDataFiltro"])) {
    $resultado = $codao->readPorData($_GET["txtDataFiltro"]);
    $_SESSION["consultas_filtradas"] = $resultado;
    header("location:../view/gerenciaconsulta.php");
    exit();
}

if (isset($_GET["idconsulta"])) {
    if (isset($_GET["novo_status"])) {
        $consulta_obj = method_exists($codao, 'readID') ? $codao->readID($_GET["idconsulta"]) : $codao->readId($_GET["idconsulta"]);
        if ($consulta_obj) {
            $consulta_obj->status = $_GET["novo_status"];
            $resultado = $codao->update($consulta_obj);
            $_SESSION["mensagem"] = $resultado ? "Status da consulta alterado para '{$_GET["novo_status"]}' com sucesso!" : "Erro ao alterar o status.";
            $_SESSION["resultado"] = $resultado;
        }
    } else {
        $_SESSION["mensagem"] = "Acesso Negado: Não é permitida a exclusão de prontuários e consultas no sistema por motivos de auditoria clínica.";
        $_SESSION["resultado"] = false;
    }
    header("location:../view/gerenciaconsulta.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    
    $status_consulta = isset($_POST["status"]) && !empty($_POST["status"]) ? $_POST["status"] : 'Agendada';
    
    $co = new consulta(
        $_POST["idconsulta"],
        $_POST["petconsultafk"],
        $_POST["veterinarioconsultafk"] ?? null,
        $_POST["salaconsultafk"] ?? null,
        $_POST["data_consulta"],
        $_POST["horario"], 
        $status_consulta,
        $_POST["processos_feitos"] ?? null
    );

    if (empty($_POST["idconsulta"])) {
        $resultado = $codao->create($co);
        $_SESSION["mensagem"] = $resultado ? "Agendamento realizado com sucesso!" : "Erro ao agendar consulta.";
    } else {
        $resultado = $codao->update($co);
        $_SESSION["mensagem"] = $resultado ? "Consulta atualizada com sucesso!" : "Erro ao alterar consulta.";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciaconsulta.php");
    exit();
}
?><?php
session_start();
$base = __DIR__ . '/../';

include_once $base . "config/conexao.php";


include_once $base . "entity/model/consulta.php";
include_once $base . "entity/dao/consultadao.php";


$codao = new consultadao();

if (isset($_GET["txtDataFiltro"])) {
    $resultado = $codao->readPorData($_GET["txtDataFiltro"]);
    $_SESSION["consultas_filtradas"] = $resultado;
    header("location:../view/gerenciaconsulta.php");
    exit();
}

if (isset($_GET["idconsulta"])) {
    if (isset($_GET["novo_status"])) {
        $consulta_obj = method_exists($codao, 'readID') ? $codao->readID($_GET["idconsulta"]) : $codao->readId($_GET["idconsulta"]);
        if ($consulta_obj) {
            $consulta_obj->status = $_GET["novo_status"];
            $resultado = $codao->update($consulta_obj);
            $_SESSION["mensagem"] = $resultado ? "Status da consulta alterado para '{$_GET["novo_status"]}' com sucesso!" : "Erro ao alterar o status.";
            $_SESSION["resultado"] = $resultado;
        }
    } else {
        $_SESSION["mensagem"] = "Acesso Negado: Não é permitida a exclusão de prontuários e consultas no sistema por motivos de auditoria clínica.";
        $_SESSION["resultado"] = false;
    }
    header("location:../view/gerenciaconsulta.php");
    exit();
}

if (isset($_POST["btGravar"])) {
    
    $status_consulta = isset($_POST["status"]) && !empty($_POST["status"]) ? $_POST["status"] : 'Agendada';
    
    $co = new consulta(
        $_POST["idconsulta"],
        $_POST["petconsultafk"],
        $_POST["veterinarioconsultafk"] ?? null,
        $_POST["salaconsultafk"] ?? null,
        $_POST["data_consulta"],
        $_POST["horario"], 
        $status_consulta,
        $_POST["processos_feitos"] ?? null
    );

    if (empty($_POST["idconsulta"])) {
        $resultado = $codao->create($co);
        $_SESSION["mensagem"] = $resultado ? "Agendamento realizado com sucesso!" : "Erro ao agendar consulta.";
    } else {
        $resultado = $codao->update($co);
        $_SESSION["mensagem"] = $resultado ? "Consulta atualizada com sucesso!" : "Erro ao alterar consulta.";
    }

    $_SESSION["resultado"] = $resultado;
    header("location:../view/gerenciaconsulta.php");
    exit();
}
?>
