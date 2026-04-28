<?php 
require_once 'auth.php';
require_once 'db.php';

try { 
    $results = DB::query("SELECT * FROM producto"); 
} catch (Exception $e) { 
    $results = []; 
}
?>
<div class="container-fluid py-4">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="fw-bold mb-1">Inventario</h2>
            <p class="text-muted small mb-0">Gestión de existencias y productos.</p>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-outline-danger shadow-sm me-2" onclick="descargarReporte('productos')">
                <i class="bi bi-file-earmark-pdf me-2"></i> Descargar Reporte
            </button>
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">
                <i class="bi bi-plus-lg me-2"></i> Nuevo Producto
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th class="text-center">Stock</th>
                        <th class="text-end">Precio</th>
                        <th class="text-center no-print">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $p): ?>
                    <tr>
                        <td class="ps-4 text-muted">#<?php echo $p['id_producto'] ?? $p['id'] ?? $p['ID']; ?></td>
                        <td class="fw-bold"><?php echo $p['nombre']; ?></td>
                        <td><span class="badge bg-light text-dark border"><?php echo $p['categoria']; ?></span></td>
                        <td class="text-center">
                            <?php if($p['cantidad'] <= 5): ?>
                                <span class="badge bg-danger"><?php echo $p['cantidad']; ?></span>
                            <?php else: ?>
                                <span class="badge bg-success"><?php echo $p['cantidad']; ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end fw-bold">$<?php echo number_format($p['precio'], 2); ?></td>
                        <td class="text-center no-print pe-4">
                            <div class="btn-group shadow-sm">
                                <button class="btn btn-white btn-sm border" onclick="cargarDatosProductoE('<?php echo $p['id_producto'] ?? $p['id'] ?? $p['ID']; ?>', '<?php echo addslashes($p['nombre']); ?>', '<?php echo addslashes($p['categoria']); ?>', '<?php echo $p['cantidad']; ?>', '<?php echo $p['precio']; ?>')" data-bs-toggle="modal" data-bs-target="#modalActualizarProducto"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-white btn-sm border text-danger" onclick="eliminarProducto('<?php echo $p['id_producto'] ?? $p['id'] ?? $p['ID']; ?>')"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Nuevo -->
<div class="modal fade" id="modalNuevoProducto" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formProducto">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nombre</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Categoría</label>
                        <input type="text" class="form-control" name="categoria" required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Cantidad</label>
                            <input type="number" class="form-control" name="cantidad" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Precio</label>
                            <input type="number" step="0.01" class="form-control" name="precio" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" onclick="guardarNuevoProducto()" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalActualizarProducto" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualizar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formActualizarProducto">
                <input type="hidden" name="id" id="upd_producto_id">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="upd_producto_nombre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Categoría</label>
                        <input type="text" class="form-control" name="categoria" id="upd_producto_categoria" required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Cantidad</label>
                            <input type="number" class="form-control" name="cantidad" id="upd_producto_cantidad" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Precio</label>
                            <input type="number" step="0.01" class="form-control" name="precio" id="upd_producto_precio" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" onclick="guardarActualizacionProducto()" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>