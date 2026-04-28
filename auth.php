<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    // Si es una petición AJAX, podemos enviar un script para redirigir la página completa
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo "<script>window.location.href='login.php';</script>";
        exit();
    } else {
        header("Location: login.php");
        exit();
    }
}
