<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";

include_once $base . "entity/model/despesa.php";
include_once $base . "entity/dao/despesadao.php";

include __DIR__ . "/topo.html";

$ddao = new despesaDao();

if (isset($_SESSION["resultado"])) {
    $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
    echo "<div class='container mt-3'><div class='alert {$classe} shadow-sm'>{$_SESSION["mensagem"]}</div></div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-dark);"><i class="bi bi-wallet2 text-danger"></i> Gerenciar Despesas (Saídas)</h2>
        <a href="cadastrodespesa.php" class="btn btn-danger shadow-sm">
            <i class="bi bi-plus-lg"></i>Lançar Despesa
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th>Código</th>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lista = $ddao->read();
                
                if (is_null($lista) || empty($lista)) {
                    echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Nenhuma despesa registrada.</td></tr>";
                } else {
                    $totalDespesas = 0;
                    foreach ($lista as $item) {
                        $id = is_object($item) ? $item->iddespesa : $item["iddespesa"];
                        $descricao = is_object($item) ? $item->descricao : $item["descricao"];
                        $preco = is_object($item) ? $item->preco : $item["preco"];
                        $data = is_object($item) ? $item->despesadata : $item["despesadata"];

                        $totalDespesas += $preco;
                        $dataFormatada = !empty($data) ? date("d/m/Y", strtotime($data)) : "---";

                        echo "<tr>";
                        echo "<td><span class='badge bg-light text-dark border'>#{$id}</span></td>";
                        echo "<td><span class='text-secondary'>{$dataFormatada}</span></td>";
                        echo "<td class='fw-bold'>{$descricao}</td>";
                        echo "<td class='fw-bold text-danger'>R$ " . number_format($preco, 2, ',', '.') . "</td>";
                        echo "<td class='text-center'>";
                        // REMOVIDO: Botão de alteração/edição para cumprir a regra de negócio de auditoria financeira
                        echo "<a href='../controller/despesacontroller.php?iddespesa={$id}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Tem a certeza que deseja excluir esta despesa permanentemente?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    // Linha de Totalizador de Saídas
                    echo "<tr class='table-light border-top border-2 border-danger'>";
                    echo "<td colspan='3' class='text-end fw-bold text-dark fs-5'>TOTAL DE SAÍDAS:</td>";
                    echo "<td colspan='2' class='fw-bold text-danger fs-5'>R$ " . number_format($totalDespesas, 2, ',', '.') . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>