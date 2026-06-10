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
    "SELECT * FROM usuarios
     WHERE id='$id'"
);

$usuario = mysqli_fetch_assoc($query);

/* ==========================
   NIVEL ECOLÓGICO
========================== */

if($usuario['eco_puntos'] >= 1000){

    $nivel = "🌎 Eco Experto";

}elseif($usuario['eco_puntos'] >= 500){

    $nivel = "♻️ Eco Avanzado";

}else{

    $nivel = "🌱 Eco Inicial";
}

/* ==========================
   TOTAL RECICLAJES
========================== */

$consultaReciclajes = mysqli_query(
    $conexion,
    "SELECT COUNT(*) AS total
     FROM reciclaje
     WHERE usuario_id='$id'"
);

$totalReciclajes = mysqli_fetch_assoc(
    $consultaReciclajes
);

/* ==========================
   TOTAL KG RECICLADOS
========================== */

$consultaKg = mysqli_query(
    $conexion,
    "SELECT SUM(cantidad) AS total
     FROM reciclaje
     WHERE usuario_id='$id'"
);

$totalKg = mysqli_fetch_assoc(
    $consultaKg
);

include 'includes/header.php';
include 'includes/navbar.php';

?>

<div class="container mt-5 pt-5">

    <div class="section-box shadow p-4 bg-white rounded">

        <h2 class="mb-4">
            👤 Mi Perfil
        </h2>

        <hr>

        <div class="row align-items-center">

            <!-- FOTO -->

            <div class="col-md-4 text-center">

                <?php

                $foto = "default.png";

                if(
                    !empty($usuario['foto'])
                ){
                    $foto = $usuario['foto'];
                }

                ?>

                <img
                src="/EcoSmart/uploads/perfiles/<?php echo $foto; ?>"
                class="rounded-circle shadow"
                width="220"
                height="220"
                style="object-fit:cover;">

            </div>

            <!-- DATOS -->

            <div class="col-md-8">

                <h3>
                    <?= htmlspecialchars($usuario['nombre']) ?>
                </h3>

                <hr>

                <p>
                    <strong>📧 Correo:</strong>
                    <?= htmlspecialchars($usuario['correo']) ?>
                </p>

                <p>
                    <strong>📱 Teléfono:</strong>
                    <?= htmlspecialchars($usuario['telefono']) ?>
                </p>

                <p>
                    <strong>🏢 Tipo de Usuario:</strong>
                    <?= htmlspecialchars($usuario['tipo_usuario']) ?>
                </p>

                <p>
                    <strong>🔑 Rol:</strong>
                    <?= htmlspecialchars($usuario['rol']) ?>
                </p>

                <p>
                    <strong>📅 Fecha de Registro:</strong>
                    <?= $usuario['fecha_registro'] ?>
                </p>

                <hr>

                <p>
                    <strong>🌱 EcoPuntos:</strong>
                    <?= $usuario['eco_puntos'] ?>
                </p>

                <p>
                    <strong>🏆 Nivel:</strong>
                    <?= $nivel ?>
                </p>

                <p>
                    <strong>♻️ Reciclajes Realizados:</strong>
                    <?= $totalReciclajes['total'] ?>
                </p>

                <p>
                    <strong>📦 Total Reciclado:</strong>
                    <?= number_format($totalKg['total'] ?? 0, 2) ?>
                    kg
                </p>

                <hr>

                <a
                href="editar_perfil.php"
                class="btn btn-success">

                    ✏️ Editar Perfil

                </a>

                <a
                href="cambiar_password.php"
                class="btn btn-warning">

                    🔒 Cambiar Contraseña

                </a>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>