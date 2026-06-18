<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
include __DIR__ . '/../config/conexion.php';

// Verificar si el usuario está logueado
$usuario_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// CONSULTA A LA BD - Funcionalidades
$sql = "SELECT * FROM funcionalidades ORDER BY id ASC";
$resultado = $conexion->query($sql);

// Contar funcionalidades
$total_funcionalidades = $resultado->num_rows;

// Obtener funcionalidades destacadas (primeras 3)
$sql_destacadas = "SELECT * FROM funcionalidades LIMIT 3";
$destacadas = $conexion->query($sql_destacadas);
?>

<!-- Agregar Font Awesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- CSS externo -->
<link rel="stylesheet" href="../css/funcionalidades.css">

<section class="page-header">
    <div class="container text-center">
        <h1>⚙️ Funcionalidades</h1>
        <p>Descubre todo lo que puedes hacer con EcoSmart</p>
        <span class="badge-count"><?php echo $total_funcionalidades; ?> funcionalidades disponibles</span>
    </div>
</section>

<div class="container">

    <!-- ================= FUNCIONALIDADES DESTACADAS ================= -->
    <section>
        <div class="section-box">
            <h2>⭐ Funcionalidades Destacadas</h2>
            <hr>
            <div class="row">
                <?php while($dest = $destacadas->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card-destacada">
                            <div class="card-icon-destacada">
                                <?= $dest['icono'] ?>
                            </div>
                            <h3><?= $dest['titulo'] ?></h3>
                            <p><?= $dest['descripcion'] ?></p>
                            <span class="badge-destacada">⭐ Destacada</span>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- ================= TODAS LAS FUNCIONALIDADES ================= -->
    <section>
        <div class="section-box">
            <div class="header-funcionalidades">
                <h2>🌿 Todas las Funcionalidades</h2>
                <div class="search-container">
                    <input type="text" id="searchFuncionalidad" placeholder="🔍 Buscar funcionalidad..." class="search-input">
                    <select id="filterFuncionalidad" class="filter-select">
                        <option value="all">Todas</option>
                        <option value="energia">⚡ Energía</option>
                        <option value="agua">💧 Agua</option>
                        <option value="gas">⛽ Gas</option>
                        <option value="reciclaje">♻️ Reciclaje</option>
                        <option value="social">🌍 Social</option>
                    </select>
                </div>
            </div>
            <hr>

            <div class="content-grid" id="funcionalidadesGrid">

                <?php 
                // Resetear el puntero del resultado
                $resultado->data_seek(0);
                while($fila = $resultado->fetch_assoc()): 
                    $categoria = isset($fila['categoria']) ? $fila['categoria'] : 'general';
                ?>

                    <div class="card-custom" data-categoria="<?= $categoria ?>">
                        <div class="card-icon">
                            <?= $fila['icono'] ?>
                        </div>
                        <h3>
                            <?= $fila['titulo'] ?>
                        </h3>
                        <p>
                            <?= $fila['descripcion'] ?>
                        </p>
                        
                        <?php if(isset($fila['beneficio'])): ?>
                            <div class="beneficio">
                                <i class="fas fa-check-circle"></i>
                                <?= $fila['beneficio'] ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($usuario_id): ?>
                            <a href="#" class="btn-funcionalidad">Probar ahora →</a>
                        <?php endif; ?>
                    </div>

                <?php endwhile; ?>

            </div>

            <!-- Mensaje cuando no hay resultados -->
            <div id="noResultados" style="display:none;" class="text-center">
                <p style="font-size: 18px; color: #6c757d;">🔍 No se encontraron funcionalidades</p>
            </div>

        </div>
    </section>

    <!-- ================= ESTADÍSTICAS ================= -->
    <section>
        <div class="section-box">
            <h2>📊 Estadísticas de Uso</h2>
            <hr>
            <div class="row">
                <?php
                // Contar usuarios totales
                $query_usuarios = mysqli_query($conexion, "SELECT COUNT(*) as total FROM usuarios");
                $total_usuarios = mysqli_fetch_assoc($query_usuarios)['total'];
                
                // Contar registros de reciclaje
                $query_reciclaje = mysqli_query($conexion, "SELECT COUNT(*) as total FROM reciclaje");
                $total_reciclaje = mysqli_fetch_assoc($query_reciclaje)['total'];
                
                // Contar consumos
                $query_consumos = mysqli_query($conexion, "SELECT COUNT(*) as total FROM consumo_energetico");
                $total_consumos = mysqli_fetch_assoc($query_consumos)['total'];
                ?>
                
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon">👥</div>
                        <div class="stat-number"><?php echo number_format($total_usuarios); ?></div>
                        <div class="stat-label">Usuarios activos</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon">♻️</div>
                        <div class="stat-number"><?php echo number_format($total_reciclaje); ?></div>
                        <div class="stat-label">Reciclajes registrados</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon">⚡</div>
                        <div class="stat-number"><?php echo number_format($total_consumos); ?></div>
                        <div class="stat-label">Consumos registrados</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon">🌱</div>
                        <div class="stat-number"><?php echo number_format($total_funcionalidades); ?></div>
                        <div class="stat-label">Funcionalidades</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= PREGUNTAS FRECUENTES ================= -->
    <section>
        <div class="section-box">
            <h2>❓ Preguntas Frecuentes</h2>
            <hr>
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>¿Cómo puedo registrar mi consumo?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Puedes registrar tu consumo desde el menú "Consumos" en la barra de navegación. Selecciona el tipo de consumo (Energía, Agua o Gas) y completa el formulario con los datos correspondientes.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>¿Qué son los EcoPuntos?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Los EcoPuntos son puntos que obtienes por cada acción ecológica que realizas, como registrar reciclaje o reducir tu consumo. Puedes canjearlos por beneficios y recompensas.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>¿Cómo funciona el ranking ecológico?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>El ranking ecológico clasifica a los usuarios según sus EcoPuntos acumulados y su impacto ambiental. Mientras más acciones ecológicas realices, más alto estarás en el ranking.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>¿Puedo ver mi historial de consumos?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Sí, puedes ver tu historial completo en el "Dashboard" o en la sección "Mi Historial" del menú de usuario. Allí encontrarás todos tus registros de consumo y reciclaje.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= BOTÓN VOLVER ================= -->
    <div class="text-center mt-4 mb-5">
        <a href="../dashboard_usuario.php" class="btn-volver">← Volver al Dashboard</a>
    </div>
</div>

<script>
// ================= BUSCADOR Y FILTRO =================
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchFuncionalidad');
    const filterSelect = document.getElementById('filterFuncionalidad');
    const cards = document.querySelectorAll('.card-custom');
    const noResultados = document.getElementById('noResultados');

    function filtrarFuncionalidades() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const filterValue = filterSelect.value;
        let visibleCount = 0;

        cards.forEach(card => {
            const titulo = card.querySelector('h3').textContent.toLowerCase();
            const descripcion = card.querySelector('p').textContent.toLowerCase();
            const categoria = card.dataset.categoria || 'general';
            
            const matchesSearch = titulo.includes(searchTerm) || descripcion.includes(searchTerm);
            const matchesFilter = filterValue === 'all' || categoria === filterValue;
            
            if (matchesSearch && matchesFilter) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Mostrar mensaje si no hay resultados
        if (visibleCount === 0) {
            noResultados.style.display = 'block';
        } else {
            noResultados.style.display = 'none';
        }
    }

    searchInput.addEventListener('input', filtrarFuncionalidades);
    filterSelect.addEventListener('change', filtrarFuncionalidades);
});

// ================= FAQ TOGGLE =================
function toggleFAQ(element) {
    const item = element.parentElement;
    const answer = item.querySelector('.faq-answer');
    const icon = element.querySelector('.fa-chevron-down');
    
    // Cerrar otros items
    document.querySelectorAll('.faq-item').forEach(otherItem => {
        if (otherItem !== item) {
            otherItem.classList.remove('active');
            otherItem.querySelector('.faq-answer').style.display = 'none';
            otherItem.querySelector('.fa-chevron-down').style.transform = 'rotate(0deg)';
        }
    });
    
    // Toggle actual
    item.classList.toggle('active');
    if (item.classList.contains('active')) {
        answer.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
    } else {
        answer.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
    }
}

// ================= ANIMACIONES AL SCROLL =================
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card-custom, .card-destacada, .stat-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });
    
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(card);
    });
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>