<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<div class="container py-4">
    <div class="section-box">
        <h1>🌍 Cambio Climático</h1>
        <hr>
        <div class="row">
            <div class="col-md-8">
                <h3>Información sobre sostenibilidad</h3>
                <p>Aquí encontrarás información actualizada sobre el cambio climático, acciones para reducir tu huella de carbono y consejos para un estilo de vida más sostenible.</p>
                <!-- Tu contenido aquí -->
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>📊 Tu impacto</h5>
                        <p>Mide tu huella de carbono</p>
                        <a href="#" class="btn btn-success">Calcular ahora</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
