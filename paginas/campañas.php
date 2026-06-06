<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<section class="page-header">
    <div class="container text-center">
        <h1>🌱 Campañas Ambientales</h1>
        <p>Únete a nuestras campañas y sé parte del cambio</p>
    </div>
</section>

<div class="container">
    <section>
        <div class="section-box">
            <h2>🌱 Nuestras Campañas</h2>
            <hr>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card-custom">
                        <h3>♻️ Reciclaje Inteligente</h3>
                        <p>Promover la correcta separación de residuos mediante tecnología inteligente.</p>
                        <br>
                        <strong>Meta:</strong> Reducir 50% de residuos mal clasificados
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-custom">
                        <h3>⚡ Ahorro Energético</h3>
                        <p>Reducir el consumo eléctrico mediante monitoreo y recomendaciones personalizadas.</p>
                        <br>
                        <strong>Meta:</strong> Ahorrar 1000 kWh por usuario
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-custom">
                        <h3>🌳 Reforestación</h3>
                        <p>Participación en actividades ecológicas y plantación de árboles.</p>
                        <br>
                        <strong>Meta:</strong> Plantar 10,000 árboles
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="section-box">
            <h2>📊 Próximas Actividades</h2>
            <hr>
            <ul>
                <li>📅 Taller de Reciclaje - 15 de Enero 2025</li>
                <li>📅 Día de Limpieza - 22 de Enero 2025</li>
                <li>📅 Webinar: Energías Renovables - 30 de Enero 2025</li>
            </ul>
        </div>
    </section>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>