<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/historico_vacinacao.php";
include_once $base . "entity/dao/historico_vacinacaodao.php";
include_once $base . "entity/model/pet.php";
include_once $base . "entity/dao/petdao.php";
include_once $base . "entity/model/vacina.php";
include_once $base . "entity/dao/vacinadao.php";

include __DIR__ . "/topo.html";

$hvdao = new historico_vacinacaoDao();
$petdao = new petdao();
$vactdao = new vacinadao();

if (isset($_SESSION["resultado"])) {
    $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
    echo "<div class='container mt-3'><div class='alert {$classe} shadow-sm'>{$_SESSION["mensagem"]}</div></div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-dark);">Histórico de Vacinação</h2>
        <a href="cadastrohistorico_vacinacao.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> + Registrar Vacinação
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th>Pet (Paciente)</th>
                    <th>Vacina Aplicada</th>
                    <th>Data de Aplicação</th>
                    <th>Dosagem</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lista = $hvdao->read();
                
                if (is_null($lista) || empty($lista)) {
                    echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Nenhum registro de vacinação encontrado.</td></tr>";
                } else {
                    foreach ($lista as $item) {
                        $id = is_object($item) ? $item->idhistorico : $item["idhistorico"];
                        $petfk = is_object($item) ? $item->pethistorico_vacinacaofk : $item["pethistorico_vacinacaofk"];
                        $vacinafk = is_object($item) ? $item->vacinahistorico_vacinacaofk : $item["vacinahistorico_vacinacaofk"];
                        $data = is_object($item) ? $item->data_aplicacao : $item["data_aplicacao"];
                        $dosagem = is_object($item) ? $item->dosagem : $item["dosagem"];

                        $pet_obj = $petdao->readId($petfk);
                        $nome_pet = $pet_obj ? (is_object($pet_obj) ? $pet_obj->nome : $pet_obj["nome"]) : "Desconhecido";

                        $vac_obj = $vactdao->readId($vacinafk);
                        $nome_vacina = $vac_obj ? (is_object($vac_obj) ? $vac_obj->ativo : $vac_obj["ativo"]) : "Desconhecida";

                        $dataFormatada = !empty($data) ? date("d/m/Y", strtotime($data)) : "---";

                        echo "<tr>";
                        echo "<td class='fw-bold text-primary'>{$nome_pet}</td>";
                        echo "<td><span class='badge bg-info text-dark border'>{$nome_vacina}</span></td>";
                        echo "<td>{$dataFormatada}</td>";
                        echo "<td>{$dosagem}</td>";
                        echo "<td class='text-center'>";
                        echo "<a href='editarhistorico_vacinacao.php?idhistorico={$id}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                        echo "<a href='../controller/historico_vacinacaocontroller.php?idhistorico={$id}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Tem a certeza que deseja excluir este registro de vacinação?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
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