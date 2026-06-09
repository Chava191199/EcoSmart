<footer class="footer">

    <div class="container">

        <div class="row gy-4">

            <div class="col-md-4">

                <img
                src="/EcoSmart/assets/img/logo.png"
                alt="EcoSmart"
                class="footer-logo">

                <h3>
                    EcoSmart Solutions
                </h3>

                <p>
                    Plataforma tecnológica enfocada en la ODS 13:
                    Acción por el Clima.
                </p>

            </div>

            <div class="col-md-4">

                <h4>
                    Navegación
                </h4>

                <ul class="footer-links">

                    <li>
                        <a href="/EcoSmart/index.php">
                            🏠 Inicio
                        </a>
                    </li>

                    <li>
                        <a href="/EcoSmart/index.php#informacion">
                            📘 Información
                        </a>
                    </li>

                    <li>
                        <a href="/EcoSmart/index.php#campanas">
                            🌱 Campañas
                        </a>
                    </li>

                    <li>
                        <a href="/EcoSmart/index.php#proyectos">
                            🚀 Proyectos
                        </a>
                    </li>

                </ul>

            </div>

            <div class="col-md-4">

                <h4>
                    Contacto
                </h4>

                <p>
                    📧 contacto@ecosmart.com
                </p>

                <p>
                    📍 México
                </p>

                <p>
                    🌐 EcoSmart Solutions
                </p>

            </div>

        </div>

        <hr class="footer-line">

        <div class="footer-copy">

            © 2026 EcoSmart Solutions | Todos los derechos reservados

        </div>

    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

/* ==========================
   MENÚ DESPLEGABLE USUARIO
========================== */

function toggleUserMenu(event){

    event.stopPropagation();

    const menu =
    document.getElementById("userMenu");

    if(menu){

        menu.classList.toggle("show");

    }

}

/* Evita que el menú se cierre
   al hacer clic dentro de él */

document.addEventListener(
    "DOMContentLoaded",
    function(){

        const menu =
        document.getElementById("userMenu");

        if(menu){

            menu.addEventListener(
                "click",
                function(event){

                    event.stopPropagation();

                }
            );

        }

    }
);

/* Cerrar menú al hacer clic fuera */

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

</script>

</body>
</html>