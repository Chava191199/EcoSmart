<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="container py-4">
    <div class="section-box">
        <h1>📰 Noticias Ambientales</h1>
        <hr>
        <p>Visualiza las noticias ambientales más recientes.</p>
        <!-- Aquí tu listado de noticias -->
        <div class="row">
            <?php for($i=1; $i<=3; $i++): ?>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Noticia #<?= $i ?></h5>
                        <p class="card-text">Descripción de la noticia ambiental...</p>
                        <a href="#" class="btn btn-sm btn-primary">Leer más</a>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>