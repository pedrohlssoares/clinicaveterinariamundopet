<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/forma_pagamento.php";
include_once $base . "entity/dao/forma_pagamentodao.php";

include __DIR__ . "/topo.html";

$fpdao = new forma_pagamentoDao();

if (!isset($_GET["idforma_pagamento"])) {
    header("location: gerenciaforma_pagamento.php");
    exit();
}

$fp_obj = $fpdao->readID($_GET["idforma_pagamento"]);

if (!$fp_obj) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Forma de pagamento não encontrada!</div></div>";
    include __DIR__ . "/rodape.html";
    exit();
}

$idforma_pagamento = is_object($fp_obj) ? $fp_obj->idforma_pagamento : $fp_obj["idforma_pagamento"];
$tipo = is_object($fp_obj) ? $fp_obj->tipo : $fp_obj["tipo"];
$descricao = is_object($fp_obj) ? $fp_obj->descricao : $fp_obj["descricao"];
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light text-primary">✏️ Editar Forma de Pagamento</h2>
        <a href="gerenciaforma_pagamento.php" class="btn btn-outline-secondary shadow-sm">
            Cancelar / Voltar
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/forma_pagamentocontroller.php">
                <input type="hidden" name="idforma_pagamento" value="<?php echo $idforma_pagamento; ?>">

                <div class="row justify-content-center">
                    <div class="col-md-6 px-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Tipo (Ex: Cartão de Crédito, Pix)</label>
                            <input type="text" class="form-control custom-input" name="tipo" value="<?php echo htmlspecialchars($tipo); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Descrição / Regras</label>
                            <textarea class="form-control custom-input" name="descricao" rows="3" required><?php echo htmlspecialchars($descricao); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Atualizar Método
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>