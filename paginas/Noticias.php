<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<section class="page-header">
    <div class="container text-center">
        <h1>📘 Noticias</h1>
        <p>Conoce más sobre EcoSmart Solutions y nuestra misión</p>
    </div>
</section>

<div class="container">
    <section>
        <div class="section-box">
            <h2>🌎 ¿Quiénes Somos?</h2>
            <hr>
            <p>
                EcoSmart Solutions es una empresa tecnológica enfocada en el desarrollo de soluciones digitales sostenibles que contribuyen al cumplimiento del Objetivo de Desarrollo Sostenible (ODS) 13: Acción por el Clima.
            </p>
            <p>
                Nuestra plataforma integra una aplicación móvil, una aplicación web progresiva (PWA) y un sistema inteligente que ayuda a personas y empresas a monitorear y reducir su impacto ambiental.
            </p>
        </div>
    </section>

    <section>
        <div class="section-box">
            <h2>⚠️ Problemática</h2>
            <hr>
            <p>
                El cambio climático representa uno de los desafíos más importantes de la actualidad. Muchas personas y empresas desconocen el impacto ambiental que generan debido a la falta de herramientas tecnológicas accesibles para monitorear su consumo energético, emisiones de carbono y hábitos ecológicos.
            </p>
            <p>
                Las soluciones existentes suelen ser costosas, limitadas o no están adaptadas al contexto mexicano.
            </p>
        </div>
    </section>

    <section>
        <div class="section-box">
            <h2>✅ Beneficios</h2>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="card-custom">
                        <h3>⚡ Energía</h3>
                        <p>Monitoreo inteligente del consumo energético.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-custom">
                        <h3>🌍 Medio Ambiente</h3>
                        <p>Reducción de emisiones contaminantes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>