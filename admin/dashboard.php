<?php
session_start();
include '../config/conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

/* ==========================
   ESTADÍSTICAS
========================== */

$totalUsuarios = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM usuarios"));
$totalAgua = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM consumo_agua"));
$totalGas = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM consumo_gas"));
$totalEnergia = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM consumo_energetico"));

/* ==========================
   SUMATORIAS
========================== */

$agua = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT IFNULL(SUM(consumo),0) total FROM consumo_agua"));
$gas = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT IFNULL(SUM(consumo),0) total FROM consumo_gas"));
$energia = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT IFNULL(SUM(consumo),0) total FROM consumo_energetico"));

$aguaTotal = $agua['total'];
$gasTotal = $gas['total'];
$energiaTotal = $energia['total'];

/* ==========================
   DATOS MENSUALES
========================== */

$aguaMeses = array_fill(0, 12, 0);
$gasMeses = array_fill(0, 12, 0);
$energiaMeses = array_fill(0, 12, 0);

/* Agua */
$qAgua = mysqli_query($conexion, "
SELECT MONTH(fecha) mes, SUM(consumo) total
FROM consumo_agua
GROUP BY MONTH(fecha)
");

while ($row = mysqli_fetch_assoc($qAgua)) {
    $aguaMeses[$row['mes'] - 1] = round($row['total'], 2);
}

/* Gas */
$qGas = mysqli_query($conexion, "
SELECT MONTH(fecha) mes, SUM(consumo) total
FROM consumo_gas
GROUP BY MONTH(fecha)
");

while ($row = mysqli_fetch_assoc($qGas)) {
    $gasMeses[$row['mes'] - 1] = round($row['total'], 2);
}

/* Energía */
$qEnergia = mysqli_query($conexion, "
SELECT MONTH(fecha) mes, SUM(consumo) total
FROM consumo_energetico
GROUP BY MONTH(fecha)
");

while ($row = mysqli_fetch_assoc($qEnergia)) {
    $energiaMeses[$row['mes'] - 1] = round($row['total'], 2);
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<!-- CSS para el panel administrativo -->
<style>
/* =====================================================
   DASHBOARD ADMIN - ESTILOS MEJORADOS
===================================================== */

/* ========== HEADER ========== */
.page-header {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    padding: 60px 0 40px;
    color: white;
    margin-bottom: 30px;
    border-radius: 0 0 30px 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.page-header h1 {
    font-size: 2.8rem;
    font-weight: 700;
    margin-bottom: 10px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.page-header p {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 0;
}

/* ========== TARJETAS ========== */
.dashboard-card {
    background: linear-gradient(135deg, #ffffff, #f8fff9);
    color: #2d3436;
    padding: 30px 20px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.10);
    transition: all 0.3s ease;
    height: 100%;
    border-left: 6px solid #198754;
}

.dashboard-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.18);
}

.dashboard-card h4 {
    font-weight: 600;
    margin-bottom: 15px;
    color: #2d3436;
}

.dashboard-card small {
    color: #6c757d;
    display: block;
    margin-top: 5px;
}

.dashboard-number {
    font-size: 50px;
    font-weight: 700;
    color: #198754;
    text-shadow: 2px 2px 8px rgba(25,135,84,0.15);
}

/* ========== GRÁFICOS MEJORADOS ========== */
.chart-wrapper {
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.10);
    margin-bottom: 30px;
    height: 100%;
    transition: all 0.3s ease;
    min-height: 350px;
}

.chart-wrapper:hover {
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    transform: translateY(-3px);
}

.chart-wrapper h5 {
    text-align: center;
    color: #2d3436;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f0f0f0;
}

.chart-container {
    position: relative;
    width: 100%;
    height: 280px;
}

.chart-container canvas {
    width: 100% !important;
    height: 100% !important;
}

/* ========== GRÁFICOS DE LÍNEA - TAMAÑO ESTANDARIZADO ========== */
.chart-wrapper-line {
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.10);
    margin-bottom: 30px;
    height: 100%;
    transition: all 0.3s ease;
    min-height: 320px;
}

.chart-wrapper-line:hover {
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    transform: translateY(-3px);
}

.chart-wrapper-line h5 {
    text-align: center;
    color: #2d3436;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f0f0f0;
}

.chart-container-line {
    position: relative;
    width: 100%;
    height: 250px;
}

.chart-container-line canvas {
    width: 100% !important;
    height: 100% !important;
}

/* ========== GRÁFICO DE PASTEL ========== */
.chart-wrapper-pie {
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.10);
    margin-bottom: 30px;
    height: 100%;
    transition: all 0.3s ease;
    min-height: 400px;
}

.chart-wrapper-pie:hover {
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    transform: translateY(-3px);
}

.chart-wrapper-pie h5 {
    text-align: center;
    color: #2d3436;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f0f0f0;
}

.chart-container-pie {
    position: relative;
    width: 100%;
    height: 300px;
}

.chart-container-pie canvas {
    width: 100% !important;
    height: 100% !important;
}

/* ========== RESPONSIVE ========== */
@media (max-width: 992px) {
    .chart-container {
        height: 220px;
    }
    
    .chart-container-line {
        height: 200px;
    }
    
    .chart-container-pie {
        height: 250px;
    }
}

@media (max-width: 768px) {
    .page-header {
        padding: 40px 0 30px;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
    
    .page-header p {
        font-size: 1rem;
    }
    
    .dashboard-number {
        font-size: 35px;
    }
    
    .dashboard-card {
        padding: 20px 15px;
    }
    
    .chart-wrapper,
    .chart-wrapper-line,
    .chart-wrapper-pie {
        padding: 15px;
        min-height: 280px;
    }
    
    .chart-container {
        height: 200px;
    }
    
    .chart-container-line {
        height: 180px;
    }
    
    .chart-container-pie {
        height: 220px;
    }
}

@media (max-width: 576px) {
    .page-header h1 {
        font-size: 1.6rem;
    }
    
    .dashboard-number {
        font-size: 28px;
    }
    
    .chart-container {
        height: 180px;
    }
    
    .chart-container-line {
        height: 160px;
    }
    
    .chart-container-pie {
        height: 200px;
    }
}
</style>

<section class="page-header">
    <div class="container text-center">
        <h1>🌱 Panel Administrativo</h1>
        <p>Monitoreo inteligente de recursos y sostenibilidad</p>
    </div>
</section>

<div class="container">

    <!-- ========== TARJETAS ESTADÍSTICAS ========== -->
    <div class="row g-4">

        <div class="col-md-3">
            <div class="dashboard-card">
                <h4>👥 Usuarios</h4>
                <div class="dashboard-number"><?= $totalUsuarios ?></div>
                <small>Usuarios registrados</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card">
                <h4>💧 Agua</h4>
                <div class="dashboard-number"><?= $totalAgua ?></div>
                <small><?= number_format($aguaTotal, 2) ?> L consumidos</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card">
                <h4>🔥 Gas</h4>
                <div class="dashboard-number"><?= $totalGas ?></div>
                <small><?= number_format($gasTotal, 2) ?> m³ consumidos</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card">
                <h4>⚡ Energía</h4>
                <div class="dashboard-number"><?= $totalEnergia ?></div>
                <small><?= number_format($energiaTotal, 2) ?> kWh consumidos</small>
            </div>
        </div>

    </div>

    <!-- ========== GRÁFICOS SUPERIORES ========== -->
    <div class="row mt-4">

        <div class="col-lg-6">
            <div class="chart-wrapper-pie">
                <h5>🍩 Distribución de Consumos</h5>
                <div class="chart-container-pie">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="chart-wrapper">
                <h5>📊 Comparativa General</h5>
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- ========== GRÁFICOS DE EVOLUCIÓN ========== -->
    <div class="row mt-4">

        <div class="col-lg-4 col-md-6">
            <div class="chart-wrapper-line">
                <h5>💧 Consumo de Agua</h5>
                <div class="chart-container-line">
                    <canvas id="aguaChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="chart-wrapper-line">
                <h5>🔥 Consumo de Gas</h5>
                <div class="chart-container-line">
                    <canvas id="gasChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">
            <div class="chart-wrapper-line">
                <h5>⚡ Consumo de Energía</h5>
                <div class="chart-container-line">
                    <canvas id="energiaChart"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- ========== CHART JS ========== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

// Configuración de fuentes para mejor legibilidad
Chart.defaults.font.family = "'Segoe UI', Arial, sans-serif";
Chart.defaults.font.size = 12;

/* ========== PIE CHART ========== */
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: ['💧 Agua', '🔥 Gas', '⚡ Energía'],
        datasets: [{
            data: [
                <?= $aguaTotal ?>,
                <?= $gasTotal ?>,
                <?= $energiaTotal ?>
            ],
            backgroundColor: [
                'rgba(54, 162, 235, 0.85)',
                'rgba(255, 99, 132, 0.85)',
                'rgba(255, 206, 86, 0.85)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    font: { size: 13, weight: 'bold' },
                    padding: 20,
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0,0,0,0.8)',
                titleFont: { size: 14, weight: 'bold' },
                bodyFont: { size: 13 },
                padding: 12,
                cornerRadius: 10,
                callbacks: {
                    label: function(context) {
                        var total = context.dataset.data.reduce(function(a, b) { return a + b; }, 0);
                        var porcentaje = ((context.parsed / total) * 100).toFixed(1);
                        return context.label + ': ' + context.parsed.toLocaleString() + ' (' + porcentaje + '%)';
                    }
                }
            }
        }
    }
});

