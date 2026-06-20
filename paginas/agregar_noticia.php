<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    echo "No autorizado";
    exit;
}
?>

<div class="container py-5">

    <div class="news-form-container">

        <div class="text-center mb-4">
            <h1 class="news-title">📰 Agregar Noticia</h1>
            <p class="news-subtitle">
                Publica información para los usuarios de EcoSmart
            </p>
        </div>

        <form action="guardar_noticia.php" method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label>Título</label>
                <input type="text"
                       name="titulo"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label>Contenido</label>
                <textarea name="contenido"
                          class="form-control"
                          rows="6"
                          required></textarea>
            </div>

            <div class="mb-4">
                <label>Imagen</label>
                <input type="file"
                       name="imagen"
                       class="form-control">
            </div>

            <button type="submit" class="btn-publicar">
                🚀 Publicar Noticia
            </button>

        </form>

    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>