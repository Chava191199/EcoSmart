<?php

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

?>

<nav class="floating-navbar">

    <div class="logo">

        <a href="/EcoSmart/index.php">

            <img
            src="/EcoSmart/assets/img/logo.png"
            alt="EcoSmart"
            class="logo-img">

        </a>

        <span>EcoSmart</span>

    </div>

    <div class="nav-links">

        <a href="/EcoSmart/index.php">
            🏠 Inicio
        </a>

        <a href="/EcoSmart/index.php#informacion">
            📘 Información
        </a>

        <a href="/EcoSmart/index.php#campanas">
            🌱 Campañas
        </a>

        <a href="/EcoSmart/index.php#proyectos">
            🚀 Proyectos
        </a>

        <?php if(isset($_SESSION['usuario'])): ?>

            <div class="user-bubble">

                👤 <?= htmlspecialchars($_SESSION['usuario']) ?>

                <div class="user-menu">

                    <a href="/EcoSmart/perfil.php">
                        ⚙️ Mi Perfil
                    </a>

                    <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>

                        <a href="/EcoSmart/admin/dashboard.php">
                            📊 Dashboard
                        </a>

                        <a href="/EcoSmart/admin/usuarios.php">
                            👥 Usuarios
                        </a>

                    <?php endif; ?>

                    <a href="/EcoSmart/auth/logout.php">
                        🚪 Cerrar Sesión
                    </a>

                </div>

            </div>

        <?php else: ?>

            <a href="/EcoSmart/auth/login.php">
                🔐 Iniciar Sesión
            </a>

            <a href="/EcoSmart/auth/registro.php" class="register-btn">
                ✨ Registrarse
            </a>

        <?php endif; ?>

    </div>

</nav>