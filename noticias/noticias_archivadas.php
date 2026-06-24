<?php
session_start();

include __DIR__ . '/../config/conexion.php';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

$noticias = mysqli_query(
    $conexion,
    "SELECT * FROM noticias
     WHERE estado='archivada'
     ORDER BY fecha DESC"
);
?>

<section class="page-header">
    <div class="container text-center">

        <h1>📦 Noticias Archivadas</h1>
        <p>Historial de noticias EcoSmart</p>

        <a href="Noticias.php" class="btn btn-primary">
            ⬅ Volver
        </a>

    </div>
</section>

<div class="container">

<?php while($n = mysqli_fetch_assoc($noticias)): ?>

    <div class="section-box">

        <h2><?= htmlspecialchars($n['titulo']) ?></h2>

        <hr>

        <?php if(!empty($n['imagen'])): ?>
            <img src="/EcoSmart/assets/img/noticias/<?= $n['imagen'] ?>"
                 style="max-width:100%; border-radius:10px;">
        <?php endif; ?>

        <p><?= nl2br(htmlspecialchars($n['contenido'])) ?></p>

        <small>
            📅 <?= $n['fecha'] ?>
            | 📦 Archivada
        </small>

        <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>

            <div class="acciones-admin">

                <a href="restaurar_noticia.php?id=<?= $n['id'] ?>"
                   class="btn-restaurar">
                    ♻ Restaurar
                </a>

                <a href="eliminar_noticias.php?id=<?= $n['id'] ?>"
                   class="btn-eliminar"
                   onclick="return confirm('¿Eliminar noticia definitivamente?')">
                    🗑 Eliminar
                </a>

            </div>

        <?php endif; ?>

    </div>

<?php endwhile; ?>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>