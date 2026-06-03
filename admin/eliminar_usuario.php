<?php

session_start();

include '../config/conexion.php';

if($_SESSION['rol'] != 'admin'){
    exit();
}

$id = intval($_GET['id']);

mysqli_query(
    $conexion,
    "DELETE FROM usuarios WHERE id='$id'"
);

header("Location: usuarios.php");
exit();