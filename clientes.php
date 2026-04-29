<?php
require_once 'auth.php';
require_once 'db.php';
try {
    $results = DB::query("SELECT * FROM cliente");
} catch (Exception $e) {
    $results = [];
}
?>
<div class="container-fluid py-4">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="fw-bold mb-1">Clientes</h2>
            <p class="text-muted small mb-0">Gestión de la base de datos de clientes.</p>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-outline-danger shadow-sm me-2" onclick="descargarReporte('clientes')">
                <i class="bi bi-file-earmark-pdf me-2"></i> Descargar Reporte
            </button>
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
                <i class="bi bi-person-plus me-2"></i> Nuevo Cliente
            </button>
        </div>
    </div>

    <div class="row g-4">
        <?php foreach ($results as $r): ?>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-weight: 700;">
                                <?php echo strtoupper(substr($r['nombre'], 0, 1)); ?>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                    <li><a class="dropdown-item py-2" href="#" onclick="cargarDatosClienteE('<?php echo $r['id']; ?>', '<?php echo addslashes($r['nombre']); ?>', '<?php echo addslashes($r['apellido_paterno']); ?>', '<?php echo addslashes($r['apellido_materno']); ?>', '<?php echo addslashes($r['rfc']); ?>')" data-bs-toggle="modal" data-bs-target="#modalActualizarCliente">Editar</a></li>
                                    <li><a class="dropdown-item py-2 text-danger" href="#" onclick="eliminarCliente('<?php echo $r['id']; ?>')">Eliminar</a></li>
                                </ul>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-1"><?php echo $r['nombre']; ?></h5>
                        <p class="text-muted small mb-3"><?php echo $r['apellido_paterno'] . ' ' . $r['apellido_materno']; ?></p>
                        <div class="bg-light p-2 rounded-2">
                            <small class="text-muted d-block" style="font-size: 0.7rem;">RFC</small>
                            <span class="fw-bold text-primary"><?php echo $r['rfc']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modales -->
<div class="modal fade" id="modalNuevoCliente" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formCliente">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nombre</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">A. Paterno</label>
                            <input type="text" class="form-control" name="ap_paterno" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">A. Materno</label>
                            <input type="text" class="form-control" name="ap_materno" required>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">RFC</label>
                        <input type="text" class="form-control" name="rfc" id="rfc_nuevo" required>
                        <div id="rfc_error" class="form-text text-muted">El RFC debe tener exactamente 13 caracteres.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" onclick="guardarNuevoCliente()" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalActualizarCliente" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualizar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formActualizarCliente">
                <input type="hidden" name="id" id="upd_cliente_id">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="upd_cliente_nombre" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">A. Paterno</label>
                            <input type="text" class="form-control" name="ap_paterno" id="upd_cliente_ap_paterno" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">A. Materno</label>
                            <input type="text" class="form-control" name="ap_materno" id="upd_cliente_ap_materno" required>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">RFC</label>
                        <input type="text" class="form-control" name="rfc" id="upd_cliente_rfc" required>
                        <div id="rfc_error_upd" class="form-text text-muted">El RFC debe tener exactamente 13 caracteres.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" onclick="guardarActualizacionCliente()" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>