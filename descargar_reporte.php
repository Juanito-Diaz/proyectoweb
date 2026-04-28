<?php
require_once 'auth.php';
require_once 'db.php';
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Obtener el tipo de reporte
$tipo = $_GET['tipo'] ?? '';

if ($tipo == 'clientes') {
    $filename = "Reporte_Clientes_" . date('Y-m-d') . ".pdf";
    $titulo = "REPORTE DE CLIENTES";
    $headers = ['ID', 'Nombre', 'Apellidos', 'RFC'];

    try {
        $data = DB::query("SELECT * FROM cliente");
    } catch (Exception $e) {
        die("Error al obtener datos de clientes: " . $e->getMessage());
    }
} elseif ($tipo == 'productos') {
    $filename = "Reporte_Productos_" . date('Y-m-d') . ".pdf";
    $titulo = "REPORTE DE PRODUCTOS";
    $headers = ['ID', 'Nombre', 'Cantidad', 'Precio', 'Categoría'];

    try {
        $data = DB::query("SELECT * FROM producto");
    } catch (Exception $e) {
        die("Error al obtener datos de productos: " . $e->getMessage());
    }
} else {
    die("Tipo de reporte no válido.");
}

// Construir el HTML para el PDF
$html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h2 { color: #333; margin-bottom: 5px; }
        .header p { color: #666; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 12px; }
        th { background-color: #f8f9fa; font-weight: bold; color: #333; }
        tr:nth-child(even) { background-color: #fcfcfc; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h2>' . $titulo . '</h2>
        <p>Generado el: ' . date('d/m/Y H:i') . '</p>
    </div>
    <table>
        <thead>
            <tr>';
foreach ($headers as $h) {
    $html .= '<th>' . $h . '</th>';
}
$html .= '  </tr>
        </thead>
        <tbody>';

foreach ($data as $row) {
    $html .= '<tr>';
    if ($tipo == 'clientes') {
        $html .= '<td>' . ($row['id'] ?? $row['ID'] ?? '') . '</td>';
        $html .= '<td>' . ($row['nombre'] ?? '') . '</td>';
        $html .= '<td>' . ($row['apellido_paterno'] ?? '') . ' ' . ($row['apellido_materno'] ?? '') . '</td>';
        $html .= '<td>' . ($row['rfc'] ?? '') . '</td>';
    } else {
        $id_prod = $row['ID'] ?? $row['id_producto'] ?? $row['id'] ?? '';
        $html .= '<td>' . $id_prod . '</td>';
        $html .= '<td>' . ($row['nombre'] ?? '') . '</td>';
        $html .= '<td>' . ($row['cantidad'] ?? 0) . '</td>';
        $html .= '<td>$' . number_format($row['precio'] ?? 0, 2) . '</td>';
        $html .= '<td>' . ($row['categoria'] ?? '') . '</td>';
    }
    $html .= '</tr>';
}

$html .= '
        </tbody>
    </table>
    <div class="footer">Página 1</div>
</body>
</html>';

// Configurar Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

// (Opcional) Configurar tamaño de papel
$dompdf->setPaper('A4', 'portrait');

// Renderizar el HTML como PDF
$dompdf->render();

// Salida al navegador
$dompdf->stream($filename, ["Attachment" => true]);
?>