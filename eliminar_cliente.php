<?php
require_once 'auth.php';
require_once 'db.php';

$id = $_POST['id'];

try {
    DB::delete('cliente', "id=%d", $id);
    echo "Éxito: Cliente eliminado";
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo "Error al eliminar: " . $e->getMessage();
}
?>
