<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<nav class="floating-navbar">

    <!-- LOGO -->
    <div class="logo">

        <a href="/EcoSmart/index.php" class="logo-link">

            <img
                src="/EcoSmart/assets/img/logo.png"
                alt="EcoSmart"
                class="logo-img">

            <span>EcoSmart</span>

        </a>

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

            <a
                href="/EcoSmart/auth/registro.php"
                class="register-btn"
            >
                ✨ Registrarse
            </a>

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