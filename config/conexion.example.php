<?php
// Plantilla de conexion: copiar como config/conexion.php y completar los datos
const DB_HOST = 'localhost';
const DB_USER = 'tu_usuario';
const DB_PASS = 'tu_contraseña';
const DB_NAME = 'AGENCIA';
const DB_PORT = 3306;

// Los errores de MySQLi se lanzan como excepciones
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    $conexion->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    // El detalle va al log; al usuario solo se le muestra un mensaje general
    error_log('Error de conexion: ' . $e->getMessage());
    http_response_code(500);
    exit('No fue posible conectar con la base de datos. Revise la configuracion de conexion.');
}
