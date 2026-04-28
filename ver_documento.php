<?php
require_once 'db.php';
require_once 'auth.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Obtener la información del documento
    $doc = DB::queryFirstRow("SELECT * FROM documento WHERE id = %i", $id);
    
    if ($doc) {
        $ruta = $doc['ruta'];
        $nombre_original = $doc['nombre'];
        $tipo = $doc['tipo'];
        
        // Verificar si el archivo existe físicamente
        if (file_exists($ruta)) {
            // Incrementar contador de descargas
            DB::update('documento', [
                'descargas' => $doc['descargas'] + 1
            ], "id=%i", $id);
            
            // Forzar descarga
            header('Content-Description: File Transfer');
            header('Content-Type: ' . $tipo);
            header('Content-Disposition: inline; filename="' . basename($nombre_original) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($ruta));
            
            // Limpiar el búfer de salida para evitar caracteres extraños en el PDF
            if (ob_get_length()) ob_clean();
            flush();
            
            readfile($ruta);
            exit;
        } else {
            die("Error: El archivo físico no existe en el servidor.");
        }
    } else {
        die("Error: Documento no encontrado en la base de datos.");
    }
} else {
    die("Error: ID de documento no proporcionado.");
}
?>
