<?php
session_start();
include __DIR__ . '/../config/conexion.php';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

$noticias = mysqli_query(
    $conexion,
    "SELECT * FROM noticias
     WHERE estado='activa'
     ORDER BY fecha DESC"
);

$hayNoticias = mysqli_num_rows($noticias);
?>

<section class="page-header">
    <div class="container text-center">

        <h1>📘 Noticias</h1>
        <p>Conoce más sobre EcoSmart Solutions</p>

        <div class="d-flex gap-2 justify-content-center flex-wrap mt-3">

            <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
                <a href="agregar_noticia.php" class="btn btn-success">
                    ➕ Agregar Noticia
                </a>
            <?php endif; ?>

            <a href="noticias_archivadas.php" class="btn btn-secondary">
                📦 Noticias Archivadas
            </a>

        </div>

    </div>
</section>

<div class="container">

<?php if($hayNoticias > 0): ?>

    <?php while($n = mysqli_fetch_assoc($noticias)): ?>

        <div class="section-box">

            <h2><?= htmlspecialchars($n['titulo']) ?></h2>

            <hr>

            <?php if(!empty($n['imagen'])): ?>
                <img src="/EcoSmart/assets/img/noticias/<?= $n['imagen'] ?>"
                     style="max-width:100%; border-radius:10px;">
            <?php endif; ?>

            <p><?= nl2br(htmlspecialchars($n['contenido'])) ?></p>

            <small>📅 <?= $n['fecha'] ?></small>

            <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>

                <div class="acciones-admin">

                    <a href="/EcoSmart/noticias/archivar_noticia.php?id=<?= $n['id'] ?>"
                       class="btn-archivar"
                       onclick="return confirm('¿Archivar noticia?')">
                        📦 Archivar
                    </a>

                    <a href="/EcoSmart/noticias/eliminar_noticias.php?id=<?= $n['id'] ?>"
                       class="btn-eliminar"
                       onclick="return confirm('¿Eliminar noticia?')">
                        🗑 Eliminar
                    </a>

                </div>

            <?php endif; ?>

        </div>

    <?php endwhile; ?>

<?php else: ?>

    <div class="alert alert-info text-center">
        📭 No hay noticias disponibles.
    </div>

<?php endif; ?>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>