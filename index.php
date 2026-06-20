<?php
session_start();

include 'includes/header.php';
include 'includes/navbar.php';
?>

<section id="inicio" class="hero">

    <div class="hero-content">

        <img
        src="/EcoSmart/assets/img/logo.png"
        class="hero-logo"
        alt="EcoSmart">

        <p>
            🌱 Tecnología sostenible para el ODS 13: Acción por el Clima
        </p>

        <?php if(!isset($_SESSION['usuario'])): ?>

            <a href="/EcoSmart/auth/login.php" class="hero-btn">
                🔐 Iniciar Sesión
            </a>

            <p style="margin-top:10px; opacity:0.8;">
                Accede para monitorear tu consumo y reducir tu impacto ambiental.
            </p>

        <?php else: ?>

            <div class="alert alert-info mt-3">

                <h4>
                    🧠 EcoSmart activo para:
                    <?= htmlspecialchars($_SESSION['usuario']) ?>
                </h4>

                <p class="mb-0">
                    Tu sistema ya puede analizar consumo de agua, gas y energía en tiempo real.
                </p>

            </div>

        <?php endif; ?>

    </div>

</section>

<div class="container">

    <div class="section-box text-center">

        <h2>🌎 ¿Qué es EcoSmart Solutions?</h2>

        <hr>

        <p>
            EcoSmart Solutions es una plataforma tecnológica enfocada en
            <strong>medir, analizar y reducir el consumo de recursos</strong>
            mediante herramientas digitales inteligentes.
        </p>

        <p>
            Integramos una web app, una PWA y un sistema de análisis de consumo
            para ayudarte a tomar decisiones más sostenibles en tu vida diaria.
        </p>

    </div>

    <div class="section-box">

        <h2>⚡ ¿Qué puedes hacer aquí?</h2>

        <hr>

        <ul>
            <li>💧 Registrar y analizar consumo de agua</li>
            <li>🔥 Controlar consumo de gas doméstico</li>
            <li>⚡ Monitorear consumo eléctrico</li>
            <li>🧠 Recibir recomendaciones inteligentes tipo IA</li>
        </ul>

    </div>

    <div class="section-box text-center">

        <h2>🌱 Impacto Ambiental</h2>

        <hr>

        <p>
            Cada dato que registras ayuda a crear conciencia sobre el uso responsable de recursos.
        </p>

        <p style="font-size:18px;">
            🌍 <strong>Pequeñas acciones generan grandes cambios</strong>
        </p>

    </div>

</div>

<?php include 'includes/footer.php'; ?>