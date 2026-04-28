<?php
require_once 'db.php';
require_once 'auth.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    try {
        $id = $_POST['id'];

        // Obtener la ruta del archivo para eliminarlo físicamente
        $documento = DB::queryFirstRow("SELECT ruta FROM documento WHERE id = %i", $id);

        if ($documento) {
            $ruta = $documento['ruta'];

            // Eliminar registro de la base de datos
            DB::delete('documento', "id=%i", $id);

            // Eliminar archivo físico si existe
            if (file_exists($ruta)) {
                if (unlink($ruta)) {
                    echo json_encode(['status' => 'success', 'message' => 'Documento y archivo físico eliminados con éxito.']);
                } else {
                    echo json_encode(['status' => 'warning', 'message' => 'Registro eliminado, pero no se pudo borrar el archivo físico.']);
                }
            } else {
                echo json_encode(['status' => 'success', 'message' => 'Registro eliminado. El archivo físico no existía.']);
            }
        } else {
            throw new Exception("Documento no encontrado.");
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Petición no válida.']);
}
?>
