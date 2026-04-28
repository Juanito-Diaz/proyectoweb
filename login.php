<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        // Validación contra la tabla usuario (texto plano como pidió el usuario)
        $user = DB::queryFirstRow("SELECT * FROM usuario WHERE username=%s AND password=%s", $username, $password);

        if ($user) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        }
        else {
            $error = 'Usuario o contraseña incorrectos.';
        }
    }
    else {
        $error = 'Por favor, complete todos los campos.';
    }
}

// Si ya tiene sesión, redirigir al index
if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Inventarios</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            margin: auto;
        }

        .card {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            padding: 2rem 1rem;
            text-align: center;
        }

        .brand-icon {
            font-size: 3rem;
            color: #712cf9;
            margin-bottom: 10px;
        }

        .card-header h4 {
            font-weight: 600;
            color: #212529;
            margin-bottom: 0;
        }

        .btn-primary {
            background-color: #712cf9;
            border-color: #712cf9;
            padding: 0.6rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #5a23c8;
            border-color: #5a23c8;
        }

        .form-floating > .form-control:focus {
            border-color: #712cf9;
            box-shadow: 0 0 0 0.25rem rgba(113, 44, 249, 0.25);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="card">
        <div class="card-header">
            <div class="brand-icon">
                <i class="bi bi-boxes"></i>
            </div>
            <h4>Acceso al Sistema</h4>
            <p class="text-muted small mb-0">Ingresa correctamente los datos para continuar</p>
        </div>
        <div class="card-body p-4">
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show py-2 small" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="padding: 0.8rem"></button>
                </div>
            <?php
endif; ?>

            <form action="login.php" method="POST">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Usuario" required autofocus>
                    <label for="username">Usuario</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                    <label for="password">Contraseña</label>
                </div>
                
                <button class="w-100 btn btn-lg btn-primary" type="submit">Iniciar Sesión</button>
            </form>
        </div>
        <div class="card-footer bg-light border-0 text-center py-3">
            <span class="text-muted small">Programación web</span>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
