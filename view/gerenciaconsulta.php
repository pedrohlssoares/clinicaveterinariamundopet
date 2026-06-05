<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "model/entity/consulta.php";
include_once $base . "model/dao/consultadao.php";
include_once $base . "model/entity/pet.php";
include_once $base . "model/dao/petdao.php";
include_once $base . "model/entity/veterinario.php";
include_once $base . "model/dao/veterinariodao.php";
include_once $base . "model/entity/sala.php";
include_once $base . "model/dao/saladao.php";

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
                    <th>Sala</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Se houver um filtro na sessão (definido no controller), usamos ele, se não lemos todas
                $lista = isset($_SESSION["consultas_filtradas"]) ? $_SESSION["consultas_filtradas"] : $codao->read();
                // Limpa o filtro após exibir
                unset($_SESSION["consultas_filtradas"]);
                
                if (is_null($lista) || empty($lista)) {
                    echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Nenhuma consulta agendada.</td></tr>";
                } else {
                    foreach ($lista as $item) {
                        // Tolerância a Array ou Objeto da tabela de Consulta
                        $idconsulta = is_object($item) ? $item->idconsulta : $item["idconsulta"];
                        $fk_pet = is_object($item) ? $item->petconsultafk : $item["petconsultafk"];
                        $fk_vet = is_object($item) ? $item->veterinarioconsultafk : $item["veterinarioconsultafk"];
                        $fk_sala = is_object($item) ? $item->salaconsultafk : $item["salaconsultafk"];
                        
                        // Lida com nome da coluna (data ou data_consulta)
                        $data_bruta = is_object($item) ? (isset($item->data_consulta) ? $item->data_consulta : (isset($item->data) ? $item->data : "")) : ($item["data_consulta"] ?? $item["data"]);
                        $horario = is_object($item) ? $item->horario : $item["horario"];

                        $dataFormatada = !empty($data_bruta) ? date("d/m/Y", strtotime($data_bruta)) : "Data Indefinida";

                        // Buscas seguras pelo ID para pegar os nomes reais sem depender de JOIN no DAO
                        $pet_obj = $petdao->readId($fk_pet);
                        $nome_pet = $pet_obj ? (is_object($pet_obj) ? $pet_obj->nome : $pet_obj["nome"]) : "Desconhecido";

                        $vet_obj = $vetdao->readId($fk_vet);
                        $crmv_vet = $vet_obj ? (is_object($vet_obj) ? $vet_obj->crmv : $vet_obj["crmv"]) : "N/D";

                        $sala_obj = $saladao->readId($fk_sala);
                        $num_sala = $sala_obj ? (is_object($sala_obj) ? $sala_obj->numero : $sala_obj["numero"]) : "N/D";

                        echo "<tr>";
                        echo "<td class='fw-bold'>{$dataFormatada}</td>";
                        echo "<td><span class='text-primary fw-bold'>{$horario}</span></td>";
                        echo "<td>{$nome_pet}</td>";
                        echo "<td>CRMV: {$crmv_vet}</td>";
                        echo "<td><span class='badge bg-light text-dark border'>Sala {$num_sala}</span></td>";
                        echo "<td class='text-center'>";
                        echo "<a href='editarconsulta.php?idconsulta={$idconsulta}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                        // SINTAXE DE ASPAS CORRIGIDA
                        echo "<a href='../controller/consultacontroller.php?idconsulta={$idconsulta}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Deseja cancelar/excluir este agendamento?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
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
