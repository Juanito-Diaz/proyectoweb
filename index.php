<?php require_once 'auth.php'; ?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sistema de Gestión · Dashboard</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="js/funciones.js"></script>
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="css/estilos.custom.css" rel="stylesheet" />
  <style>
    body { min-height: 100vh; }
    .sidebar { min-height: 100vh; }
  </style>
</head>

<body>
  <header class="navbar sticky-top flex-md-nowrap p-0 shadow-sm">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-4 fs-5" href="index.php">
      <i class="bi bi-shield-check me-2 text-primary"></i>Gestión Corporativa
    </a>

    <div class="d-flex align-items-center px-4 d-none d-md-flex">
      <div class="me-3 text-muted small">
        <span class="opacity-75">Sesión de</span> <span class="fw-semibold text-dark"><?php echo $_SESSION['username']; ?></span>
      </div>
      <a href="logout.php" class="btn btn-sm btn-outline-secondary border-0">
        <i class="bi bi-box-arrow-right"></i>
      </a>
    </div>
  </header>

  <div class="container-fluid">
    <div class="row">
      <div class="sidebar col-md-3 col-lg-2 p-0">
        <div class="offcanvas-md offcanvas-end" tabindex="-1" id="sidebarMenu">
          <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
              <li class="nav-item">
                <div class="px-4 text-uppercase fw-bold text-muted opacity-50 mb-2" style="font-size: 10px;">Operaciones</div>
              </li>
              <li class="nav-item">
                <a onclick="llamarProducto()" class="nav-link d-flex align-items-center gap-2" href="#" style="cursor:pointer">
                  <i class="bi bi-box-seam"></i> Inventario
                </a>
              </li>
              <li class="nav-item">
                <a onclick="llamarClientes()" class="nav-link d-flex align-items-center gap-2" style="cursor: pointer" href="#">
                  <i class="bi bi-people"></i> Clientes
                </a>
              </li>
              <li class="nav-item">
                <a onclick="llamarDocumentos()" class="nav-link d-flex align-items-center gap-2" style="cursor: pointer" href="#">
                  <i class="bi bi-file-earmark-text"></i> Documentación
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div id="cuerpo" class="module-enter py-4">
          <!-- Contenido dinámico -->
        </div>
      </main>
    </div>
  </div>

  <!-- Toasts -->
  <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 2000;">
    <div id="liveToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" id="toastMessage"></div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>

  <!-- Modal Eliminación -->
  <div class="modal fade" id="modalConfirmarEliminacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content border-0 shadow">
        <div class="modal-body p-4 text-center">
          <h5 class="fw-bold mb-3">¿Estás seguro?</h5>
          <p class="text-muted small mb-4">Esta acción eliminará el registro permanentemente.</p>
          <div class="d-grid gap-2">
            <button type="button" class="btn btn-danger" id="btnConfirmarBorrado">Eliminar</button>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="./js/bootstrap.bundle.min.js"></script>
</body>
</html>