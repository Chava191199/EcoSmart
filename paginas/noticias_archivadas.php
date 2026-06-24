<?php
session_start();

include __DIR__ . '/../config/conexion.php';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

<<<<<<< HEAD
/* =========================
   SOLO NOTICIAS ARCHIVADAS
========================= */

$noticias = mysqli_query(
    $conexion,
    "SELECT * FROM noticias 
     WHERE estado='archivada' 
     ORDER BY fecha DESC"
);

if (!$noticias) {
    die("Error SQL: " . mysqli_error($conexion));
}

$hayNoticias = mysqli_num_rows($noticias);
?>

<style>
    .archive-header {
        background: linear-gradient(135deg, #1f2937, #111827);
        color: white;
        padding: 60px 20px;
        border-radius: 0 0 20px 20px;
        margin-bottom: 30px;
    }

    .news-card {
        background: #fff;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }

    .news-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #111827;
    }

    .news-img {
        width: 100%;
        max-height: 350px;
        object-fit: cover;
        border-radius: 12px;
        margin: 15px 0;
    }

    .news-date {
        font-size: 0.9rem;
        color: #6b7280;
    }

    .empty-box {
        background: #f3f4f6;
        padding: 40px;
        border-radius: 15px;
        text-align: center;
        color: #6b7280;
    }
</style>

<section class="archive-header text-center">
    <div class="container">
        <h1>📦 Noticias Archivadas</h1>
        <p>Historial completo de noticias guardadas en EcoSmart Solutions</p>
=======
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

>>>>>>> a2183c73e91a1f9f9300cf76c5adb45a4c0d1124
    </div>
</section>

<div class="container">

<<<<<<< HEAD
    <?php if ($hayNoticias > 0): ?>

        <?php while ($n = mysqli_fetch_assoc($noticias)): ?>

            <div class="news-card">

                <div class="news-title">
                    <?= htmlspecialchars($n['titulo']) ?>
                </div>

                <div class="news-date mt-1">
                    📅 <?= date('d/m/Y H:i', strtotime($n['fecha'])) ?>
                </div>

                <?php if (!empty($n['imagen'])): ?>
                    <img class="news-img"
                         src="/EcoSmart/assets/img/noticias/<?= htmlspecialchars($n['imagen']) ?>"
                         alt="Imagen noticia">
                <?php endif; ?>

                <p class="mt-3">
                    <?= nl2br(htmlspecialchars($n['contenido'])) ?>
                </p>

            </div>

        <?php endwhile; ?>

    <?php else: ?>

        <div class="empty-box mt-4">
            📭 No hay noticias archivadas en este momento.
        </div>

    <?php endif; ?>
=======
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
>>>>>>> a2183c73e91a1f9f9300cf76c5adb45a4c0d1124

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>