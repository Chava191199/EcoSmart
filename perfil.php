<?php

session_start();

include 'config/conexion.php';

if(!isset($_SESSION['id'])){

    header("Location: auth/login.php");
    exit();

}

$id = $_SESSION['id'];

$query = mysqli_query(
    $conexion,
    "SELECT * FROM usuarios WHERE id='$id'"
);

$usuario = mysqli_fetch_assoc($query);

include 'includes/header.php';
include 'includes/navbar.php';

?>

<div class="container mt-5 pt-5">

    <div class="section-box">

        <h2>
            Mi Perfil
        </h2>

        <hr>

        <div class="row align-items-center">

            <div class="col-md-4 text-center">

                <img
                src="/EcoSmart/assets/img/logo.png"
                width="180"
                class="img-fluid">

            </div>

            <div class="col-md-8">

                <h3>
                    <?= htmlspecialchars($usuario['nombre']) ?>
                </h3>

                <p>
                    <strong>Correo:</strong>
                    <?= htmlspecialchars($usuario['correo']) ?>
                </p>

                <p>
                    <strong>Rol:</strong>
                    <?= htmlspecialchars($usuario['rol']) ?>
                </p>

                <p>
                    <strong>Fecha de registro:</strong>
                    <?= $usuario['fecha_registro'] ?>
                </p>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>