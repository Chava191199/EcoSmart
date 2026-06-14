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

        <a href="/EcoSmart/paginas/proyectos.php">
            🚀 Proyectos
        </a>

        <?php if(isset($_SESSION['usuario'])): ?>

            <!-- MENÚ CONSUMOS -->

            <div class="user-dropdown">

                <button
                type="button"
                class="user-btn"
                id="consumoBtn">

                    ⚡ Consumos

                    <span class="arrow">
                        ▼
                    </span>

                </button>

                <div
                id="consumoMenu"
                class="user-menu">

                    <a href="/EcoSmart/paginas/consumo.php">
                        ⚡ Energía Eléctrica
                    </a>

                    <a href="/EcoSmart/paginas/consumo_agua.php">
                        💧 Consumo de Agua
                    </a>

                    <a href="/EcoSmart/paginas/consumo_gas.php">
                        ⛽ Consumo de Gas
                    </a>

                </div>

            </div>

            <?php

            $foto = "default.avif";

            if(
                isset($_SESSION['foto']) &&
                !empty($_SESSION['foto'])
            ){
                $foto = $_SESSION['foto'];
            }

            ?>

            <!-- MENÚ USUARIO -->

            <div class="user-dropdown">

                <button
                type="button"
                class="user-btn"
                id="userBtn">

                    <img
                    src="/EcoSmart/uploads/perfiles/<?php echo $foto; ?>"
                    alt="Perfil"
                    class="navbar-profile"
                    onerror="this.src='/EcoSmart/uploads/perfiles/default.avif';">

                    <span>

                        <?= htmlspecialchars($_SESSION['usuario']) ?>

                    </span>

                    <span class="arrow">
                        ▼
                    </span>

                </button>

                <div
                id="userMenu"
                class="user-menu">

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

            <a
            href="/EcoSmart/auth/registro.php"
            class="register-btn">

                ✨ Registrarse

            </a>

        <?php endif; ?>

    </div>

</nav>

<script>

document.addEventListener(
    "DOMContentLoaded",
    function(){

        const userBtn =
        document.getElementById("userBtn");

        const userMenu =
        document.getElementById("userMenu");

        const consumoBtn =
        document.getElementById("consumoBtn");

        const consumoMenu =
        document.getElementById("consumoMenu");

        /* MENÚ USUARIO */

        if(userBtn && userMenu){

            userBtn.addEventListener(
                "click",
                function(e){

                    e.preventDefault();

                    e.stopPropagation();

                    userMenu.classList.toggle(
                        "show"
                    );

                    if(consumoMenu){

                        consumoMenu.classList.remove(
                            "show"
                        );

                    }

                }
            );

        }

        /* MENÚ CONSUMOS */

        if(consumoBtn && consumoMenu){

            consumoBtn.addEventListener(
                "click",
                function(e){

                    e.preventDefault();

                    e.stopPropagation();

                    consumoMenu.classList.toggle(
                        "show"
                    );

                    if(userMenu){

                        userMenu.classList.remove(
                            "show"
                        );

                    }

                }
            );

        }

        document.addEventListener(
            "click",
            function(){

                if(userMenu){

                    userMenu.classList.remove(
                        "show"
                    );

                }

                if(consumoMenu){

                    consumoMenu.classList.remove(
                        "show"
                    );

                }

            }
        );

    }
);

</script>