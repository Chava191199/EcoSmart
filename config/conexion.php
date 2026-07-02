<?php

// Mostrar errores (temporal, activar solo para depuración)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Usar variables de entorno si están definidas (útil en hosting)
// Si no las defines, reemplaza los valores por los de tu cuenta InfinityFree.
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$database = getenv('DB_NAME') ?: 'ecosmart_db';

$conexion = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    // Registrar error y mostrar un mensaje genérico
    error_log('DB connection error: ' . $conexion->connect_error);
    die('Error de conexión a la base de datos. Revisa las credenciales en config/conexion.php');
}

// Configurar charset
$conexion->set_charset('utf8mb4');

?>
