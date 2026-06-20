<?php
session_start();

// Incluir la conexión a la base de datos
include __DIR__ . '/../config/conexion.php';

// Incluir header y navbar
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

// Verificar que el usuario esté logueado
if(!isset($_SESSION['id'])){
    header("Location: auth/login.php");
    exit();
}

// Definir la variable correctamente
$usuario_id = $_SESSION['id'];
?>

<!-- Agregar Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- CSS externo -->
<link rel="stylesheet" href="css/comparativa.css">

<section class="page-header">
    <div class="container text-center">
        <h1>📊 Comparativa de Consumos</h1>
        <p>Análisis detallado de tus consumos de Energía, Agua y Gas</p>
    </div>
</section>

<div class="container">
    <div class="section-box">
        
        <!-- ================= FILTROS ================= -->
        <div class="filtros-container">
            <div class="filtros">
                <label for="periodo">📅 Período:</label>
                <select id="periodo" class="form-select">
                    <option value="7">Últimos 7 días</option>
                    <option value="30" selected>Últimos 30 días</option>
                    <option value="90">Últimos 90 días</option>
                    <option value="365">Último año</option>
                    <option value="0">Todo el historial</option>
                </select>
                
                <label for="tipoGrafica">📊 Tipo:</label>
                <select id="tipoGrafica" class="form-select">
                    <option value="bar">Barras</option>
                    <option value="line">Línea</option>
                </select>
            </div>
        </div>

        <!-- ================= GRÁFICO PRINCIPAL ================= -->
        <div class="row">
            <div class="col-md-12">
                <div class="card-grafica">
                    <div class="card-body-grafica">
                        <canvas id="consumoChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= GRÁFICO DE DONA ================= -->
        <h3 class="mt-5">🍩 Distribución de Consumos</h3>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card-grafica">
                    <div class="card-body-grafica">
                        <canvas id="donaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= GRÁFICO DE EVOLUCIÓN ================= -->
        <h3 class="mt-5">📈 Evolución de Consumos</h3>
        <div class="row">
            <div class="col-md-12">
                <div class="card-grafica">
                    <div class="card-body-grafica">
                        <canvas id="evolucionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= RESÚMEN DE CONSUMOS ================= -->
        <h3 class="mt-5">📊 Resumen de Consumos</h3>
        <div class="row mt-3">
            <?php
            // Obtener totales
            $total_energia = 0;
            $query = mysqli_query($conexion, "SELECT SUM(consumo) as total FROM consumo_energetico WHERE usuario_id='$usuario_id'");
            if($row = mysqli_fetch_assoc($query)) {
                $total_energia = floatval($row['total']);
            }
            
            $total_agua = 0;
            $query = mysqli_query($conexion, "SELECT SUM(consumo) as total FROM consumo_agua WHERE usuario_id='$usuario_id'");
            if($row = mysqli_fetch_assoc($query)) {
                $total_agua = floatval($row['total']);
            }
            
            $total_gas = 0;
            $query = mysqli_query($conexion, "SELECT SUM(consumo) as total FROM consumo_gas WHERE usuario_id='$usuario_id'");
            if($row = mysqli_fetch_assoc($query)) {
                $total_gas = floatval($row['total']);
            }
            
            // Contar registros
            $count_energia = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM consumo_energetico WHERE usuario_id='$usuario_id'"));
            $count_agua = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM consumo_agua WHERE usuario_id='$usuario_id'"));
            $count_gas = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM consumo_gas WHERE usuario_id='$usuario_id'"));
            ?>
            
            <div class="col-md-4">
                <div class="info-card">
                    <div class="icon">⚡</div>
                    <div class="valor"><?php echo number_format($total_energia, 2); ?></div>
                    <div class="label">Total Energía (kWh)</div>
                    <div class="registros"><?php echo $count_energia; ?> registros</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-card">
                    <div class="icon">💧</div>
                    <div class="valor"><?php echo number_format($total_agua, 2); ?></div>
                    <div class="label">Total Agua (Litros)</div>
                    <div class="registros"><?php echo $count_agua; ?> registros</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-card">
                    <div class="icon">⛽</div>
                    <div class="valor"><?php echo number_format($total_gas, 2); ?></div>
                    <div class="label">Total Gas</div>
                    <div class="registros"><?php echo $count_gas; ?> registros</div>
                </div>
            </div>
        </div>

        <!-- ================= METAS Y PROGRESO ================= -->
        <h3 class="mt-5">🎯 Metas de Ahorro</h3>
        <div class="row">
            <?php
            // Definir metas
            $meta_energia = 200;
            $meta_agua = 8000;
            $meta_gas = 120;
            
            // Calcular porcentajes
            $porcentaje_energia = ($total_energia > 0) ? min(100, round(($total_energia / $meta_energia) * 100)) : 0;
            $porcentaje_agua = ($total_agua > 0) ? min(100, round(($total_agua / $meta_agua) * 100)) : 0;
            $porcentaje_gas = ($total_gas > 0) ? min(100, round(($total_gas / $meta_gas) * 100)) : 0;
            ?>
            
            <div class="col-md-4">
                <div class="meta-card">
                    <h4>⚡ Energía</h4>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: <?php echo $porcentaje_energia; ?>%">
                            <?php echo $porcentaje_energia; ?>%
                        </div>
                    </div>
                    <p>Meta: <?php echo $meta_energia; ?> kWh/mes</p>
                    <p>Actual: <?php echo number_format($total_energia, 2); ?> kWh</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="meta-card">
                    <h4>💧 Agua</h4>
                    <div class="progress">
                        <div class="progress-bar bg-info" style="width: <?php echo $porcentaje_agua; ?>%">
                            <?php echo $porcentaje_agua; ?>%
                        </div>
                    </div>
                    <p>Meta: <?php echo number_format($meta_agua); ?> L/mes</p>
                    <p>Actual: <?php echo number_format($total_agua, 2); ?> L</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="meta-card">
                    <h4>⛽ Gas</h4>
                    <div class="progress">
                        <div class="progress-bar bg-warning" style="width: <?php echo $porcentaje_gas; ?>%">
                            <?php echo $porcentaje_gas; ?>%
                        </div>
                    </div>
                    <p>Meta: <?php echo $meta_gas; ?> m³/mes</p>
                    <p>Actual: <?php echo number_format($total_gas, 2); ?> m³</p>
                </div>
            </div>
        </div>

        <!-- ================= COMPARATIVA MENSUAL ================= -->
        <h3 class="mt-5">📊 Comparativa Mensual</h3>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <?php
                // Obtener consumo del mes actual
                $mes_actual = date('Y-m');
                $query = mysqli_query($conexion, "
                    SELECT SUM(consumo) as total 
                    FROM consumo_energetico 
                    WHERE usuario_id='$usuario_id' 
                    AND DATE_FORMAT(fecha, '%Y-%m') = '$mes_actual'
                ");
                $actual = 0;
                if($row = mysqli_fetch_assoc($query)) {
                    $actual = floatval($row['total']);
                }
                
                // Obtener consumo del mes anterior
                $mes_anterior = date('Y-m', strtotime('-1 month'));
                $query = mysqli_query($conexion, "
                    SELECT SUM(consumo) as total 
                    FROM consumo_energetico 
                    WHERE usuario_id='$usuario_id' 
                    AND DATE_FORMAT(fecha, '%Y-%m') = '$mes_anterior'
                ");
                $anterior = 0;
                if($row = mysqli_fetch_assoc($query)) {
                    $anterior = floatval($row['total']);
                }
                
                $diferencia = $actual - $anterior;
                $porcentaje = ($anterior > 0) ? round(($diferencia / $anterior) * 100, 2) : 0;
                $color = ($diferencia <= 0) ? 'success' : 'danger';
                $icono = ($diferencia <= 0) ? '📉' : '📈';
                $mensaje = ($diferencia <= 0) ? '¡Has reducido tu consumo!' : 'Has aumentado tu consumo';
                ?>
                
                <div class="comparativa-card">
                    <h4>⚡ Consumo de Energía</h4>
                    <div class="comparativa-valor">
                        <span class="badge bg-<?php echo $color; ?>">
                            <?php echo $icono; ?> <?php echo abs($porcentaje); ?>%
                        </span>
                        <p><?php echo $mensaje; ?></p>
                        <p>
                            Este mes: <strong><?php echo number_format($actual, 2); ?> kWh</strong>
                            <br>
                            Mes anterior: <?php echo number_format($anterior, 2); ?> kWh
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= SUGERENCIAS PERSONALIZADAS ================= -->
        <h3 class="mt-5">💡 Consejos para ahorrar</h3>
        <div class="sugerencias-container">
            <?php
            // Obtener el consumo más alto
            $max_consumo = max($total_energia, $total_agua, $total_gas);
            
            if($total_energia >= $total_agua && $total_energia >= $total_gas && $total_energia > 0) {
                echo '<div class="sugerencia-card">
                    <div class="icon">💡</div>
                    <div class="texto">
                        <h4>Reduce tu consumo de energía</h4>
                        <p>Tu consumo de energía es el más alto. Considera usar electrodomésticos eficientes (clase A), apagar los que no uses y aprovechar la luz natural.</p>
                    </div>
                </div>';
            } 
            
            if($total_agua >= $total_energia && $total_agua >= $total_gas && $total_agua > 0) {
                echo '<div class="sugerencia-card">
                    <div class="icon">💧</div>
                    <div class="texto">
                        <h4>Ahorra agua</h4>
                        <p>Tu consumo de agua es alto. Repara fugas, usa dispositivos de bajo consumo, toma duchas más cortas y reutiliza el agua cuando sea posible.</p>
                    </div>
                </div>';
            }
            
            if($total_gas >= $total_energia && $total_gas >= $total_agua && $total_gas > 0) {
                echo '<div class="sugerencia-card">
                    <div class="icon">⛽</div>
                    <div class="texto">
                        <h4>Optimiza tu consumo de gas</h4>
                        <p>Tu consumo de gas es alto. Revisa tus electrodomésticos, usa ollas a presión, mantén la temperatura adecuada y realiza mantenimiento periódico.</p>
                    </div>
                </div>';
            }
            
            if($total_energia == 0 && $total_agua == 0 && $total_gas == 0) {
                echo '<div class="sugerencia-card">
                    <div class="icon">🌱</div>
                    <div class="texto">
                        <h4>¡Comienza a registrar tus consumos!</h4>
                        <p>Aún no tienes registros de consumo. ¡Empieza a monitorear tu huella ecológica hoy mismo!</p>
                    </div>
                </div>';
            }
            ?>
        </div>

        <!-- ================= TABLA DETALLADA ================= -->
        <h3 class="mt-5">📋 Detalle de Consumos</h3>
        <div class="table-responsive">
            <table class="table table-striped" id="tablaConsumos">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>⚡ Energía (kWh)</th>
                        <th>💧 Agua (L)</th>
                        <th>⛽ Gas</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta para obtener datos agrupados por fecha
                    $query = mysqli_query($conexion, "
                        SELECT 
                            DATE(fecha) as fecha,
                            SUM(CASE WHEN tipo='energia' THEN consumo ELSE 0 END) as energia,
                            SUM(CASE WHEN tipo='agua' THEN consumo ELSE 0 END) as agua,
                            SUM(CASE WHEN tipo='gas' THEN consumo ELSE 0 END) as gas
                        FROM (
                            SELECT fecha, 'energia' as tipo, consumo FROM consumo_energetico WHERE usuario_id='$usuario_id'
                            UNION ALL
                            SELECT fecha, 'agua' as tipo, consumo FROM consumo_agua WHERE usuario_id='$usuario_id'
                            UNION ALL
                            SELECT fecha, 'gas' as tipo, consumo FROM consumo_gas WHERE usuario_id='$usuario_id'
                        ) as todos
                        GROUP BY DATE(fecha)
                        ORDER BY fecha DESC
                        LIMIT 10
                    ");
                    
                    $tiene_datos = false;
                    while($row = mysqli_fetch_assoc($query)) {
                        $tiene_datos = true;
                        $total = $row['energia'] + $row['agua'] + $row['gas'];
                        echo "<tr>
                            <td>" . date('d/m/Y', strtotime($row['fecha'])) . "</td>
                            <td>" . number_format($row['energia'], 2) . "</td>
                            <td>" . number_format($row['agua'], 2) . "</td>
                            <td>" . number_format($row['gas'], 2) . "</td>
                            <td><strong>" . number_format($total, 2) . "</strong></td>
                        </tr>";
                    }
                    
                    if(!$tiene_datos) {
                        echo "<tr><td colspan='5' class='text-center'>Sin registros de consumo</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- ================= BOTONES DE EXPORTACIÓN ================= -->
        <div class="export-buttons text-center mt-3">
            <button onclick="exportarCSV()" class="btn-export">
                📥 Exportar CSV
            </button>
        </div>

        <!-- ================= FECHA DE ACTUALIZACIÓN ================= -->
        <div class="text-muted text-center mt-4">
            <small>🔄 Última actualización: <?php echo date('d/m/Y H:i:s'); ?></small>
        </div>

        <!-- ================= BOTÓN VOLVER ================= -->
        <div class="text-center mt-4">
            <a href="../dashboard_usuario.php" class="btn-volver">←Mi Historial</a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php
    // Obtener totales para la gráfica
    $total_energia = 0;
    $query = mysqli_query($conexion, "SELECT SUM(consumo) as total FROM consumo_energetico WHERE usuario_id='$usuario_id'");
    if($row = mysqli_fetch_assoc($query)) {
        $total_energia = floatval($row['total']);
    }
    
    $total_agua = 0;
    $query = mysqli_query($conexion, "SELECT SUM(consumo) as total FROM consumo_agua WHERE usuario_id='$usuario_id'");
    if($row = mysqli_fetch_assoc($query)) {
        $total_agua = floatval($row['total']);
    }
    
    $total_gas = 0;
    $query = mysqli_query($conexion, "SELECT SUM(consumo) as total FROM consumo_gas WHERE usuario_id='$usuario_id'");
    if($row = mysqli_fetch_assoc($query)) {
        $total_gas = floatval($row['total']);
    }
    
    // Obtener últimos valores
    $ultimo_energia = 0;
    $query = mysqli_query($conexion, "SELECT consumo FROM consumo_energetico WHERE usuario_id='$usuario_id' ORDER BY fecha DESC LIMIT 1");
    if($row = mysqli_fetch_assoc($query)) {
        $ultimo_energia = floatval($row['consumo']);
    }
    
    $ultimo_agua = 0;
    $query = mysqli_query($conexion, "SELECT consumo FROM consumo_agua WHERE usuario_id='$usuario_id' ORDER BY fecha DESC LIMIT 1");
    if($row = mysqli_fetch_assoc($query)) {
        $ultimo_agua = floatval($row['consumo']);
    }
    
    $ultimo_gas = 0;
    $query = mysqli_query($conexion, "SELECT consumo FROM consumo_gas WHERE usuario_id='$usuario_id' ORDER BY fecha DESC LIMIT 1");
    if($row = mysqli_fetch_assoc($query)) {
        $ultimo_gas = floatval($row['consumo']);
    }
    
    // Calcular máximo para el eje Y
    $maximo = max($ultimo_energia, $ultimo_agua, $ultimo_gas, $total_energia, $total_agua, $total_gas);
    $maximo = $maximo * 1.2;
    
    if($maximo == 0) {
        $maximo = 100;
    }
    
    // Datos para evolución (últimos 7 días)
    $fechas = [];
    $datos_energia = [];
    $datos_agua = [];
    $datos_gas = [];
    
    for($i = 6; $i >= 0; $i--) {
        $fecha = date('Y-m-d', strtotime("-$i days"));
        $fechas[] = date('d/m', strtotime($fecha));
        
        // Energía
        $query = mysqli_query($conexion, "SELECT SUM(consumo) as total FROM consumo_energetico WHERE usuario_id='$usuario_id' AND DATE(fecha) = '$fecha'");
        $total = 0;
        if($row = mysqli_fetch_assoc($query)) {
            $total = floatval($row['total']);
        }
        $datos_energia[] = $total;
        
        // Agua
        $query = mysqli_query($conexion, "SELECT SUM(consumo) as total FROM consumo_agua WHERE usuario_id='$usuario_id' AND DATE(fecha) = '$fecha'");
        $total = 0;
        if($row = mysqli_fetch_assoc($query)) {
            $total = floatval($row['total']);
        }
        $datos_agua[] = $total;
        
        // Gas
        $query = mysqli_query($conexion, "SELECT SUM(consumo) as total FROM consumo_gas WHERE usuario_id='$usuario_id' AND DATE(fecha) = '$fecha'");
        $total = 0;
        if($row = mysqli_fetch_assoc($query)) {
            $total = floatval($row['total']);
        }
        $datos_gas[] = $total;
    }
    ?>
    
    // ================= GRÁFICO PRINCIPAL =================
    var ctx = document.getElementById('consumoChart').getContext('2d');
    var consumoChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['⚡ Energía', '💧 Agua', '⛽ Gas'],
            datasets: [
                {
                    label: 'Último Consumo',
                    data: [<?php echo $ultimo_energia; ?>, <?php echo $ultimo_agua; ?>, <?php echo $ultimo_gas; ?>],
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    barPercentage: 0.4,
                    borderRadius: 8
                },
                {
                    label: 'Total Acumulado',
                    data: [<?php echo $total_energia; ?>, <?php echo $total_agua; ?>, <?php echo $total_gas; ?>],
                    backgroundColor: 'rgba(255, 99, 132, 0.8)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    barPercentage: 0.4,
                    borderRadius: 8
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: { size: 14, weight: 'bold' },
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'rectRounded'
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
                            return context.dataset.label + ': ' + context.parsed.y.toLocaleString() + ' unidades';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: <?php echo $maximo; ?>,
                    title: {
                        display: true,
                        text: 'Consumo (unidades)',
                        font: { size: 14, weight: 'bold' }
                    },
                    ticks: {
                        font: { size: 12 },
                        callback: function(value) {
                            if (value >= 1000) {
                                return (value / 1000).toFixed(0) + 'k';
                            }
                            return value;
                        }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: true
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Tipo de Consumo',
                        font: { size: 14, weight: 'bold' }
                    },
                    ticks: {
                        font: { size: 13, weight: 'bold' }
                    },
                    grid: {
                        display: false
                    }
                }
            },
            layout: {
                padding: { top: 20, bottom: 20, left: 10, right: 10 }
            }
        }
    });
    
    // ================= GRÁFICO DE DONA =================
    var ctxDona = document.getElementById('donaChart').getContext('2d');
    new Chart(ctxDona, {
        type: 'doughnut',
        data: {
            labels: ['⚡ Energía', '💧 Agua', '⛽ Gas'],
            datasets: [{
                data: [<?php echo $total_energia; ?>, <?php echo $total_agua; ?>, <?php echo $total_gas; ?>],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(255, 206, 86, 0.8)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
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
                        padding: 15
                    }
                },
                tooltip: {
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
    
    // ================= GRÁFICO DE EVOLUCIÓN =================
    var ctxEvolucion = document.getElementById('evolucionChart').getContext('2d');
    new Chart(ctxEvolucion, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($fechas); ?>,
            datasets: [
                {
                    label: '⚡ Energía',
                    data: <?php echo json_encode($datos_energia); ?>,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: '💧 Agua',
                    data: <?php echo json_encode($datos_agua); ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: '⛽ Gas',
                    data: <?php echo json_encode($datos_gas); ?>,
                    borderColor: 'rgba(255, 206, 86, 1)',
                    backgroundColor: 'rgba(255, 206, 86, 0.1)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: { size: 13, weight: 'bold' },
                        padding: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Consumo',
                        font: { size: 13, weight: 'bold' }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fecha',
                        font: { size: 13, weight: 'bold' }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    
    // ================= FILTROS =================
    document.getElementById('periodo').addEventListener('change', function() {
        alert('Filtro por período: ' + this.value + ' días');
        // Aquí puedes agregar lógica para actualizar los datos
    });
    
    document.getElementById('tipoGrafica').addEventListener('change', function() {
        var tipo = this.value;
        consumoChart.config.type = tipo;
        consumoChart.update();
    });
});

// ================= EXPORTAR CSV =================
function exportarCSV() {
    var tabla = document.getElementById('tablaConsumos');
    var filas = tabla.querySelectorAll('tr');
    var csv = '';
    
    filas.forEach(function(fila) {
        var celdas = fila.querySelectorAll('th, td');
        var filaCSV = [];
        celdas.forEach(function(celda) {
            filaCSV.push('"' + celda.innerText.trim() + '"');
        });
        csv += filaCSV.join(',') + '\n';
    });
    
    var blob = new Blob([csv], { type: 'text/csv' });
    var url = window.URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'consumos_' + new Date().toISOString().slice(0,10) + '.csv';
    a.click();
    window.URL.revokeObjectURL(url);
}
</script>

<?php
include __DIR__ . '/../includes/footer.php';
?>