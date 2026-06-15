<?php

session_start();

include '../config/conexion.php';

if(!isset($_SESSION['id'])){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_SESSION['id'];

if(isset($_POST['guardar'])){

    $material = $_POST['material'];

    $cantidad = $_POST['cantidad'];

    $puntos = $cantidad * 10;

    mysqli_query(

        $conexion,

        "INSERT INTO reciclaje(

            usuario_id,
            material,
            cantidad,
            puntos

        )

        VALUES(

            '$id',
            '$material',
            '$cantidad',
            '$puntos'

        )"

    );

    mysqli_query(

        $conexion,

        "UPDATE usuarios

        SET eco_puntos =
        eco_puntos + $puntos

        WHERE id='$id'"

    );

    $mensaje =
    "Reciclaje registrado correctamente";
}

include '../includes/header.php';
include '../includes/navbar.php';

?>

<div class="container mt-5">

<div class="card">

<div class="card-header bg-success text-white">

♻️ Registrar Reciclaje

</div>

<div class="card-body">

<?php if(isset($mensaje)): ?>

<div class="alert alert-success">

<?= $mensaje ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="mb-3">

<label>Material</label>

<select
name="material"
class="form-control">

<option>Plástico</option>
<option>Cartón</option>
<option>Vidrio</option>
<option>Metal</option>
<option>Papel</option>

</select>

</div>

<div class="mb-3">

<label>Cantidad (kg)</label>

<input
type="number"
step="0.1"
name="cantidad"
class="form-control"
required>

</div>

<button
name="guardar"
class="btn btn-success">

Guardar

</button>

</form>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>