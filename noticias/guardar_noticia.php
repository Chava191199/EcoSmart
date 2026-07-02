<?php
session_start();
include __DIR__ . '/../config/conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    exit("No autorizado");
}

// Obtener y limpiar entradas
$titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
$contenido = isset($_POST['contenido']) ? trim($_POST['contenido']) : '';

$imagen = '';

if (!empty($_FILES['imagen']['name'])) {

    $permitidos = ['jpg','jpeg','png','webp','avif'];
    $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));

    if (in_array($extension, $permitidos) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {

        if (!is_dir(__DIR__ . '/../assets/img/noticias')) {
            mkdir(__DIR__ . '/../assets/img/noticias', 0755, true);
        }

        $nombreImg = time() . "_" . preg_replace('/[^A-Za-z0-9_.-]/', '_', $_FILES['imagen']['name']);
        $ruta = __DIR__ . "/../assets/img/noticias/" . $nombreImg;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
            $imagen = $nombreImg;
        }
    }
}

// Insertar usando sentencia preparada
$stmt = $conexion->prepare("INSERT INTO noticias (titulo, contenido, imagen) VALUES (?, ?, ?)");
if ($stmt) {
    $stmt->bind_param('sss', $titulo, $contenido, $imagen);
    $stmt->execute();
    $stmt->close();
}

header('Location: Noticias.php');
exit;
