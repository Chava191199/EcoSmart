<?php
session_start();
include "../config/conexion.php";

/* VALIDAR */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== "admin") {
    header("Location: ../index.php");
    exit();
}

$id = intval($_GET['id']);

/* ACTUALIZAR */
if (isset($_POST['actualizar'])) {

    $tipo = mysqli_real_escape_string($conexion, $_POST['tipo']);
    $min = floatval($_POST['consumo_min']);
    $max = floatval($_POST['consumo_max']);
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $desc = mysqli_real_escape_string($conexion, $_POST['descripcion']);

    if ($min <= $max) {

        mysqli_query($conexion, "
            UPDATE recomendaciones SET
            tipo='$tipo',
            consumo_min=$min,
            consumo_max=$max,
            titulo='$titulo',
            descripcion='$desc'
            WHERE id=$id
        ");

        header("Location: recomendaciones.php");
        exit();
    }
}

/* CONSULTA */
$data = mysqli_fetch_assoc(
    mysqli_query($conexion, "SELECT * FROM recomendaciones WHERE id=$id")
);

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-5">

<h2>✏ Editar</h2>

<form method="POST">

<select name="tipo" class="form-control mb-2">
    <option value="energia" <?= $data['tipo']=='energia'?'selected':'' ?>>⚡ Energía</option>
    <option value="agua" <?= $data['tipo']=='agua'?'selected':'' ?>>💧 Agua</option>
    <option value="gas" <?= $data['tipo']=='gas'?'selected':'' ?>>🔥 Gas</option>
</select>

<input type="number" name="consumo_min" value="<?= $data['consumo_min'] ?>" class="form-control mb-2">

<input type="number" name="consumo_max" value="<?= $data['consumo_max'] ?>" class="form-control mb-2">

<input type="text" name="titulo" value="<?= $data['titulo'] ?>" class="form-control mb-2">

<textarea name="descripcion" class="form-control mb-2"><?= $data['descripcion'] ?></textarea>

<button class="btn btn-primary" name="actualizar">Actualizar</button>

</form>

</div>

<?php include "../includes/footer.php"; ?>
