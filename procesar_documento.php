<?php
ob_start(); // Prevenir cualquier salida accidental que rompa el JSON

require_once 'db.php';
require_once 'auth.php';

// Limpiar cualquier salida previa de los includes (espacios en blanco, etc)
if (ob_get_length()) ob_clean();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Si el archivo excede post_max_size, $_POST y $_FILES estarán vacíos
        if (empty($_FILES) && empty($_POST) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
            throw new Exception("El archivo excede el tamaño máximo permitido por el servidor (post_max_size).");
        }
        
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
            $uploadDir = 'uploads/';
            
            // Asegurar que la carpeta existe
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generar nombre temporal con timestamp
            $originalName = $_FILES['archivo']['name'];
            $tempName = time() . '_' . $originalName;
            $targetPath = $uploadDir . $tempName;
            
            $fileType = $_FILES['archivo']['type'];
            $fileSize = $_FILES['archivo']['size'];
            
            $descripcionCorta = isset($_POST['descripcion_corta']) ? $_POST['descripcion_corta'] : '';
            $descripcionLarga = isset($_POST['descripcion_larga']) ? $_POST['descripcion_larga'] : '';
            $userId = isset($_SESSION['id']) ? $_SESSION['id'] : 0;

            if ($userId == 0) {
                throw new Exception("Sesión de usuario no válida.");
            }

            if (move_uploaded_file($_FILES['archivo']['tmp_name'], $targetPath)) {
                DB::insert('documento', [
                    'nombre' => $originalName,
                    'nombre_temporal' => $tempName,
                    'ruta' => $targetPath,
                    'tipo' => $fileType,
                    'tamano' => $fileSize,
                    'descripcion_corta' => $descripcionCorta,
                    'descripcion_larga' => $descripcionLarga,
                    'descargas' => 0,
                    'fk_user_id' => $userId
                ]);

                echo json_encode(['status' => 'success', 'message' => 'Archivo subido y registrado con éxito.']);
            } else {
                throw new Exception("Error al mover el archivo al servidor. Verifica permisos en la carpeta uploads/");
            }
        } else {
            $errorCode = isset($_FILES['archivo']['error']) ? $_FILES['archivo']['error'] : 'Desconocido';
            throw new Exception("Error en la subida del archivo. Código de error PHP: " . $errorCode);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
}
ob_end_flush();
