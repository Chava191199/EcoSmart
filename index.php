<!DOCTYPE html>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="#">
            🌱 EcoSmart Solutions
        </a>

        <button class="btn btn-light" onclick="toggleDarkMode()">
            🌙 Modo Oscuro
        </button>
    </div>
</nav>

<section class="hero">
    <h1 class="display-3 fw-bold">
        Acción por el Clima
    </h1>

    <p class="lead mt-4">
        Plataforma tecnológica sostenible basada en la ODS 13.
    </p>

    <a href="auth/login.php" class="btn btn-light btn-lg mt-4">
        Iniciar Sesión
    </a>
</section>

<section class="container py-5">
    <div class="row g-4">

        <div class="col-md-4">
            <div class="card shadow p-4 h-100">
                <h3>📱 App Móvil</h3>
                <p>
                    Monitorea consumo energético y hábitos ecológicos.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow p-4 h-100">
                <h3>🌐 PWA</h3>
                <p>
                    Acceso offline y desde cualquier navegador.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow p-4 h-100">
                <h3>🤖 IA Verde</h3>
                <p>
                    Recomendaciones inteligentes para reducir emisiones.
                </p>
            </div>
        </div>

    </div>
</section>

<script>
function toggleDarkMode(){
    document.body.classList.toggle('dark-mode');
}
</script>

</body>
</html>