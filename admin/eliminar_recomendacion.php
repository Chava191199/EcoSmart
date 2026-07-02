<?php
session_start();
include "../config/conexion.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != "admin") {
    header("Location: ../index.php");
    exit();
}

/*==============================
VALIDAR ID
===============================*/

if (!isset($_GET['id'])) {
    header("Location: recomendaciones.php");
    exit();
}

$id = intval($_GET['id']);

/*==============================
ELIMINAR RECOMENDACIÓN
===============================*/

$sql = "DELETE FROM recomendaciones WHERE id=$id";

if (mysqli_query($conexion, $sql)) {
    header("Location: recomendaciones.php");
    exit();
} else {
    echo "Error al eliminar la recomendación.";
}
?>
