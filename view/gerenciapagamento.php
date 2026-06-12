<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/pagamento.php";
include_once $base . "entity/dao/pagamentodao.php";
include_once $base . "entity/model/cliente.php";
include_once $base . "entity/dao/clientedao.php";
include_once $base . "entity/model/forma_pagamento.php";
include_once $base . "entity/dao/forma_pagamentodao.php";

include __DIR__ . "/topo.html";

$pdao = new pagamentoDao();
$clientedao = new clienteDao();
$fpdao = new forma_pagamentoDao();

if (isset($_SESSION["resultado"])) {
    $classe = $_SESSION["resultado"] ? "alert-success" : "alert-danger";
    echo "<div class='container mt-3'><div class='alert {$classe} shadow-sm'>{$_SESSION["mensagem"]}</div></div>";
    $_SESSION["resultado"] = null;
    $_SESSION["mensagem"] = null;
}
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-dark);"><i class="bi bi-cash-coin text-success"></i> Fluxo de Faturamento Clínico</h2>
        <a href="cadastropagamento.php" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-lg"></i>Novo Lançamento
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="custom-thead text-white">
                <tr>
                    <th>Data Faturamento</th>
                    <th>Responsável (Tutor)</th>
                    <th>Forma de Entrada</th>
                    <th>Parcelas</th>
                    <th>Vínculos Extra</th>
                    <th>Valor Total</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lista = $pdao->read();
                
                if (is_null($lista) || empty($lista)) {
                    echo "<tr><td colspan='7' class='text-center py-4 text-muted'>Nenhum lançamento registrado no fluxo de caixa.</td></tr>";
                } else {
                    foreach ($lista as $item) {
                        $id = is_object($item) ? $item->idpagamento : $item["idpagamento"];
                        $prestacoes = is_object($item) ? $item->prestacoes : $item["prestacoes"];
                        $valor = is_object($item) ? $item->valor : $item["valor"];
                        $data = is_object($item) ? $item->data_pagamento : $item["data_pagamento"];
                        $formafk = is_object($item) ? $item->formapagamentofk : $item["formapagamentofk"];
                        $clientefk = is_object($item) ? $item->clientepagamentofk : $item["clientepagamentofk"];
                        $consultafk = is_object($item) ? $item->consultapagamentofk : $item["consultapagamentofk"];
                        $prescricaofk = is_object($item) ? $item->prescricaopagamentofk : $item["prescricaopagamentofk"];
                        $vendafk = is_object($item) ? $item->vendapagamentofk : $item["vendapagamentofk"];

                        $cli_obj = $clientedao->readId($clientefk);
                        $nome_cliente = $cli_obj ? (is_object($cli_obj) ? $cli_obj->nome : $cli_obj["nome"]) : "Desconhecido";

                        $fp_obj = $fpdao->readId($formafk);
                        $nome_forma = $fp_obj ? (is_object($fp_obj) ? $fp_obj->tipo : $fp_obj["tipo"]) : "Outros";

                        $dataFormatada = !empty($data) ? date("d/m/Y H:i", strtotime($data)) : "---";
                        
                        $vinculos = [];
                        if(!empty($consultafk)) $vinculos[] = "<span class='badge bg-light text-dark border'>Consulta #{$consultafk}</span>";
                        if(!empty($prescricaofk)) $vinculos[] = "<span class='badge bg-light text-dark border'>Prescrição #{$prescricaofk}</span>";
                        if(!empty($vendafk)) $vinculos[] = "<span class='badge bg-success-subtle text-success border border-success-subtle'>Venda #{$vendafk}</span>";
                        $vinculos_str = empty($vinculos) ? "<span class='text-muted small'>Lançamento Avulso</span>" : implode(" ", $vinculos);

                        echo "<tr>";
                        echo "<td>{$dataFormatada}</td>";
                        echo "<td class='fw-bold text-dark'>{$nome_cliente}</td>";
                        echo "<td><span class='badge bg-primary-subtle text-primary border border-primary-subtle'>{$nome_forma}</span></td>";
                        echo "<td>{$prestacoes}x</td>";
                        echo "<td>{$vinculos_str}</td>";
                        echo "<td class='fw-bold text-success'>R$ " . number_format($valor, 2, ',', '.') . "</td>";
                        echo "<td class='text-center'>";
                        echo "<a href='editarpagamento.php?idpagamento={$id}' class='btn btn-sm btn-outline-primary me-2' title='Editar'><img src='img/alterar.png' width='16'></a>";
                        echo "<a href='../controller/pagamentocontroller.php?idpagamento={$id}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Deseja excluir definitivamente este registro do fluxo financeiro?')\" title='Excluir'><img src='img/apagar.png' width='16'></a>";
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
