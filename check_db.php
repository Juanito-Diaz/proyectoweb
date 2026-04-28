<?php
require_once 'db.php';
try {
    $table = DB::query("SHOW TABLES LIKE 'usuario'");
    if (empty($table)) {
        echo "Table 'usuario' does not exist. Creating it...\n";
        DB::query("CREATE TABLE usuario (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )");
        DB::insert('usuario', [
            'username' => 'admin',
            'password' => 'admin'
        ]);
        echo "Table created and user 'admin'/'admin' inserted.\n";
    } else {
        echo "Table 'usuario' exists.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
