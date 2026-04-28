<?php
require_once 'db.php';
try {
    $table = DB::query("SHOW TABLES LIKE 'documento'");
    if (empty($table)) {
        echo "Table 'documento' does not exist. Creating it...\n";
        DB::query("CREATE TABLE documento (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            nombre varchar(255) NOT NULL,
            nombre_temporal varchar(255) NOT NULL,
            ruta varchar(255) NOT NULL,
            tipo varchar(100) NOT NULL,
            tamano int(11) NOT NULL,
            descripcion_corta varchar(255),
            descripcion_larga text,
            descargas int(11) DEFAULT 0,
            created datetime DEFAULT CURRENT_TIMESTAMP,
            updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            fk_user_id int(11) NOT NULL,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        echo "Table 'documento' created successfully.\n";
    } else {
        echo "Table 'documento' already exists.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
