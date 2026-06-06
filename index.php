<?php
session_start();
include 'includes/header.php';
include 'includes/navbar.php';
?>

<section id="inicio" class="hero">
    <div>
        <img src="/EcoSmart/assets/img/logo.png" class="hero-logo" alt="EcoSmart">
        <h1>EcoSmart Solutions</h1>
        <p>Tecnología sostenible para la ODS 13: Acción por el Clima</p>
        
        <?php if(!isset($_SESSION['usuario'])): ?>
            <a href="/EcoSmart/auth/login.php">
                <button class="hero-btn">Comenzar</button>
            </a>
        <?php else: ?>
            <a href="/EcoSmart/perfil.php">
                <button class="hero-btn">Mi Perfil</button>
            </a>
        <?php endif; ?>
    </div>
</section>

<div class="container">
    <div class="section-box text-center">
        <h2>🌎 Bienvenido a EcoSmart Solutions</h2>
        <hr>
        <p>
            EcoSmart Solutions es una empresa tecnológica enfocada en el desarrollo de soluciones digitales sostenibles 
            que contribuyen al cumplimiento del Objetivo de Desarrollo Sostenible (ODS) 13: Acción por el Clima.
        </p>
        <p>
            Nuestra plataforma integra una aplicación móvil, una aplicación web progresiva (PWA) y un sistema inteligente 
            que ayuda a personas y empresas a monitorear y reducir su impacto ambiental.
        </p>
        
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>