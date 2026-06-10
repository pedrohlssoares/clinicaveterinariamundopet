<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/cliente.php";
include_once $base . "entity/dao/clientedao.php";
include_once $base . "entity/model/endereco.php";
include_once $base . "entity/dao/enderecodao.php";

include __DIR__ . "/topo.html";

$cdao = new clienteDao();
$edao = new enderecoDao();

if (!isset($_GET["idcliente"])) {
    header("location: gerenciacliente.php");
    exit();
}

$cli_obj = $cdao->readId($_GET["idcliente"]);

if (!$cli_obj) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Cliente não encontrado!</div></div>";
    include __DIR__ . "/rodape.html";
    exit();
}

$end_obj = $edao->readId($cli_obj->enderecoclientefk);

if (!$end_obj) {
    $end_obj = new stdClass();
    $end_obj->idendereco = "";
    $end_obj->rua = "";
    $end_obj->bairro = "";
    $end_obj->cidade = "";
    $end_obj->numero = "";
    $end_obj->complemento = "";
}
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light text-primary">✏️ Editar Cliente</h2>
        <a href="gerenciacliente.php" class="btn btn-outline-secondary shadow-sm">
            Cancelar / Voltar
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/clientecontroller.php">
                
                <input type="hidden" name="idcliente" value="<?php echo $cli_obj->idcliente ?>">
                <input type="hidden" name="idendereco" value="<?php echo $end_obj->idendereco ?>">

                <div class="row justify-content-center">
                    <div class="col-md-5 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Dados Pessoais</h4>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="nome" placeholder="Nome completo" value="<?php echo $cli_obj->nome ?>" required></div>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="cpf" placeholder="CPF" value="<?php echo $cli_obj->cpf ?>" required></div>
                        <div class="mb-3"><input type="email" class="form-control custom-input" name="email" placeholder="E-mail" value="<?php echo $cli_obj->email ?>"></div>
                        <div class="mb-3"><input type="tel" class="form-control custom-input" name="celular" placeholder="Celular/WhatsApp" value="<?php echo $cli_obj->celular ?>"></div>
                    </div>

                    <div class="col-md-5 px-4 border-start">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Endereço</h4>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="rua" placeholder="Rua" value="<?php echo $end_obj->rua ?>"></div>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="bairro" placeholder="Bairro" value="<?php echo $end_obj->bairro ?>"></div>
                        <div class="mb-3"><input type="text" class="form-control custom-input" name="cidade" placeholder="Cidade" value="<?php echo $end_obj->cidade ?>"></div>
                        <div class="row g-2">
                            <div class="col-4"><input type="text" class="form-control custom-input" name="numero" placeholder="Nº" value="<?php echo $end_obj->numero ?>"></div>
                            <div class="col-8"><input type="text" class="form-control custom-input" name="complemento" placeholder="Complemento" value="<?php echo $end_obj->complemento ?>"></div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Atualizar Dados do Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>
