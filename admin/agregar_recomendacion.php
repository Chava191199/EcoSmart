<?php
session_start();
include "../config/conexion.php";

/* =========================
   VALIDAR ADMIN
========================= */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== "admin") {
    header("Location: ../index.php");
    exit();
}

/* =========================
   GUARDAR
========================= */
if (isset($_POST['guardar'])) {

    $tipo = mysqli_real_escape_string($conexion, $_POST['tipo']);
    $min = floatval($_POST['consumo_min']);
    $max = floatval($_POST['consumo_max']);
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $desc = mysqli_real_escape_string($conexion, $_POST['descripcion']);

    if ($min <= $max) {

        mysqli_query($conexion, "
            INSERT INTO recomendaciones (tipo, consumo_min, consumo_max, titulo, descripcion, activa)
            VALUES ('$tipo', $min, $max, '$titulo', '$desc', 1)
        ");

        header("Location: recomendaciones.php");
        exit();
    } else {
        $error = "Rango inválido";
    }
}

/* =========================
   VISTA
========================= */
include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-5">

    <h2>➕ Agregar Recomendación</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">

        <select name="tipo" class="form-control mb-2">
            <option value="energia">⚡ Energía</option>
            <option value="agua">💧 Agua</option>
            <option value="gas">🔥 Gas</option>
        </select>

        <input type="number" name="consumo_min" class="form-control mb-2" placeholder="Min" required>
        <input type="number" name="consumo_max" class="form-control mb-2" placeholder="Max" required>

        <input type="text" name="titulo" class="form-control mb-2" placeholder="Título" required>

        <textarea name="descripcion" class="form-control mb-2" placeholder="Descripción"></textarea>

        <button class="btn btn-success" name="guardar">Guardar</button>
    </form>

</div>

<?php include "../includes/footer.php"; ?>