/* ========== BAR CHART ========== */
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: ['💧 Agua', '🔥 Gas', '⚡ Energía'],
        datasets: [{
            label: 'Consumo Total',
            data: [
                <?= $aguaTotal ?>,
                <?= $gasTotal ?>,
                <?= $energiaTotal ?>
            ],
            backgroundColor: [
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 99, 132, 0.7)',
                'rgba(255, 206, 86, 0.7)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 2,
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0,0,0,0.8)',
                titleFont: { size: 14, weight: 'bold' },
                bodyFont: { size: 13 },
                padding: 12,
                cornerRadius: 10,
                callbacks: {
                    label: function(context) {
                        return 'Total: ' + context.parsed.y.toLocaleString();
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Consumo Total',
                    font: { size: 12, weight: 'bold' }
                },
                ticks: {
                    font: { size: 11 },
                    callback: function(value) {
                        if (value >= 1000) {
                            return (value / 1000).toFixed(0) + 'k';
                        }
                        return value;
                    }
                },
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: { size: 12, weight: 'bold' }
                }
            }
        }
    }
});

/* ========== AGUA CHART ========== */
new Chart(document.getElementById('aguaChart'), {
    type: 'line',
    data: {
        labels: meses,
        datasets: [{
            label: 'Agua (L)',
            data: <?= json_encode($aguaMeses) ?>,
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.1)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: 'rgba(54, 162, 235, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: { size: 11, weight: 'bold' },
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0,0,0,0.8)',
                titleFont: { size: 13, weight: 'bold' },
                bodyFont: { size: 12 },
                padding: 10,
                cornerRadius: 8
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    font: { size: 10 },
                    callback: function(value) {
                        if (value >= 1000) {
                            return (value / 1000).toFixed(0) + 'k';
                        }
                        return value;
                    }
                },
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: { size: 10 }
                }
            }
        }
    }
});

