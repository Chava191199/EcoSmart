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
            alt="EcoSmart Logo">


        <p>
            🌱 Tecnología sostenible para el ODS 13: Acción por el Clima
        </p>

        <?php if(!isset($_SESSION['usuario'])): ?>

            <a href="/EcoSmart/auth/login.php" class="hero-btn">
                🔐 Iniciar Sesión
            </a>

            <p style="margin-top:10px; opacity:0.8;">
                Accede para monitorear tu consumo y contribuir al cuidado del medio ambiente.
            </p>

        <?php else: ?>

            <div class="alert alert-success mt-3">

                <h4>
                    👋 Bienvenido,
                    <?= htmlspecialchars($_SESSION['usuario']) ?>
                </h4>

                <p class="mb-0">
                    Ya puedes registrar y monitorear tu consumo de agua, gas y energía.
                </p>

            </div>

        <?php endif; ?>

    </div>

</section>

<div class="container">

    <!-- ================= ¿QUÉ ES ECOSMART? ================= -->

    <div class="section-box text-center">

        <h2>🌎 ¿Qué es EcoSmart Solutions?</h2>

        <hr>

        <p>
            EcoSmart Solutions es una plataforma tecnológica enfocada en
            <strong>medir, monitorear y reducir el consumo de recursos</strong>
            mediante herramientas digitales sostenibles.
        </p>

        <p>
            Nuestro objetivo es ayudar a las personas a adoptar hábitos más responsables
            mediante el seguimiento de sus consumos de agua, energía y gas.
        </p>

    </div>

    <!-- ================= FUNCIONALIDADES ================= -->

    <div class="section-box">

        <h2>⚡ ¿Qué puedes hacer aquí?</h2>

        <hr>

        <ul>
            <li>💧 Registrar consumo de agua</li>
            <li>🔥 Registrar consumo de gas</li>
            <li>⚡ Registrar consumo eléctrico</li>
            <li>📊 Consultar estadísticas de consumo</li>
            <li>🌱 Obtener consejos de ahorro</li>
            <li>♻️ Registrar actividades de reciclaje</li>
            <li>🏆 Participar en el ranking ecológico</li>
        </ul>

    </div>

    <!-- ================= BENEFICIOS ================= -->

    <div class="section-box text-center">

        <h2>📊 Beneficios de EcoSmart</h2>

        <hr>

        <div class="row">

            <div class="col-md-4">
                <div class="benefit-card">
                    <h4>💧 Agua</h4>
                    <p>
                        Controla tu consumo y detecta hábitos que pueden mejorarse.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="benefit-card">
                    <h4>⚡ Energía</h4>
                    <p>
                        Monitorea tu consumo eléctrico y reduce gastos innecesarios.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="benefit-card">
                    <h4>🔥 Gas</h4>
                    <p>
                        Lleva un control eficiente de tu consumo doméstico.
                    </p>
                </div>
            </div>

        </div>

    </div>


    <!-- ================= IMPACTO ================= -->

    <div class="section-box text-center">

        <h2>🌱 Impacto Ambiental</h2>

        <hr>

        <p>
            Cada dato que registras ayuda a generar conciencia sobre el uso responsable
            de los recursos naturales.
        </p>

        <p>
            Al monitorear tus consumos puedes identificar oportunidades de ahorro,
            reducir costos y contribuir a un futuro más sostenible.
        </p>

        <p style="font-size:20px;">
            🌍 <strong>Pequeñas acciones generan grandes cambios.</strong>
        </p>

    </div>

</div>

<?php include 'includes/footer.php'; ?>
