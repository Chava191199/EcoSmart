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
                <label>Contenido (Soporta Markdown)</label>
                <textarea name="contenido"
                          class="form-control"
                          rows="6"
                          placeholder="# Título&#10;## Subtítulo&#10;**texto en negrita**&#10;*texto en itálica*&#10;- item de lista&#10;[enlace](https://ejemplo.com)"
                          required></textarea>
                
                <small class="form-text text-muted d-block mt-2">
                    <strong>Comandos Markdown:</strong><br>
                    • <code># Título</code> - Encabezado H1<br>
                    • <code>## Subtítulo</code> - Encabezado H2<br>
                    • <code>### Subsubtítulo</code> - Encabezado H3<br>
                    • <code>**texto**</code> - Negrita<br>
                    • <code>*texto*</code> - Itálica<br>
                    • <code>- item</code> - Lista de puntos<br>
                    • <code>[texto](url)</code> - Enlace<br>
                    • <code>\`código\`</code> - Código inline<br>
                    • <code>```código```</code> - Bloque de código<br>
                    • <code>> cita</code> - Cita/Blockquote
                </small>
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
