<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "model/entity/cliente.php";
include_once $base . "model/dao/clientedao.php";
include_once $base . "model/entity/endereco.php";
include_once $base . "model/dao/enderecodao.php";

include __DIR__ . "/topo.html";
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-green);">🐾 Novo Cliente</h2>
        <a href="gerenciacliente.php" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-list"></i> Ver Clientes Cadastrados
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/clientecontroller.php">
                
                <input type="hidden" name="idcliente" value="">
                <input type="hidden" name="idendereco" value="">

                <div class="row justify-content-center">
                    <div class="col-md-5 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Dados Pessoais</h4>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="nome" placeholder="Nome completo" required></div>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="cpf" placeholder="CPF" required></div>
                        <div class="mb-3"><input type="email" class="form-control custom-input" name="email" placeholder="E-mail"></div>
                        <div class="mb-3"><input type="tel" class="form-control custom-input" name="celular" placeholder="Celular/WhatsApp"></div>
                    </div>

                    <div class="col-md-5 px-4 border-start">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Endereço</h4>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="rua" placeholder="Rua"></div>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="bairro" placeholder="Bairro"></div>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="cidade" placeholder="Cidade"></div>
                        <div class="row g-2">
                            <div class="col-4"><input type="text" class="form-control custom-input" name="numero" placeholder="Nº"></div>
                            <div class="col-8"><input type="text" class="form-control custom-input" name="complemento" placeholder="Complemento"></div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Cadastrar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>
