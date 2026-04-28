<?php
require_once 'auth.php';
require_once 'db.php';

$id = $_POST['id'];

try {
    DB::delete('producto', "id_producto=%d", $id);
    echo "Éxito: Producto eliminado";
} catch (Exception $e) {
    try {
        DB::delete('producto', "id=%d", $id);
        echo "Éxito: Producto eliminado";
    } catch (Exception $e2) {
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error al eliminar: " . $e2->getMessage();
    }
}
?>
