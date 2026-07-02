<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<nav class="floating-navbar">

    <!-- LOGO -->
    <div class="logo">
        <a href="/index.php" class="logo-link">
            <img src="/assets/img/logo.png" alt="EcoSmart" class="logo-img">
            <span>EcoSmart</span>
        </a>
    </div>

    <button id="menuToggle" class="menu-toggle">
        ☰
    </button>

    <!-- MENÚ -->
    <div class="nav-links">

        <a href="/index.php">
            🏠 Inicio
        </a>

        <a href="/noticias/Noticias.php">
            📘 Noticias
        </a>


        <?php if(isset($_SESSION['usuario'])): ?>

            <!-- MENÚ CONSUMOS -->
            <div class="user-dropdown">
                <button type="button" class="user-btn" id="consumoBtn">
                    ⚡ Consumos
                    <span class="arrow">▼</span>
                </button>

                <div id="consumoMenu" class="user-menu">
                    <a href="/paginas/consumo.php">
                        ⚡ Energía Eléctrica
                    </a>
                    <a href="/paginas/consumo_agua.php">
                        💧 Consumo de Agua
                    </a>
                    <a href="/paginas/consumo_gas.php">
                        ⛽ Consumo de Gas
                    </a>
                    <a href="/paginas/comparativas.php">
                        📊 Comparativas
                    </a>
                </div>
            </div>

            <?php
            $foto = "default.avif";
            if(isset($_SESSION['foto']) && !empty($_SESSION['foto'])){
                $foto = $_SESSION['foto'];
            }
            ?>

            <!-- MENÚ USUARIO -->
            <div class="user-dropdown">
                <button type="button" class="user-btn" id="userBtn">
                    <img src="/uploads/perfiles/<?php echo $foto; ?>" 
                         alt="Perfil" 
                         class="navbar-profile" 
                         onerror="this.src='/uploads/perfiles/default.avif';">
                    <span><?= htmlspecialchars($_SESSION['usuario']) ?></span>
                    <span class="arrow">▼</span>
                </button>

                <div id="userMenu" class="user-menu">
                    <a href="/perfil.php">
                        👤 Mi Perfil
                    </a>
                    <a href="/dashboard_usuario.php">
                        📜 Mi Historial
                    </a>
                    <a href="/paginas/registrar_reciclaje.php">
                        ♻️ Registrar Reciclaje
                    </a>
                    <a href="/top_usuarios.php">
                        🏆 Ranking Ecológico
                    </a>

                    <hr>

                    <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                        <a href="/admin/dashboard.php">
                            👑 Panel Admin
                        </a>
                        <a href="/admin/usuarios.php">
                            👥 Usuarios
                        </a>
                        <hr>
                    <?php endif; ?>

                    <a href="/auth/logout.php">
                        🚪 Cerrar Sesión
                    </a>
                </div>
            </div>

        <?php else: ?>

            <a href="/auth/registro.php" class="register-btn">
                ✨ Registrarse
            </a>

        <?php endif; ?>

    </div>

</nav>

<script>
document.addEventListener("DOMContentLoaded", function() {

    const userBtn = document.getElementById("userBtn");
    const userMenu = document.getElementById("userMenu");
    const consumoBtn = document.getElementById("consumoBtn");
    const consumoMenu = document.getElementById("consumoMenu");
    const menuToggle = document.getElementById("menuToggle");
    const navLinks = document.querySelector(".nav-links");

    // MENÚ USUARIO
    if(userBtn && userMenu) {
        userBtn.addEventListener("click", function(e) {
            e.preventDefault();
            e.stopPropagation();
            userMenu.classList.toggle("show");
            if(consumoMenu) {
                consumoMenu.classList.remove("show");
            }
        });
    }

    // MENÚ CONSUMOS
    if(consumoBtn && consumoMenu) {
        consumoBtn.addEventListener("click", function(e) {
            e.preventDefault();
            e.stopPropagation();
            consumoMenu.classList.toggle("show");
            if(userMenu) {
                userMenu.classList.remove("show");
            }
        });
    }

    // MENÚ HAMBURGUESA PARA MÓVIL
    if(menuToggle && navLinks) {
        menuToggle.addEventListener("click", function(e) {
            e.stopPropagation();
            navLinks.classList.toggle("active");
        });
    }

    // CERRAR MENÚS AL HACER CLICK FUERA
    document.addEventListener("click", function(e) {
        // Cerrar menú usuario
        if(userMenu && !userMenu.classList.contains('show')) {
            // No hacer nada si ya está cerrado
        }
        if(userMenu && userMenu.classList.contains('show')) {
            // Verificar si el click fue dentro del botón o menú
            if(!userBtn.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.remove("show");
            }
        }

        // Cerrar menú consumos
        if(consumoMenu && consumoMenu.classList.contains('show')) {
            if(!consumoBtn.contains(e.target) && !consumoMenu.contains(e.target)) {
                consumoMenu.classList.remove("show");
            }
        }

        // Cerrar menú hamburguesa
        if(navLinks && navLinks.classList.contains('active')) {
            if(!menuToggle.contains(e.target) && !navLinks.contains(e.target)) {
                navLinks.classList.remove('active');
            }
        }
    });

    // Cerrar menús al hacer scroll
    window.addEventListener("scroll", function() {
        if(userMenu && userMenu.classList.contains('show')) {
            userMenu.classList.remove('show');
        }
        if(consumoMenu && consumoMenu.classList.contains('show')) {
            consumoMenu.classList.remove('show');
        }
        if(navLinks && navLinks.classList.contains('active')) {
            navLinks.classList.remove('active');
        }
    });

});
</script>
