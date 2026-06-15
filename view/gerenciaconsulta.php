<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";

include_once $base ."entity/model/consulta.php";
include_once $base ."entity/dao/consultadao.php";
include_once $base ."entity/model/pet.php";
include_once $base ."entity/dao/petdao.php";
include_once $base ."entity/model/veterinario.php";
include_once $base ."entity/dao/veterinariodao.php";
include_once $base ."entity/model/sala.php";
include_once $base ."entity/dao/saladao.php";

include __DIR__ . "/topo.html";

$codao = new consultadao();
$petdao = new petdao();
$vetdao = new veterinariodao();
$saladao = new saladao();

if (isset($_SESSION["resultado"])) {
    $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
    echo "<div class='container mt-3'><div class='alert {$classe} shadow-sm'>{$_SESSION["mensagem"]}</div></div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-dark);">Gerenciar Agenda de Consultas</h2>
        <a href="cadastroconsulta.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-calendar-plus"></i> Novo Agendamento
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Paciente (Pet)</th>
                    <th>Veterinário (CRMV)</th>
                    <th>Status Rápido</th>
                    <th>Sala</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lista = isset($_SESSION["consultas_filtradas"]) ? $_SESSION["consultas_filtradas"] : $codao->read();
                unset($_SESSION["consultas_filtradas"]);
                
                if (is_null($lista) || empty($lista)) {
                    echo "<tr><td colspan='7' class='text-center py-4 text-muted'>Nenhuma consulta agendada.</td></tr>";
                } else {
                    foreach ($lista as $item) {
                        $idconsulta = is_object($item) ? $item->idconsulta : $item["idconsulta"];
                        $fk_pet = is_object($item) ? $item->petconsultafk : $item["petconsultafk"];
                        $fk_vet = is_object($item) ? $item->veterinarioconsultafk : $item["veterinarioconsultafk"];
                        $fk_sala = is_object($item) ? $item->salaconsultafk : $item["salaconsultafk"];
                        
                        $data_bruta = is_object($item) ? $item->data_consulta : $item["data_consulta"];
                        $horario = is_object($item) ? $item->horario : $item["horario"];
                        $status = is_object($item) ? $item->status : $item["status"];

                        $dataFormatada = !empty($data_bruta) ? date("d/m/Y", strtotime($data_bruta)) : "Data Indefinida";

                        $pet_obj = method_exists($petdao, 'readID') ? $petdao->readID($fk_pet) : $petdao->readId($fk_pet);
                        $nome_pet = $pet_obj ? (is_object($pet_obj) ? $pet_obj->nome : $pet_obj["nome"]) : "Desconhecido";

                        $vet_obj = method_exists($vetdao, 'readID') ? $vetdao->readID($fk_vet) : $vetdao->readId($fk_vet);
                        $crmv_vet = $vet_obj ? (is_object($vet_obj) ? $vet_obj->crmv : $vet_obj["crmv"]) : "N/D";

                        $sala_obj = method_exists($saladao, 'readID') ? $saladao->readID($fk_sala) : $saladao->readId($fk_sala);
                        $num_sala = $sala_obj ? (is_object($sala_obj) ? $sala_obj->numero : $sala_obj["numero"]) : "N/D";

                        $badge_status = 'btn-secondary';
                        if ($status == 'Agendada') $badge_status = 'btn-warning';
                        if ($status == 'Realizada') $badge_status = 'btn-success';
                        if ($status == 'Cancelada') $badge_status = 'btn-danger';

                        echo "<tr>";
                        echo "<td class='fw-bold'>{$dataFormatada}</td>";
                        echo "<td><span class='text-primary fw-bold'>{$horario}</span></td>";
                        echo "<td>{$nome_pet}</td>";
                        echo "<td>CRMV: {$crmv_vet}</td>";
                        
                        echo "<td>";
                        echo "<div class='dropdown'>";
                        echo "<button class='btn btn-sm {$badge_status} dropdown-toggle border-0 text-dark fw-semibold' type='button' data-bs-toggle='dropdown' aria-expanded='false'>{$status}</button>";
                        echo "<ul class='dropdown-menu shadow-sm'>";
                        echo "<li><a class='dropdown-item' href='../controller/consultacontroller.php?idconsulta={$idconsulta}&novo_status=Agendada'><i class='bi bi-clock-history text-warning me-2'></i>Agendada</a></li>";
                        echo "<li><a class='dropdown-item' href='../controller/consultacontroller.php?idconsulta={$idconsulta}&novo_status=Realizada'><i class='bi bi-check-circle-fill text-success me-2'></i>Realizada</a></li>";
                        echo "<li><a class='dropdown-item' href='../controller/consultacontroller.php?idconsulta={$idconsulta}&novo_status=Cancelada'><i class='bi bi-x-circle-fill text-danger me-2'></i>Cancelada</a></li>";
                        echo "</ul>";
                        echo "</div>";
                        echo "</td>";

                        echo "<td><span class='badge bg-light text-dark border'>Sala {$num_sala}</span></td>";
                        echo "<td class='text-center'>";
                        
                        echo "<a href='editarconsulta.php?idconsulta={$idconsulta}' class='btn btn-sm btn-outline-primary' title='Editar Consulta Completa'><img src='img/alterar.png' width='16'> Editar</a>";
                        
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