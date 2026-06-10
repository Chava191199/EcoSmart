<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<nav class="floating-navbar">
<<<<<<< HEAD
<<<<<<< HEAD
    <div class="logo">
        <a href="/EcoSmart/index.php">
            <img src="/EcoSmart/assets/img/logo.png" alt="EcoSmart" class="logo-img">
        </a>
        <span>EcoSmart</span>
=======
=======
>>>>>>> d16accaee6fdfed3bff188c2af9ada5e147f7fbe

    <!-- LOGO -->
    <div class="logo">

        <a href="/EcoSmart/index.php" class="logo-link">

            <img
                src="/EcoSmart/assets/img/logo.png"
                alt="EcoSmart"
                class="logo-img">

            <span>EcoSmart</span>

        </a>

<<<<<<< HEAD
>>>>>>> 958b57f740c1e0d4acac0fae44ac8126ef55428c
=======
>>>>>>> d16accaee6fdfed3bff188c2af9ada5e147f7fbe
    </div>

    <!-- MENÚ -->
    <div class="nav-links">

        <a href="/EcoSmart/index.php">
            🏠 Inicio
        </a>

        <a href="/EcoSmart/paginas/informacion.php">
            📘 Información
        </a>

        <a href="/EcoSmart/paginas/campañas.php">
            🌱 Campañas
        </a>

        <a href="/EcoSmart/paginas/proyectos.php">
            🚀 Proyectos
        </a>

        <?php if(isset($_SESSION['usuario'])): ?>
<<<<<<< HEAD
<<<<<<< HEAD
            <div class="user-bubble">
                👤 <?= htmlspecialchars($_SESSION['usuario']) ?>

                <div class="user-menu">
                    <a href="/EcoSmart/perfil.php">⚙️ Mi Perfil</a>
=======
=======

            <?php

            $foto = "default.avif";

            if(
                isset($_SESSION['foto']) &&
                !empty($_SESSION['foto']) &&
                $_SESSION['foto'] != "NULL"
            ){
                $foto = $_SESSION['foto'];
            }

            ?>
>>>>>>> d16accaee6fdfed3bff188c2af9ada5e147f7fbe

            <div class="user-dropdown">

                <button
                    type="button"
                    class="user-btn"
                    onclick="toggleUserMenu(event)"
                >

                    <img
                        src="/EcoSmart/uploads/perfiles/<?php echo $foto; ?>"
                        alt="Perfil"
                        class="navbar-profile"
                        onerror="this.src='/EcoSmart/uploads/perfiles/default.avif';"
                    >

                    <span>
                        <?= htmlspecialchars($_SESSION['usuario']) ?>
                    </span>

                    <span class="arrow">
                        ▼
                    </span>

                </button>

                <div
                    id="userMenu"
                    class="user-menu"
                >

                    <a href="/EcoSmart/perfil.php">
                        ⚙️ Mi Perfil
                    </a>
<<<<<<< HEAD
>>>>>>> 958b57f740c1e0d4acac0fae44ac8126ef55428c
=======

                    <?php if(
                        isset($_SESSION['rol']) &&
                        $_SESSION['rol'] === 'admin'
                    ): ?>

                        <a href="/EcoSmart/admin/dashboard.php">
                            📊 Dashboard
                        </a>

                        <a href="/EcoSmart/admin/usuarios.php">
                            👥 Usuarios
                        </a>
>>>>>>> d16accaee6fdfed3bff188c2af9ada5e147f7fbe

                    <?php endif; ?>

                    <a href="/EcoSmart/auth/logout.php">
                        🚪 Cerrar Sesión
                    </a>

                </div>

            </div>

        <?php else: ?>
<<<<<<< HEAD
<<<<<<< HEAD
            <a href="/EcoSmart/auth/login.php">🔐 Iniciar Sesión</a>
            <a href="/EcoSmart/auth/registro.php" class="register-btn">✨ Registrarse</a>
=======
=======
>>>>>>> d16accaee6fdfed3bff188c2af9ada5e147f7fbe

            <a href="/EcoSmart/auth/login.php">
                🔐 Iniciar Sesión
            </a>

            <a
                href="/EcoSmart/auth/registro.php"
                class="register-btn"
            >
                ✨ Registrarse
            </a>

<<<<<<< HEAD
>>>>>>> 958b57f740c1e0d4acac0fae44ac8126ef55428c
=======
>>>>>>> d16accaee6fdfed3bff188c2af9ada5e147f7fbe
        <?php endif; ?>

    </div>

</nav>

<script>

function toggleUserMenu(event){

    event.stopPropagation();

    const menu =
    document.getElementById("userMenu");

    if(menu){

        menu.classList.toggle("show");

    }
}

document.addEventListener(
    "click",
    function(){

        const menu =
        document.getElementById("userMenu");

        if(menu){

            menu.classList.remove("show");

        }

    }
);

const userBtn =
document.querySelector(".user-btn");

if(userBtn){

    userBtn.addEventListener(
        "click",
        function(event){

            event.stopPropagation();

        }
    );
}

</script>