/* ========== GAS CHART ========== */
new Chart(document.getElementById('gasChart'), {
    type: 'line',
    data: {
        labels: meses,
        datasets: [{
            label: 'Gas (m³)',
            data: <?= json_encode($gasMeses) ?>,
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.1)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: 'rgba(255, 99, 132, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: { size: 11, weight: 'bold' },
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0,0,0,0.8)',
                titleFont: { size: 13, weight: 'bold' },
                bodyFont: { size: 12 },
                padding: 10,
                cornerRadius: 8
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    font: { size: 10 }
                },
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: { size: 10 }
                }
            }
        }
    }
});

/* ========== ENERGÍA CHART ========== */
new Chart(document.getElementById('energiaChart'), {
    type: 'line',
    data: {
        labels: meses,
        datasets: [{
            label: 'Energía (kWh)',
            data: <?= json_encode($energiaMeses) ?>,
            borderColor: 'rgba(255, 206, 86, 1)',
            backgroundColor: 'rgba(255, 206, 86, 0.1)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: 'rgba(255, 206, 86, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: { size: 11, weight: 'bold' },
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0,0,0,0.8)',
                titleFont: { size: 13, weight: 'bold' },
                bodyFont: { size: 12 },
                padding: 10,
                cornerRadius: 8
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    font: { size: 10 }
                },
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: { size: 10 }
                }
            }
        }
    }
});
</script>

<?php include '../includes/footer.php'; ?>