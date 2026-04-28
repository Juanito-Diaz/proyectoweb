<?php
require_once 'auth.php';
require_once 'db.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$ap_paterno = $_POST['ap_paterno'];
$ap_materno = $_POST['ap_materno'];
$rfc = $_POST['rfc'];

try {
    DB::update('cliente', [
        'nombre' => $nombre,
        'apellido_paterno' => $ap_paterno,
        'apellido_materno' => $ap_materno,
        'rfc' => $rfc
    ], "id=%d", $id);

    echo "Éxito: Cliente actualizado";
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo "Error al actualizar: " . $e->getMessage();
}
?>
