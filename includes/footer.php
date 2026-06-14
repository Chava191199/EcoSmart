<footer class="footer">

    <div class="container">

        <div class="row gy-4">

            <!-- LOGO Y DESCRIPCIÓN -->

            <div class="col-md-4">

                <img
                src="/EcoSmart/assets/img/logo.png"
                alt="EcoSmart"
                class="footer-logo">

                <h3>
                    EcoSmart Solutions
                </h3>

                <p>
                    Plataforma tecnológica enfocada en el ODS 13:
                    Acción por el Clima.
                </p>

            </div>

            <!-- NAVEGACIÓN -->

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
                        <a href="/EcoSmart/paginas/informacion.php">
                            📘 Información
                        </a>
                    </li>

                    <li>
                        <a href="/EcoSmart/paginas/proyectos.php">
                            🚀 Proyectos
                        </a>
                    </li>

                    <?php if(isset($_SESSION['usuario'])): ?>

                        <li>
                            <a href="/EcoSmart/paginas/consumo.php">
                                ⚡ Consumos
                            </a>
                        </li>

                    <?php endif; ?>

                </ul>

            </div>

            <!-- CONTACTO -->

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

            © 2026 EcoSmart Solutions |
            Todos los derechos reservados

        </div>

    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
