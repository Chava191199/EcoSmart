<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
include __DIR__ . '/../config/conexion.php';

// CONSULTA A LA BD
$sql = "SELECT * FROM funcionalidades";
$resultado = $conexion->query($sql);
?>

<section class="page-header">
    <div class="container text-center">
        <h1>⚙️ Funcionalidades</h1>
        <p>Descubre todo lo que puedes hacer con EcoSmart</p>
    </div>
</section>

<div class="container">

    <section>
        <div class="section-box">
            <h2>🌿 Funcionalidades del sistema</h2>
            <hr>

            <div class="content-grid">

                <?php while($fila = $resultado->fetch_assoc()): ?>

                    <div class="card-custom">

                        <div class="card-icon">
                            <?= $fila['icono'] ?>
                        </div>

                        <h3>
                            <?= $fila['titulo'] ?>
                        </h3>

                        <p>
                            <?= $fila['descripcion'] ?>
                        </p>

                    </div>

                <?php endwhile; ?>

            </div>

        </div>
    </section>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>