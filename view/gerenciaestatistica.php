<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/dao/estatisticadao.php";

include __DIR__ . "/topo.html";

$edao = new estatisticaDao();
$indicadores = $edao->obterIndicadoresGerais();

if (!$indicadores) {
    echo "<div class='container mt-5'><div class='alert alert-danger shadow'>Falha ao carregar o motor estatístico do sistema. Verifique a conexão.</div></div>";
    include __DIR__ . "/rodape.html";
    exit();
}
?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-light text-dark"><i class="bi bi-bar-chart-line-fill text-primary"></i> Business Intelligence & Analytics</h2>
            <p class="text-muted small mb-0">Visão consolidada de desempenho e métricas operacionais atualizadas em tempo real.</p>
        </div>
        <a href="gerenciaestatistica.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-arrow-clockwise"></i> Recalcular Indicadores
        </a>
    </div>

    <?php if (isset($_SESSION["resultado_estatistica"])): ?>
        <div class="alert alert-success shadow-sm mb-4">
            <?php echo $_SESSION["mensagem_estatistica"]; unset($_SESSION["resultado_estatistica"]); unset($_SESSION["mensagem_estatistica"]); ?>
        </div>
    <?php endif; ?>

    <!-- SEÇÃO 1: RESUMO DO FLUXO FINANCEIRO GERAL -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 border-start border-5 border-success bg-white">
                <div class="card-body p-4">
                    <h6 class="text-muted text-uppercase small">Faturamento Geral (Entradas)</h6>
                    <h3 class="fw-bold text-success mt-2">R$ <?php echo number_format($indicadores['total_faturado'], 2, ',', '.'); ?></h3>
                    <p class="text-muted small mb-0"><i class="bi bi-wallet2 text-success"></i> Entradas brutas processadas</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 border-start border-5 border-danger bg-white">
                <div class="card-body p-4">
                    <h6 class="text-muted text-uppercase small">Total de Gastos (Despesas / Saídas)</h6>
                    <h3 class="fw-bold text-danger mt-2">R$ <?php echo number_format($indicadores['total_despesas'], 2, ',', '.'); ?></h3>
                    <p class="text-muted small mb-0"><i class="bi bi-graph-down text-danger"></i> Custos operacionais registrados</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <?php 
            $classeCard = $indicadores['balanco_liquido'] >= 0 ? 'border-success' : 'border-danger';
            $classeTexto = $indicadores['balanco_liquido'] >= 0 ? 'text-success' : 'text-danger';
            ?>
            <div class="card border-0 shadow-sm rounded-3 border-start border-5 <?php echo $classeCard; ?> bg-white">
                <div class="card-body p-4">
                    <h6 class="text-muted text-uppercase small">Balanço Líquido Interno</h6>
                    <h3 class="fw-bold <?php echo $classeTexto; ?> mt-2">R$ <?php echo number_format($indicadores['balanco_liquido'], 2, ',', '.'); ?></h3>
                    <p class="text-muted small mb-0"><i class="bi bi-cash-coin"></i> Sobra de caixa pós-despesas</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- SEÇÃO 2: DETALHAMENTO OPERACIONAL / CADASTROS -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-dark text-white p-3 border-0 rounded-top-4">
                    <h5 class="mb-0 small text-uppercase tracking-wider"><i class="bi bi-activity"></i> Indicadores de Volume Operacional</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush rounded-bottom-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <strong class="text-dark">Tutores Atendidos (Clientes)</strong>
                                <br><small class="text-muted">Total de pessoas cadastradas na clínica</small>
                            </div>
                            <span class="badge bg-primary rounded-pill fs-6 px-3"><?php echo $indicadores['total_clientes']; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <strong class="text-dark">Pacientes Ativos (Pets)</strong>
                                <br><small class="text-muted">Animais de estimação registrados no prontuário</small>
                            </div>
                            <span class="badge bg-success rounded-pill fs-6 px-3"><?php echo $indicadores['total_pets']; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <strong class="text-dark">Atendimentos Médicos (Consultas)</strong>
                                <br><small class="text-muted">Histórico total de consultas agendadas/feitas</small>
                            </div>
                            <span class="badge bg-info text-dark rounded-pill fs-6 px-3"><?php echo $indicadores['total_consultas']; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <strong class="text-dark">Medicamentos Cadastrados</strong>
                                <br><small class="text-muted">Princípios ativos cadastrados no estoque químico</small>
                            </div>
                            <span class="badge bg-secondary rounded-pill fs-6 px-3"><?php echo $indicadores['total_remedios']; ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- SEÇÃO 3: DETALHAMENTO COMERCIAL (VENDAS & PETSHOP) -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-dark text-white p-3 border-0 rounded-top-4">
                    <h5 class="mb-0 small text-uppercase tracking-wider"><i class="bi bi-cart3"></i> Estatísticas Comerciais & Petshop</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush rounded-bottom-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <strong class="text-dark">Faturamento com Itens de Venda</strong>
                                <br><small class="text-muted">Subtotal arrecadado com produtos de balcão</small>
                            </div>
                            <span class="text-success fw-bold fs-5">R$ <?php echo number_format($indicadores['faturamento_vendas'], 2, ',', '.'); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <strong class="text-dark">Volume de Itens Despachados</strong>
                                <br><small class="text-muted">Soma de quantidades de produtos vendidos</small>
                            </div>
                            <span class="badge bg-warning text-dark rounded-pill fs-6 px-3"><?php echo $indicadores['qtd_itens_vendidos']; ?> un</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <strong class="text-dark">Catálogo Comercial (Produtos)</strong>
                                <br><small class="text-muted">Variedade de produtos cadastrados no sistema</small>
                            </div>
                            <span class="badge bg-dark rounded-pill fs-6 px-3"><?php echo $indicadores['total_produtos']; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <strong class="text-dark">Estoque Geral de Imobilizados</strong>
                                <br><small class="text-muted">Quantidade total de produtos físicos em estoque</small>
                            </div>
                            <span class="badge bg-secondary rounded-pill fs-6 px-3"><?php echo $indicadores['estoque_total_produtos']; ?> un</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- SEÇÃO 4: CARTEIRA PROFILÁTICA / VACINAS -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-secondary text-white p-3 border-0 rounded-top-4">
                    <h5 class="mb-0 small text-uppercase tracking-wider"><i class="bi bi-shield-check"></i> Monitoramento de Imunização Clínico</h5>
                </div>
                <div class="card-body p-4 bg-white rounded-bottom-4">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <h6 class="text-muted small text-uppercase">Tipos de Vacinas Oferecidas</h6>
                            <p class="display-6 fw-bold text-dark mb-0"><?php echo $indicadores['total_vacinas']; ?></p>
                        </div>
                        <div class="col-6">
                            <h6 class="text-muted small text-uppercase">Total de Aplicações Injetadas</h6>
                            <p class="display-6 fw-bold text-success mb-0"><?php echo $indicadores['total_aplicacoes_vacina']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . "/rodape.html"; ?>