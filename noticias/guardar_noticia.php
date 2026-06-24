<?php
session_start();
include __DIR__ . '/../config/conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    exit("No autorizado");
}

$titulo = $_POST['titulo'];
$contenido = $_POST['contenido'];

$imagen = null;

if (!empty($_FILES['imagen']['name'])) {

    $nombreImg = time() . "_" . $_FILES['imagen']['name'];
    $ruta = "../assets/img/noticias/" . $nombreImg;

    move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);

    $imagen = $nombreImg;
}

$sql = "INSERT INTO noticias (titulo, contenido, imagen)
        VALUES ('$titulo', '$contenido', '$imagen')";

mysqli_query($conexion, $sql);

header("Location: Noticias.php");
exit;