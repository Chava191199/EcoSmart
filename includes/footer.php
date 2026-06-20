<footer class="footer">

    <div class="container">

        <div class="row gy-4">

            <!-- LOGO Y DESCRIPCIÓN -->
            <div class="col-md-4">

                <img
                    src="/EcoSmart/assets/img/logo.png"
                    alt="EcoSmart"
                    class="footer-logo">

                <h3>EcoSmart Solutions</h3>

                <p>
                    Plataforma tecnológica enfocada en el ODS 13:
                    Acción por el Clima.
                </p>

            </div>

            <!-- NAVEGACIÓN -->
            <div class="col-md-4">

                <h4>Navegación</h4>

                <ul class="footer-links">

                    <li>
                        <a href="/EcoSmart/index.php">🏠 Inicio</a>
                    </li>

                    <li>
                        <a href="/EcoSmart/paginas/Noticias.php">📘 Noticias</a>
                    </li>

                    <?php if (isset($_SESSION['usuario'])): ?>

                        <li>
                            <a href="/EcoSmart/paginas/funcionalidades.php">
                                ⚙️ Funcionalidades
                            </a>
                        </li>

                        <!-- DROPDOWN -->
                        <li class="dropdown-consumos">
                            <a href="#" class="dropdown-btn">
                                ⚡ Consumos ▾
                            </a>

                            <ul class="submenu-consumos">
                                <li>
                                    <a href="/EcoSmart/paginas/consumo.php">
                                        ⚡ Consumo Energético
                                    </a>
                                </li>

                                <li>
                                    <a href="/EcoSmart/paginas/consumo_agua.php">
                                        💧 Consumo de Agua
                                    </a>
                                </li>

                                <li>
                                    <a href="/EcoSmart/paginas/consumo_gas.php">
                                        🔥 Consumo de Gas
                                    </a>
                                </li>
                            </ul>
                        </li>

                    <?php endif; ?>

                </ul>

            </div>

            <!-- CONTACTO -->
            <div class="col-md-4">

                <h4>Contacto</h4>

                <p>📧 contacto@ecosmart.com</p>
                <p>📍 México</p>
                <p>🌐 EcoSmart Solutions</p>

            </div>

        </div>

        <hr class="footer-line">

        <div class="footer-copy">
            © 2026 EcoSmart Solutions | Todos los derechos reservados
        </div>

    </div>

</footer>