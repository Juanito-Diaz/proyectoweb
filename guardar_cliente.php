<?php
require_once 'auth.php';
require_once 'db.php';

$nombre = $_POST['nombre'];
$ap_paterno = $_POST['ap_paterno'];
$ap_materno = $_POST['ap_materno'];
$rfc = $_POST['rfc'];

try {

    DB::insert('cliente', [
        'nombre'            => $nombre,
        'apellido_paterno'  => $ap_paterno,
        'apellido_materno'  => $ap_materno,
        'rfc'               => $rfc
    ]);

    echo "Éxito: Cliente guardado";
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo "Error al insertar: " . $e->getMessage();
}
?>