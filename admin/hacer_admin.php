<?php

session_start();

include '../config/conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    exit('No autorizado');
}

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $conexion->prepare('UPDATE usuarios SET rol = ? WHERE id = ?');
    if ($stmt) {
        $rol = 'admin';
        $stmt->bind_param('si', $rol, $id);
        $stmt->execute();
        $stmt->close();
    }
}

header('Location: usuarios.php');
exit();
