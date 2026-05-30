<?php

session_start();

include 'includes/header.php';
include 'includes/navbar.php';

?>

<section class="hero">

    <div>

        <img
        src="/EcoSmart/assets/img/logo.png"
        class="hero-logo"
        alt="EcoSmart">

        <h1>EcoSmart Solutions</h1>

        <p>
            Tecnología sostenible para la
            ODS 13: Acción por el Clima
        </p>

        <?php if(!isset($_SESSION['usuario'])): ?>

            <a href="/EcoSmart/auth/login.php">
                <button class="hero-btn">
                    Comenzar
                </button>
            </a>

        <?php else: ?>

            <a href="/EcoSmart/perfil.php">
                <button class="hero-btn">
                    Mi Perfil
                </button>
            </a>

        <?php endif; ?>

    </div>

</section>

<div class="container">

<section id="informacion">

<div class="section-box">

<h2>📘 Resumen Ejecutivo</h2>

<hr>

<p>
EcoSmart Solutions es una empresa tecnológica enfocada en el desarrollo de soluciones digitales sostenibles que contribuyan al cumplimiento de la ODS 13: Acción por el Clima.
</p>

<p>
La plataforma integra una aplicación móvil, una aplicación web progresiva (PWA) y un sistema inteligente que ayuda a personas y empresas a monitorear y reducir su impacto ambiental.
</p>

<p>
Los usuarios podrán registrar consumo energético, emisiones de carbono, reciclaje y hábitos sostenibles, recibiendo recomendaciones mediante inteligencia artificial y reportes ecológicos en tiempo real.
</p>

</div>

</section>

<section>

<div class="section-box">

<h2>⚠️ Problemática</h2>

<hr>

<p>
El cambio climático representa uno de los desafíos más importantes de la actualidad.
</p>

<p>
Muchas personas y empresas desconocen el impacto ambiental que generan debido a la falta de herramientas tecnológicas accesibles para monitorear su consumo energético, emisiones de carbono y hábitos ecológicos.
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

<p>
Monitoreo inteligente del consumo energético.
</p>

</div>

</div>

<div class="col-md-4">

<div class="card-custom">

<h3>🌍 Medio Ambiente</h3>

<p>
Reducción de emisiones contaminantes.
</p>

</div>

</div>

<div class="col-md-4">

<div class="card-custom">

<h3>🤖 Inteligencia Artificial</h3>

<p>
Recomendaciones ecológicas personalizadas.
</p>

</div>

</div>

</div>

</div>

</section>

<section>

<div class="section-box">

<h2>🎯 Mercado Meta</h2>

<hr>

<div class="row">

<div class="col-md-6">

<div class="card-custom">

<h3>👤 Usuarios Individuales</h3>

<ul>
<li>18 a 40 años</li>
<li>Interés en tecnología</li>
<li>Interés en sostenibilidad</li>
<li>Residentes en México</li>
</ul>

</div>

</div>

<div class="col-md-6">

<div class="card-custom">

<h3>🏢 Empresas</h3>

<ul>
<li>Pequeñas empresas</li>
<li>Medianas empresas</li>
<li>Grandes corporativos</li>
<li>Instituciones educativas</li>
</ul>

</div>

</div>

</div>

</div>

</section>

<section id="campanas">

<div class="section-box">

<h2>🌱 Campañas Ambientales</h2>

<hr>

<div class="row g-4">

<div class="col-md-4">

<div class="card-custom">

<h3>♻️ Reciclaje Inteligente</h3>

<p>
Promover la correcta separación de residuos.
</p>

</div>

</div>

<div class="col-md-4">

<div class="card-custom">

<h3>⚡ Ahorro Energético</h3>

<p>
Reducir el consumo eléctrico mediante monitoreo.
</p>

</div>

</div>

<div class="col-md-4">

<div class="card-custom">

<h3>🌳 Reforestación</h3>

<p>
Participación en actividades ecológicas.
</p>

</div>

</div>

</div>

</div>

</section>

<section id="proyectos">

<div class="section-box">

<h2>🚀 Proyectos Relacionados</h2>

<hr>

<div class="row">

<div class="col-md-4">

<div class="card-custom">

<h3>📱 Aplicación Móvil</h3>

<p>
Aplicación para Android e iOS.
</p>

</div>

</div>

<div class="col-md-4">

<div class="card-custom">

<h3>🌐 Aplicación PWA</h3>

<p>
Acceso desde cualquier navegador.
</p>

</div>

</div>

<div class="col-md-4">

<div class="card-custom">

<h3>🤖 IA Verde</h3>

<p>
Asistente inteligente para hábitos sostenibles.
</p>

</div>

</div>

</div>

</div>

</section>

</div>

<?php include 'includes/footer.php'; ?>