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

<div class="container mt-5 pt-5">

    <h1 class="dashboard-title">🌱 Panel Administrativo</h1>
    <p class="dashboard-subtitle">Monitoreo inteligente de recursos y sostenibilidad</p>

    <!-- TARJETAS -->
    <div class="row g-4">

        <div class="col-md-3">
            <div class="dashboard-card">
                <h4>👥 Usuarios</h4>
                <div class="dashboard-number"><?= $totalUsuarios ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card">
                <h4>💧 Agua</h4>
                <div class="dashboard-number"><?= $totalAgua ?></div>
                <small><?= number_format($aguaTotal,2) ?> L consumidos</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card">
                <h4>🔥 Gas</h4>
                <div class="dashboard-number"><?= $totalGas ?></div>
                <small><?= number_format($gasTotal,2) ?> m³ consumidos</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card">
                <h4>⚡ Energía</h4>
                <div class="dashboard-number"><?= $totalEnergia ?></div>
                <small><?= number_format($energiaTotal,2) ?> kWh consumidos</small>
            </div>
        </div>

    </div>

    <!-- GRÁFICOS -->
    <div class="row mt-5">

        <div class="col-lg-6 mb-4">
            <canvas id="pieChart"></canvas>
        </div>

        <div class="col-lg-6 mb-4">
            <canvas id="aguaChart"></canvas>
        </div>

        <div class="col-lg-6 mb-4">
            <canvas id="gasChart"></canvas>
        </div>

        <div class="col-lg-6 mb-4">
            <canvas id="energiaChart"></canvas>
        </div>

    </div>

</div>

<!-- IA SIMPLE -->
<div class="container mt-4">

    <div class="ia-summary">
        <h3>🧠 EcoSmart IA</h3>

        <?php
        $mayor = max($aguaTotal, $gasTotal, $energiaTotal);

        if ($mayor == $aguaTotal) {
            echo "<p>💧 El agua es el recurso con mayor consumo. Se recomienda fomentar el ahorro hídrico.</p>";
        } elseif ($mayor == $gasTotal) {
            echo "<p>🔥 El gas es el consumo más alto. Revisar fugas y hábitos.</p>";
        } else {
            echo "<p>⚡ La energía es el consumo más alto. Promover eficiencia energética.</p>";
        }

        $impacto = $aguaTotal + $gasTotal + $energiaTotal;

        if ($impacto < 1000) {
            echo "<p>🟢 Estado ambiental: Excelente.</p>";
        } elseif ($impacto < 5000) {
            echo "<p>🟡 Estado ambiental: Moderado.</p>";
        } else {
            echo "<p>🔴 Estado ambiental: Alto impacto.</p>";
        }
        ?>
    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];

/* PIE */
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: ['Agua','Gas','Energía'],
        datasets: [{
            data: [
                <?= $aguaTotal ?>,
                <?= $gasTotal ?>,
                <?= $energiaTotal ?>
            ]
        }]
    }
});

/* AGUA */
new Chart(document.getElementById('aguaChart'), {
    type: 'line',
    data: {
        labels: meses,
        datasets: [{
            label: 'Agua (L)',
            data: <?= json_encode($aguaMeses) ?>
        }]
    }
});

/* GAS */
new Chart(document.getElementById('gasChart'), {
    type: 'line',
    data: {
        labels: meses,
        datasets: [{
            label: 'Gas (m³)',
            data: <?= json_encode($gasMeses) ?>
        }]
    }
});

/* ENERGÍA */
new Chart(document.getElementById('energiaChart'), {
    type: 'line',
    data: {
        labels: meses,
        datasets: [{
            label: 'Energía (kWh)',
            data: <?= json_encode($energiaMeses) ?>
        }]
    }
});

</script>

<?php include '../includes/footer.php'; ?>