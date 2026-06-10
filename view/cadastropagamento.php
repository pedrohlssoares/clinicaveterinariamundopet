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
include_once $base . "entity/model/consulta.php";
include_once $base . "entity/dao/consultadao.php";
include_once $base . "entity/model/prescricao.php";
include_once $base . "entity/dao/prescricaodao.php";
include_once $base . "entity/model/pet.php";
include_once $base . "entity/dao/petdao.php";

include __DIR__ . "/topo.html";

$cdao = new clienteDao();
$fpdao = new forma_pagamentoDao();
$condao = new consultaDao();
$prdao = new prescricaoDao();
$petdao = new petdao();

$clientes = $cdao->read();
$formas = $fpdao->read();
$consultas = $condao->read();
$prescricoes = $prdao->read();
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-green);">💰 Registrar Novo Pagamento / Fatura</h2>
        <a href="gerenciapagamento.php" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-list"></i> Ver Fluxo de Caixa
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/pagamentocontroller.php">
                <input type="hidden" name="idpagamento" value="">

                <div class="row justify-content-center">
                    <div class="col-md-5 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Dados do Cliente e Valores</h4>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Tutor (Cliente)</label>
                            <select class="form-select custom-input" name="clientepagamentofk" required>
                                <option value="">— Selecione o Responsável —</option>
                                <?php 
                                if($clientes){
                                    foreach ($clientes as $cli) {
                                        $id = is_object($cli) ? $cli->idcliente : $cli["idcliente"];
                                        $nome = is_object($cli) ? $cli->nome : $cli["nome"];
                                        echo "<option value='{$id}'>{$nome}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Forma de Pagamento</label>
                            <select class="form-select custom-input" name="formapagamentofk" required>
                                <option value="">— Escolha o Método —</option>
                                <?php 
                                if($formas){
                                    foreach ($formas as $f) {
                                        $id = is_object($f) ? $f->idforma_pagamento : $f["idforma_pagamento"];
                                        $tipo = is_object($f) ? $f->tipo : $f["tipo"];
                                        echo "<option value='{$id}'>{$tipo}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="row g-2">
                            <div class="col-6 mb-3">
                                <label class="form-label text-muted small">Valor Total (R$)</label>
                                <input type="number" step="0.01" class="form-control custom-input" name="valor" placeholder="0,00" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label text-muted small">Nº Parcelas / Prestações</label>
                                <input type="number" class="form-control custom-input" name="prestacoes" value="1" min="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Data do Pagamento</label>
                            <input type="datetime-local" class="form-control custom-input" name="data_pagamento" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-5 px-4 border-start">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Vínculos Clínicos (Opcional)</h4>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Vincular a uma Consulta</label>
                            <select class="form-select custom-input" name="consultapagamentofk">
                                <option value="">— Venda Direta de Balcão / Sem Consulta —</option>
                                <?php 
                                if($consultas){
                                    foreach ($consultas as $con) {
                                        $id = is_object($con) ? $con->idconsulta : $con["idconsulta"];
                                        $data = is_object($con) ? ($con->data_consulta ?? $con["data"]) : ($con["data_consulta"] ?? $con["data"]);
                                        $petfk = is_object($con) ? $con->petconsultafk : $con["petconsultafk"];
                                        
                                        $pet = $petdao->readId($petfk);
                                        $nomePet = $pet ? (is_object($pet) ? $pet->nome : $pet["nome"]) : "Pet";
                                        $dataFormatada = date('d/m/Y', strtotime($data));
                                        
                                        echo "<option value='{$id}'>Cód #{$id} - {$dataFormatada} (Pet: {$nomePet})</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Vincular a uma Prescrição de Medicamentos</label>
                            <select class="form-select custom-input" name="prescricaopagamentofk">
                                <option value="">— Nenhuma Prescrição Atrelada —</option>
                                <?php 
                                if($prescricoes){
                                    foreach ($prescricoes as $pr) {
                                        $id = is_object($pr) ? $pr->idprescricao : $pr["idprescricao"];
                                        $dosagem = is_object($pr) ? $pr->dosagem : $pr["dosagem"];
                                        $resumo = mb_strimwidth($dosagem, 0, 30, "...");
                                        echo "<option value='{$id}'>Prescrição #{$id} ({$resumo})</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm" name="btGravar">
                        Efetuar Lançamento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>