<?php
require_once 'db.php';
require_once 'auth.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $doc = DB::queryFirstRow("SELECT d.*, u.username as subido_por 
                             FROM documento d 
                             LEFT JOIN usuario u ON d.fk_user_id = u.id 
                             WHERE d.id = %i", $id);

    if ($doc) {
        ?>
        <div class="ficha-tecnica">
            <div class="row mb-5 text-center">
                <div class="col-12">
                    <h2 class="text-uppercase fw-bold border-bottom pb-3">Ficha Técnica de Documento</h2>
                    <p class="text-muted">Sistema de Gestión de Inventarios - Módulo de Documentación</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <p class="mb-1 text-secondary text-uppercase small fw-bold">Nombre del Archivo</p>
                    <p class="fs-5 fw-bold text-primary"><?php echo htmlspecialchars($doc['nombre']); ?></p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-1 text-secondary text-uppercase small fw-bold">ID Registro</p>
                    <p class="fs-5">#<?php echo str_pad($doc['id'], 5, "0", STR_PAD_LEFT); ?></p>
                </div>

                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3">
                        <p class="mb-1 text-secondary text-uppercase extra-small fw-bold">Tipo de Archivo</p>
                        <p class="mb-0 fw-semibold"><?php echo strtoupper(explode('/', $doc['tipo'])[1]); ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3">
                        <p class="mb-1 text-secondary text-uppercase extra-small fw-bold">Tamaño</p>
                        <p class="mb-0 fw-semibold"><?php echo round($doc['tamano'] / 1024 / 1024, 2); ?> MB</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3">
                        <p class="mb-1 text-secondary text-uppercase extra-small fw-bold">Fecha de Carga</p>
                        <p class="mb-0 fw-semibold"><?php echo date('d/m/Y H:i', strtotime($doc['created'])); ?></p>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <p class="mb-1 text-secondary text-uppercase small fw-bold border-bottom">Descripción General</p>
                    <p class="lead italic"><?php echo nl2br(htmlspecialchars($doc['descripcion_corta'])); ?></p>
                </div>

                <div class="col-12 mt-2">
                    <p class="mb-1 text-secondary text-uppercase small fw-bold border-bottom">Contenido / Detalles Adicionales</p>
                    <div class="p-4 border rounded-3 bg-white" style="min-height: 150px;">
                        <?php echo !empty($doc['descripcion_larga']) ? nl2br(htmlspecialchars($doc['descripcion_larga'])) : '<span class="text-muted italic">Sin descripción detallada disponible.</span>'; ?>
                    </div>
                </div>

                <div class="col-12 mt-5 pt-4 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 text-muted small">Subido por:</p>
                            <p class="fw-bold mb-0 text-dark"><?php echo htmlspecialchars($doc['subido_por']); ?></p>
                        </div>
                        <div class="text-end">
                            <i class="bi bi-shield-check text-success fs-2"></i>
                            <p class="extra-small text-muted mb-0">Documento Verificado</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
            .extra-small { font-size: 0.7rem; }
            .italic { font-style: italic; }
            .ficha-tecnica { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        </style>
        <?php
    } else {
        echo "<div class='alert alert-danger'>Documento no encontrado.</div>";
    }
}
?>
