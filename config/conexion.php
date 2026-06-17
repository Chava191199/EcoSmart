<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "ecosmart_db";

$conexion = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configurar charset
$conexion->set_charset("utf8mb4");

?>