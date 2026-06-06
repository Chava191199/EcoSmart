<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<section class="page-header">
    <div class="container text-center">
        <h1>🚀 Proyectos Relacionados</h1>
        <p>Descubre nuestras innovaciones tecnológicas</p>
    </div>
</section>

<div class="container">
    <section>
        <div class="section-box">
            <h2>🚀 Nuestros Proyectos</h2>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="card-custom">
                        <h3>📱 Aplicación Móvil</h3>
                        <p>Aplicación nativa para Android e iOS con monitoreo en tiempo real.</p>
                        <p><strong>Estado:</strong> 🟢 En desarrollo</p>
                        <p><strong>Lanzamiento:</strong> Marzo 2025</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-custom">
                        <h3>🌐 Aplicación PWA</h3>
                        <p>Acceso desde cualquier navegador web con funcionalidad offline.</p>
                        <p><strong>Estado:</strong> 🟡 Beta</p>
                        <p><strong>Lanzamiento:</strong> Febrero 2025</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="section-box">
            <h2>📈 Avance de Proyectos</h2>
            <hr>
            <div class="progress-bar-custom">
                <p>Aplicación Móvil: 75%</p>
                <div class="progress">
                    <div class="progress-bar bg-success" style="width:75%">75%</div>
                </div>
                <br>
                <p>Aplicación PWA: 85%</p>
                <div class="progress">
                    <div class="progress-bar bg-info" style="width:85%">85%</div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>