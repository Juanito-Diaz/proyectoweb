<?php
require_once 'auth.php';
require_once 'db.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$categoria = $_POST['categoria'];
$cantidad = $_POST['cantidad'];
$precio = $_POST['precio'];

try {
    $data = [
        'nombre' => $nombre,
        'categoria' => $categoria,
        'cantidad' => $cantidad,
        'precio' => $precio
    ];
    DB::update('producto', $data, "id_producto=%d", $id);

    echo "Éxito: Producto actualizado";
} catch (Exception $e) {
    try {
        DB::update('producto', $data, "id=%d", $id);
        echo "Éxito: Producto actualizado";
    } catch (Exception $e2) {
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error al actualizar: " . $e2->getMessage();
    }
}
?>
