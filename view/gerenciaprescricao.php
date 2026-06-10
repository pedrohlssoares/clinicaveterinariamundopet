<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/prescricao.php";
include_once $base . "entity/dao/prescricaodao.php";
include_once $base . "entity/model/consulta.php";
include_once $base . "entity/dao/consultadao.php";
include_once $base . "entity/model/remedio.php";
include_once $base . "entity/dao/remediodao.php";
include_once $base . "entity/model/vacina.php";
include_once $base . "entity/dao/vacinadao.php";
include_once $base . "entity/model/pet.php";
include_once $base . "entity/dao/petdao.php";

include __DIR__ . "/topo.html";

$prdao = new prescricaodao();
$cdao = new consultadao();
$rdao = new remediodao();
$vdao = new vacinadao();
$petdao = new petdao();

if (isset($_SESSION["resultado"])) {
    $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
    echo "<div class='container mt-3'><div class='alert {$classe} shadow-sm'>{$_SESSION["mensagem"]}</div></div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-dark);">Gerenciar Prescrições</h2>
        <a href="cadastroprescricao.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i>Nova Prescrição
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th>Data/Pet da Consulta</th>
                    <th>Remédio Prescrito</th>
                    <th>Vacina Aplicada</th>
                    <th>Dosagem / Uso</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lista = $prdao->read();
                
                if (is_null($lista) || empty($lista)) {
                    echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Nenhuma prescrição cadastrada.</td></tr>";
                } else {
                    foreach ($lista as $item) {
                        $id = is_object($item) ? $item->idprescricao : $item["idprescricao"];
                        $consultafk = is_object($item) ? $item->consultaprescricaofk : $item["consultaprescricaofk"];
                        $remediofk = is_object($item) ? $item->remedioprescricaofk : $item["remedioprescricaofk"];
                        $vacinafk = is_object($item) ? $item->vacinaprescricaofk : $item["vacinaprescricaofk"];
                        $dosagem = is_object($item) ? $item->dosagem : $item["dosagem"];

                        // Busca dados da consulta e do pet
                        $cons_obj = $cdao->readId($consultafk);
                        $info_consulta = "Consulta Desconhecida";
                        if ($cons_obj) {
                            $data_bruta = is_object($cons_obj) ? (isset($cons_obj->data_consulta) ? $cons_obj->data_consulta : (isset($cons_obj->data) ? $cons_obj->data : "")) : ($cons_obj["data_consulta"] ?? $cons_obj["data"]);
                            $petfk = is_object($cons_obj) ? $cons_obj->petconsultafk : $cons_obj["petconsultafk"];
                            $pet = $petdao->readId($petfk);
                            $nomePet = $pet ? (is_object($pet) ? $pet->nome : $pet["nome"]) : "Pet";
                            $info_consulta = (!empty($data_bruta) ? date('d/m/Y', strtotime($data_bruta)) : "Data N/D") . " - " . $nomePet;
                        }

                        // Busca dados do remedio
                        $rem_obj = $remediofk ? $rdao->readId($remediofk) : null;
                        $nome_remedio = $rem_obj ? (is_object($rem_obj) ? $rem_obj->ativo : $rem_obj["ativo"]) : "---";

                        // Busca dados da vacina
                        $vac_obj = $vacinafk ? $vdao->readId($vacinafk) : null;
                        $nome_vacina = $vac_obj ? (is_object($vac_obj) ? $vac_obj->ativo : $vac_obj["ativo"]) : "---";

                        echo "<tr>";
                        echo "<td class='fw-bold text-primary'>{$info_consulta}</td>";
                        echo "<td>{$nome_remedio}</td>";
                        echo "<td>{$nome_vacina}</td>";
                        echo "<td>{$dosagem}</td>";
                        echo "<td class='text-center'>";
                        echo "<a href='editarprescricao.php?idprescricao={$id}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                        echo "<a href='../controller/prescricaocontroller.php?idprescricao={$id}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Tem a certeza que deseja excluir esta prescrição?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>