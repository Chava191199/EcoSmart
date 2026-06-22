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
<link rel="stylesheet" href="../css/comparativa.css">

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
            </div>
        </div>

        <!-- ================= GRÁFICO DE DONA MEJORADO ================= -->
        <div class="row mt-4">
            <div class="col-md-8 mx-auto">
                <div class="grafica-wrapper">
                    <div class="grafica-header">
                        <h3>🍩 Distribución de Consumos</h3>
                        <span class="badge-grafica">📊 Porcentajes</span>
                    </div>
                    <div class="grafica-container-dona">
                        <canvas id="donaChart"></canvas>
                    </div>
                    <div class="grafica-footer">
                        <div class="estadisticas">
                            <span>
                                <span class="indicador-color" style="background: #4e73df;"></span>
                                Energía
                            </span>
                            <span>
                                <span class="indicador-color" style="background: #1cc88a;"></span>
                                Agua
                            </span>
                            <span>
                                <span class="indicador-color" style="background: #f6c23e;"></span>
                                Gas
                            </span>
                        </div>
                        <div>
                            <small>🔄 Actualizado: <?php echo date('d/m/Y'); ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= GRÁFICO DE EVOLUCIÓN MEJORADO ================= -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="grafica-wrapper">
                    <div class="grafica-header">
                        <h3>📈 Evolución de Consumos</h3>
                        <span class="badge-grafica">📅 Últimos 7 días</span>
                    </div>
                    <div class="grafica-container">
                        <canvas id="evolucionChart"></canvas>
                    </div>
                    <div class="grafica-footer">
                        <div class="estadisticas">
                            <span>
                                <span class="indicador-color" style="background: #4e73df;"></span>
                                Energía (kWh)
                            </span>
                            <span>
                                <span class="indicador-color" style="background: #1cc88a;"></span>
                                Agua (L)
                            </span>
                            <span>
                                <span class="indicador-color" style="background: #f6c23e;"></span>
                                Gas (m³)
                            </span>
                        </div>
                        <div>
                            <small>📊 Tendencia de consumo</small>
                        </div>
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
            <a href="../dashboard_usuario.php" class="btn-volver">← Mi Historial</a>
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
    
    // ================= GRÁFICO DE DONA MEJORADO =================
    var ctxDona = document.getElementById('donaChart').getContext('2d');
    new Chart(ctxDona, {
        type: 'doughnut',
        data: {
            labels: ['⚡ Energía', '💧 Agua', '⛽ Gas'],
            datasets: [{
                data: [<?php echo $total_energia; ?>, <?php echo $total_agua; ?>, <?php echo $total_gas; ?>],
                backgroundColor: [
                    'rgb(232, 238, 56)',
                    'rgba(58, 208, 234, 0.85)',
                    'rgb(224, 24, 24)'
                ],
                borderColor: [
                    'rgb(232, 238, 56)',
                    'rgba(58, 208, 234, 0.85)',
                    'rgb(224, 24, 24)'
                ],
                borderWidth: 3,
                hoverOffset: 12
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 14, weight: 'bold' },
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.85)',
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    padding: 15,
                    cornerRadius: 12,
                    callbacks: {
                        label: function(context) {
                            var total = context.dataset.data.reduce(function(a, b) { return a + b; }, 0);
                            var porcentaje = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed.toLocaleString() + ' (' + porcentaje + '%)';
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                duration: 1500
            }
        }
    });
    
    // ================= GRÁFICO DE EVOLUCIÓN MEJORADO =================
    var ctxEvolucion = document.getElementById('evolucionChart').getContext('2d');
    new Chart(ctxEvolucion, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($fechas); ?>,
            datasets: [
                {
                    label: '⚡ Energía',
                    data: <?php echo json_encode($datos_energia); ?>,
                    borderColor: 'rgb(232, 238, 56)',
                    backgroundColor: 'rgba(78, 115, 223, 0.15)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(232, 238, 56)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    borderWidth: 3
                },
                {
                    label: '💧 Agua',
                    data: <?php echo json_encode($datos_agua); ?>,
                    borderColor: 'rgba(58, 208, 234, 0.85)',
                    backgroundColor: 'rgba(28, 200, 138, 0.15)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(58, 208, 234, 0.85)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    borderWidth: 3
                },
                {
                    label: '⛽ Gas',
                    data: <?php echo json_encode($datos_gas); ?>,
                    borderColor: 'rgb(224, 24, 24)',
                    backgroundColor: 'rgba(246, 194, 62, 0.15)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(224, 24, 24)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    borderWidth: 3
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
                        font: { size: 14, weight: 'bold' },
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.85)',
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    padding: 15,
                    cornerRadius: 12,
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
                        font: { size: 14, weight: 'bold' }
                    },
                    ticks: {
                        font: { size: 12 }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.06)',
                        drawBorder: true
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fecha',
                        font: { size: 14, weight: 'bold' }
                    },
                    ticks: {
                        font: { size: 12, weight: 'bold' }
                    },
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
    
    // ================= FILTRO DE PERÍODO =================
    document.getElementById('periodo').addEventListener('change', function() {
        alert('Filtro por período: ' + this.value + ' días');
        // Aquí puedes agregar lógica para actualizar los datos
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