<?php
session_start();
$base = __DIR__ . '/../';  
include_once $base . "config/conexao.php";
include_once $base . "entity/model/prescricao.php";
include_once $base . "entity/dao/prescricaodao.php";
include_once $base . "entity/model/consulta.php";
include_once $base . "entity/dao/consultadao.php";
include_once $base . "entity/model/remedio.php";
include_once $base . "entity/dao/remediodao.php";
include_once $base . "entity/model/vacina.php";
include_once $base . "entity/dao/vacinadao.php";
include_once $base . "entity/model/pet.php";
include_once $base . "entity/dao/petdao.php";

include __DIR__ . "/topo.html";

$cdao = new consultadao();
$rdao = new remediodao();
$vdao = new vacinadao();
$petdao = new petdao();

$consultas = $cdao->read();
$remedios = $rdao->read();
$vacinas = $vdao->read();
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-light" style="color: var(--pet-green);">💊 Nova Prescrição</h2>
        <a href="gerenciaprescricao.php" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-list"></i> Ver Prescrições
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="../controller/prescricaocontroller.php">
                <input type="hidden" name="idprescricao" value="">

                <div class="row justify-content-center">
                    <div class="col-md-5 px-4">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Vínculo Clínico</h4>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Consulta Origem</label>
                            <select class="form-select custom-input" name="consultaprescricaofk" required>
                                <option value="">— Selecione a Consulta —</option>
                                <?php 
                                if($consultas){
                                    foreach ($consultas as $cons) {
                                    $id = is_object($cons) ? $cons->idconsulta : $cons["idconsulta"];
                                    $data_bruta = is_object($cons) ? $cons->data_consulta : $cons["data_consulta"];
                                    $petfk = is_object($cons) ? $cons->petconsultafk : $cons["petconsultafk"];                
                                    $pet = $petdao->readId($petfk);
                                    $nomePet = $pet ? (is_object($pet) ? $pet->nome : $pet["nome"]) : "Desconhecido";
                                    
                                    $dataFormatada = !empty($data_bruta) ? date('d/m/Y', strtotime($data_bruta)) : "Data Indefinida";
                                    
                                    echo "<option value='{$id}'>Consulta: {$dataFormatada} - Pet: {$nomePet}</option>";
                                }
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Remédio (Opcional)</label>
                            <select class="form-select custom-input" name="remedioprescricaofk">
                                <option value="">— Nenhum / Somente Vacina —</option>
                                <?php 
                                if($remedios){
                                    foreach ($remedios as $rem) {
                                        $id = is_object($rem) ? $rem->idremedio : $rem["idremedio"];
                                        $ativo = is_object($rem) ? $rem->ativo : $rem["ativo"];
                                        echo "<option value='{$id}'>{$ativo}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Vacina (Opcional)</label>
                            <select class="form-select custom-input" name="vacinaprescricaofk">
                                <option value="">— Nenhuma / Somente Remédio —</option>
                                <?php 
                                if($vacinas){
                                    foreach ($vacinas as $vac) {
                                        $id = is_object($vac) ? $vac->idvacina : $vac["idvacina"];
                                        $ativo = is_object($vac) ? $vac->ativo : $vac["ativo"];
                                        echo "<option value='{$id}'>{$ativo}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-5 px-4 border-start">
                        <h4 class="h5 mb-3 border-bottom pb-2" style="color: var(--pet-blue);">Detalhes da Prescrição</h4>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Dosagem / Instruções de Uso</label>
                            <textarea class="form-control custom-input" name="dosagem" rows="5" placeholder="Ex: Administrar 2 gotas a cada 8 horas durante 5 dias..." required></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" name="btGravar">
                        Gerar Prescrição
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/rodape.html"; ?>