<?php
session_start();
include __DIR__ . '/../config/conexion.php';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

/* =========================
   SOLO NOTICIAS ACTIVAS
========================= */
$noticias = mysqli_query(
    $conexion,
    "SELECT * FROM noticias WHERE estado='activa' ORDER BY fecha DESC"
);

$hayNoticias = mysqli_num_rows($noticias);
?>

<section class="page-header">
    <div class="container text-center">
        <h1>📘 Noticias</h1>
        <p>Conoce más sobre EcoSmart Solutions</p>

        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>

        <div class="d-flex gap-2 justify-content-center flex-wrap mt-3">

            <a href="agregar_noticia.php" class="btn btn-success">
                ➕ Agregar Noticia
            </a>

            <a href="administrar_noticias.php" class="btn btn-warning">
                📦 Archivar Noticias
            </a>

            <a href="eliminar_noticias.php" class="btn btn-danger">
                🗑 Eliminar Noticias
            </a>

        </div>

        <?php endif; ?>

    </div>
</section>

<div class="container">

    <?php if ($hayNoticias > 0): ?>

        <?php while ($n = mysqli_fetch_assoc($noticias)): ?>

            <div class="section-box">

                <h2><?= htmlspecialchars($n['titulo']) ?></h2>
                <hr>

                <?php if (!empty($n['imagen'])): ?>
                    <img src="/EcoSmart/assets/img/noticias/<?= $n['imagen'] ?>"
                         style="max-width:100%; border-radius:10px;">
                <?php endif; ?>

                <p><?= nl2br(htmlspecialchars($n['contenido'])) ?></p>

                <small>📅 <?= $n['fecha'] ?></small>

            </div>

        <?php endwhile; ?>

    <?php else: ?>

        <div class="alert alert-info text-center mt-4">
            📭 No hay noticias disponibles en este momento.
        </div>

        <script>
            // opcional: recarga suave
            setTimeout(() => {
                window.location.href = "Noticias.php";
            }, 2000);
        </script>

    <?php endif; ?>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>