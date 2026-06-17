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
            Tecnología sostenible para la ODS 13:
            Acción por el Clima
        </p>

        <?php if(!isset($_SESSION['usuario'])): ?>

            <a
            href="/EcoSmart/auth/login.php"
            class="hero-btn">

                🔐 Iniciar Sesión

            </a>

        <?php endif; ?>

    </div>

</section>

<div class="container">

    <div class="section-box text-center">

        <h2>
            🌎 Bienvenido a EcoSmart Solutions
        </h2>

        <hr>

        <p>
            EcoSmart Solutions es una empresa tecnológica
            enfocada en el desarrollo de soluciones digitales
            sostenibles que contribuyen al cumplimiento del
            Objetivo de Desarrollo Sostenible (ODS) 13:
            Acción por el Clima.
        </p>

        <p>
            Nuestra plataforma integra una aplicación móvil,
            una aplicación web progresiva (PWA) y un sistema
            inteligente que ayuda a personas y empresas a
            monitorear y reducir su impacto ambiental.
        </p>

        <?php if(isset($_SESSION['usuario'])): ?>

            <div class="alert alert-success mt-4">

                <h4>
                    👋 Bienvenido,
                    <?= htmlspecialchars($_SESSION['usuario']) ?>
                </h4>

                <p class="mb-0">
                    Gracias por contribuir a un futuro más sostenible.
                </p>

            </div>

        <?php endif; ?>

    </div>

</div>

<?php include 'includes/footer.php'; ?>