<?php
session_start();
include __DIR__ . '/../config/conexion.php';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

$noticias = mysqli_query($conexion, "SELECT * FROM noticias ORDER BY fecha DESC");
?>

<section class="page-header">
    <div class="container text-center">
        <h1>📘 Noticias</h1>
        <p>Conoce más sobre EcoSmart Solutions</p>

        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
            <a href="agregar_noticia.php" class="btn btn-success">
                ➕ Agregar Noticia
            </a>
        <?php endif; ?>

    </div>
</section>

<div class="container">

    <?php while ($n = mysqli_fetch_assoc($noticias)): ?>

        <div class="section-box">

            <h2><?= $n['titulo'] ?></h2>
            <hr>

            <?php if ($n['imagen']): ?>
                <img src="/EcoSmart/assets/img/noticias/<?= $n['imagen'] ?>"
                     style="max-width:100%; border-radius:10px;">
            <?php endif; ?>

            <p><?= $n['contenido'] ?></p>

            <small>📅 <?= $n['fecha'] ?></small>

        </div>

    <?php endwhile; ?>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
?>