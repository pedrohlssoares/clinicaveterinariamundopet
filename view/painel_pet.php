<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/dao/historicopetdao.php";

include __DIR__ . "/topo.html";

if (!isset($_GET["idpet"]) || empty($_GET["idpet"])) {
    header("location: consultar_historico.php");
    exit();
}

$idpet = intval($_GET["idpet"]);
$hdao = new historicoPetDao();

// Carrega todas as informações cruzadas via JOINs em lote
$dadosCadastrais = $hdao->buscarPetECliente($idpet);

if (!$dadosCadastrais) {
    echo "<div class='container mt-5'><div class='alert alert-danger text-center shadow'>Paciente não localizado ou sem dono cadastrado. Tente novamente.</div></div>";
    include __DIR__ . "/rodape.html";
    exit();
}

$consultas = $hdao->listarConsultas($idpet);
$vacinas = $hdao->listarVacinas($idpet);
$vendas = $hdao->listarVendas($idpet);
$totalGasto = $hdao->calcularTotalGasto($idpet);

$tabAtiva = isset($_GET["tab"]) ? $_GET["tab"] : "consultas";
?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light text-dark"><i class="bi bi-shield-shaded text-success"></i> Central de Inteligência do Paciente</h2>
        <a href="consultar_historico.php" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Voltar à Busca
        </a>
    </div>

    <!-- TOPO: Dados Cadastrais Combinados -->
    <div class="row g-3 mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 h-100 rounded-3 border-start border-5 border-primary">
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Coluna do Animal -->
                        <div class="col-sm-6 border-end">
                            <h5 class="text-primary mb-3"><i class="bi bi-github"></i> Ficha do Animal</h5>
                            <ul class="list-unstyled lh-lg mb-0">
                                <li><strong>Nome:</strong> <span class="text-dark fw-semibold"><?php echo $dadosCadastrais["pet_nome"]; ?></span> <span class="badge bg-secondary">#<?php echo $idpet; ?></span></li>
                                <li><strong>Espécie:</strong> <?php echo $dadosCadastrais["especie"]; ?></li>
                                <li><strong>Raça:</strong> <?php echo $dadosCadastrais["raca"]; ?></li>
                                <li><strong>Idade:</strong> <?php echo $dadosCadastrais["idade"]; ?></li>
                            </ul>
                        </div>
                        <!-- Coluna do Proprietário -->
                        <div class="col-sm-6 ps-sm-4">
                            <h5 class="text-primary mb-3"><i class="bi bi-person-bounding-box"></i> Proprietário (Tutor)</h5>
                            <ul class="list-unstyled lh-lg mb-0">
                                <li><strong>Nome:</strong> <?php echo $dadosCadastrais["dono_nome"]; ?></li>
                                <li><strong>CPF:</strong> <?php echo $dadosCadastrais["dono_cpf"]; ?></li>
                                <li><strong>Celular:</strong> <?php echo $dadosCadastrais["dono_celular"]; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Painel Financeiro -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 rounded-3 text-white text-center border-start border-5 border-success" style="background-color: #2c3e50;">
                <div class="card-body d-flex flex-column justify-content-center p-4">
                    <h6 class="text-uppercase tracking-wider text-success fw-bold mb-2"><i class="bi bi-currency-dollar"></i> Investimento Clínico</h6>
                    <p class="display-6 fw-bold text-success mb-1">R$ <?php echo number_format($totalGasto, 2, ',', '.'); ?></p>
                    <small class="text-white-50">Soma acumulada de consultas e produtos</small>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTÕES OPERACIONAIS -->
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-body p-3 bg-white">
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <a href="painel_pet.php?idpet=<?php echo $idpet; ?>&tab=consultas" class="btn <?php echo $tabAtiva == 'consultas' ? 'btn-primary px-4 shadow' : 'btn-outline-primary px-4'; ?>">
                    <i class="bi bi-calendar2-week me-2"></i> Histórico de Consultas (<?php echo count($consultas); ?>)
                </a>
                <a href="painel_pet.php?idpet=<?php echo $idpet; ?>&tab=vacinas" class="btn <?php echo $tabAtiva == 'vacinas' ? 'btn-success px-4 shadow' : 'btn-outline-success px-4'; ?>">
                    <i class="bi bi-shield-plus me-2"></i> Histórico de Vacinas (<?php echo count($vacinas); ?>)
                </a>
                <a href="painel_pet.php?idpet=<?php echo $idpet; ?>&tab=vendas" class="btn <?php echo $tabAtiva == 'vendas' ? 'btn-warning text-dark px-4 shadow' : 'btn-outline-warning text-dark px-4'; ?>">
                    <i class="bi bi-bag-check me-2"></i> Lista de Compras/Vendas (<?php echo count($vendas); ?>)
                </a>
            </div>
        </div>
    </div>

    <!-- ÁREA DAS LISTAS DINÂMICAS -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            
            <?php if ($tabAtiva == 'consultas'): ?>
                <div class="p-4 border-bottom bg-light rounded-top-4">
                    <h4 class="h5 mb-0 text-dark"><i class="bi bi-calendar2-week text-primary me-2"></i> Prontuário Médico</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 bg-white">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4">Data Atendimento</th>
                                <th>Horário</th>
                                <th>Sala / Setor</th>
                                <th>Status</th>
                                <th class="pe-4">Procedimentos / Anamnese</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($consultas)): ?>
                                <tr><td colspan="5" class="text-center py-4 text-muted">Nenhuma consulta registrada.</td></tr>
                            <?php else: ?>
                                <?php foreach ($consultas as $c): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold"><?php echo date('d/m/Y', strtotime($c["data_consulta"])); ?></td>
                                        <td><span class="text-primary fw-bold"><?php echo $c["horario"]; ?></span></td>
                                        <td><span class="badge bg-light text-dark border">Sala <?php echo $c["sala_numero"] ?? '—'; ?> (<?php echo $c["sala_tipo"] ?? 'Geral'; ?>)</span></td>
                                        <td>
                                            <?php 
                                            $classeBadge = ($c["status"] == 'Agendada') ? 'bg-warning text-dark' : 'bg-success';
                                            echo "<span class='badge {$classeBadge} border'>{$c["status"]}</span>";
                                            ?>
                                        </td>
                                        <td class="pe-4 text-muted small"><?php echo htmlspecialchars($c["processos_feitos"] ?? '—'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            <?php elseif ($tabAtiva == 'vacinas'): ?>
                <div class="p-4 border-bottom bg-light rounded-top-4">
                    <h4 class="h5 mb-0 text-dark"><i class="bi bi-shield-plus text-success me-2"></i> Carteira de Vacinação</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 bg-white">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4">Princípio Ativo</th>
                                <th>Data da Aplicação</th>
                                <th class="pe-4">Dosagem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($vacinas)): ?>
                                <tr><td colspan="3" class="text-center py-4 text-muted">Nenhuma vacina registrada.</td></tr>
                            <?php else: ?>
                                <?php foreach ($vacinas as $v): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-success"><i class="bi bi-patch-check-fill"></i> <?php echo $v["vacina_nome"]; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($v["data_aplicacao"])); ?></td>
                                        <td class="pe-4"><span class="badge bg-light text-dark border"><?php echo $v["dosagem"]; ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            <?php elseif ($tabAtiva == 'vendas'): ?>
                <div class="p-4 border-bottom bg-light rounded-top-4">
                    <h4 class="h5 mb-0 text-dark"><i class="bi bi-bag-check text-warning me-2"></i> Histórico de Consumo</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 bg-white">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4">Código Item</th>
                                <th>Data do Faturamento</th>
                                <th>Produto Adquirido</th>
                                <th>Qtd</th>
                                <th>Preço Unitário</th>
                                <th class="pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($vendas)): ?>
                                <tr><td colspan="6" class="text-center py-4 text-muted">Nenhum produto consumido via consulta.</td></tr>
                            <?php else: ?>
                                <?php foreach ($vendas as $vd): ?>
                                    <?php $sub = $vd["quantidade"] * $vd["valor_unitario"]; ?>
                                    <tr>
                                        <td class="ps-4 text-muted">#<?php echo $vd["idvenda"]; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($vd["data_pagamento"])); ?></td>
                                        <td class="fw-bold text-dark"><?php echo $vd["produto_nome"]; ?></td>
                                        <td><?php echo $vd["quantidade"]; ?> un</td>
                                        <td>R$ <?php echo number_format($vd["valor_unitario"], 2, ',', '.'); ?></td>
                                        <td class="pe-4 fw-bold text-success">R$ <?php echo number_format($sub, 2, ',', '.'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>