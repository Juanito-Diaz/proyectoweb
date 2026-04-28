<?php 
require_once 'auth.php';
require_once 'db.php';

$nombre = $_POST['nombre'];
$categoria = $_POST['categoria'];
$cantidad = $_POST['cantidad'];
$precio = $_POST['precio'];

try {
    DB::insert('producto', [
        'nombre'    => $nombre,
        'categoria' => $categoria,
        'cantidad'  => $cantidad,
        'precio'    => $precio
    ]);
    echo "Éxito";
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Error');
    echo $e->getMessage();
}
?>