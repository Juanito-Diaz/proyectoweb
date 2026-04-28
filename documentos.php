<?php 
require_once 'auth.php'; 
require_once 'db.php';

$documentos = DB::query("SELECT d.*, u.username as subido_por 
                         FROM documento d 
                         LEFT JOIN usuario u ON d.fk_user_id = u.id 
                         ORDER BY d.created DESC");
?>
<div class="container-fluid py-4">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="fw-bold mb-1">Documentación</h2>
            <p class="text-muted small mb-0">Repositorio central de archivos y registros.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Cargar Documento</h5>
                    <form id="formDocumento" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Archivo</label>
                            <input type="file" class="form-control" name="archivo" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Título</label>
                            <input type="text" class="form-control" name="descripcion_corta" placeholder="Ej: Factura Abril" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Descripción</label>
                            <textarea class="form-control" name="descripcion_larga" rows="3" placeholder="Detalles adicionales..."></textarea>
                        </div>
                        <button type="button" onclick="subirDocumento()" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-cloud-arrow-up me-2"></i> Subir Archivo
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Nombre</th>
                                <th>Referencia</th>
                                <th>Fecha</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($documentos)): ?>
                                <tr><td colspan="4" class="text-center py-5 text-muted">No hay documentos registrados.</td></tr>
                            <?php else: ?>
                                <?php foreach ($documentos as $doc): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-file-earmark-text fs-4 text-primary me-2"></i>
                                                <div>
                                                    <div class="fw-bold"><?php echo htmlspecialchars($doc['nombre']); ?></div>
                                                    <small class="text-muted"><?php echo round($doc['tamano'] / 1024 / 1024, 2); ?> MB</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="text-dark small"><?php echo htmlspecialchars($doc['descripcion_corta']); ?></span></td>
                                        <td class="text-muted small"><?php echo date('d/m/Y', strtotime($doc['created'])); ?></td>
                                        <td class="text-center">
                                            <div class="btn-group shadow-sm">
                                                <a href="ver_documento.php?id=<?php echo $doc['id']; ?>" target="_blank" class="btn btn-white btn-sm border" title="Ver"><i class="bi bi-eye"></i></a>
                                                <button onclick="eliminarDocumento(<?php echo $doc['id']; ?>)" class="btn btn-white btn-sm border text-danger" title="Eliminar"><i class="bi bi-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
