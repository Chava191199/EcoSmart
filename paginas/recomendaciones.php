<?php
session_start();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
include __DIR__ . '/../config/conexion.php';

// Verificar si el usuario está logueado
if(!isset($_SESSION['id'])){
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['id'];

// Obtener consumos del usuario para recomendaciones personalizadas
$query_energia = mysqli_query($conexion, "SELECT SUM(consumo) as total FROM consumo_energetico WHERE usuario_id='$usuario_id'");
$total_energia = 0;
if($row = mysqli_fetch_assoc($query_energia)) {
    $total_energia = floatval($row['total']);
}

$query_agua = mysqli_query($conexion, "SELECT SUM(consumo) as total FROM consumo_agua WHERE usuario_id='$usuario_id'");
$total_agua = 0;
if($row = mysqli_fetch_assoc($query_agua)) {
    $total_agua = floatval($row['total']);
}

$query_gas = mysqli_query($conexion, "SELECT SUM(consumo) as total FROM consumo_gas WHERE usuario_id='$usuario_id'");
$total_gas = 0;
if($row = mysqli_fetch_assoc($query_gas)) {
    $total_gas = floatval($row['total']);
}

// Determinar recomendaciones según consumos
$recomendaciones_energia = [];
$recomendaciones_agua = [];
$recomendaciones_gas = [];

// Recomendaciones de Energía
if($total_energia > 200) {
    $recomendaciones_energia[] = "🚨 Tu consumo de energía es muy alto (>200 kWh). Considera reducir el uso de aire acondicionado y calefacción.";
    $recomendaciones_energia[] = "💡 Cambia tus electrodomésticos por modelos eficientes (clase A++).";
    $recomendaciones_energia[] = "💡 Desconecta los aparatos electrónicos cuando no los uses para evitar consumo fantasma.";
    $recomendaciones_energia[] = "💡 Usa bombillas LED en lugar de incandescentes (ahorras hasta 80%).";
    $recomendaciones_energia[] = "💡 Aprovecha la luz natural y abre cortinas durante el día.";
} elseif($total_energia > 100) {
    $recomendaciones_energia[] = "⚠️ Tu consumo de energía es medio (100-200 kWh). Puedes optimizarlo aún más.";
    $recomendaciones_energia[] = "💡 Reduce el uso de aparatos en standby (modo de espera).";
    $recomendaciones_energia[] = "💡 Configura el termostato a 24°C en verano y 20°C en invierno.";
    $recomendaciones_energia[] = "💡 Usa la lavadora y lavavajillas con carga completa.";
} else {
    $recomendaciones_energia[] = "✅ ¡Excelente! Tu consumo de energía es eficiente (<100 kWh).";
    $recomendaciones_energia[] = "💡 Mantén tus buenos hábitos de ahorro energético.";
    $recomendaciones_energia[] = "💡 Comparte tus prácticas con otros usuarios.";
}

// Recomendaciones de Agua
if($total_agua > 12000) {
    $recomendaciones_agua[] = "🚨 Tu consumo de agua es muy alto (>12,000 L). Revisa posibles fugas.";
    $recomendaciones_agua[] = "💡 Reduce el tiempo de ducha a 5 minutos (ahorras hasta 100L por ducha).";
    $recomendaciones_agua[] = "💡 Instala regaderas ahorradoras y aireadores en grifos.";
    $recomendaciones_agua[] = "💡 Reutiliza el agua de la lavadora para limpiar pisos.";
    $recomendaciones_agua[] = "💡 Repara inmediatamente cualquier fuga en tuberías o sanitarios.";
} elseif($total_agua > 5000) {
    $recomendaciones_agua[] = "⚠️ Tu consumo de agua es medio (5,000-12,000 L). Puedes ahorrar más.";
    $recomendaciones_agua[] = "💡 Instala sistemas de captación de agua de lluvia.";
    $recomendaciones_agua[] = "💡 Usa la lavadora solo con carga completa.";
    $recomendaciones_agua[] = "💡 Riega las plantas por la mañana o noche para evitar evaporación.";
} else {
    $recomendaciones_agua[] = "✅ ¡Excelente! Tu consumo de agua es eficiente (<5,000 L).";
    $recomendaciones_agua[] = "💡 Sigue practicando el ahorro de agua.";
    $recomendaciones_agua[] = "💡 Enseña a otros sobre la importancia del agua.";
}

// Recomendaciones de Gas
if($total_gas > 40) {
    $recomendaciones_gas[] = "🚨 Tu consumo de gas es muy alto (>40 m³). Revisa posibles fugas.";
    $recomendaciones_gas[] = "💡 Reduce el tiempo de uso del calentador de agua.";
    $recomendaciones_gas[] = "💡 Realiza mantenimiento periódico de estufa y calentador.";
    $recomendaciones_gas[] = "💡 Usa ollas a presión para reducir tiempos de cocción.";
    $recomendaciones_gas[] = "💡 Revisa que las conexiones de gas estén en buen estado.";
} elseif($total_gas > 20) {
    $recomendaciones_gas[] = "⚠️ Tu consumo de gas es medio (20-40 m³). Puedes optimizarlo.";
    $recomendaciones_gas[] = "💡 Cocina varias comidas a la vez para aprovechar el calor.";
    $recomendaciones_gas[] = "💡 Usa tapas al cocinar para conservar el calor.";
    $recomendaciones_gas[] = "💡 Mantén las hornillas limpias para una combustión eficiente.";
} else {
    $recomendaciones_gas[] = "✅ ¡Excelente! Tu consumo de gas es eficiente (<20 m³).";
    $recomendaciones_gas[] = "💡 Continúa manteniendo estos buenos hábitos.";
    $recomendaciones_gas[] = "💡 Comparte tus consejos de ahorro con familiares.";
}
?>

<!-- CSS externo -->
<link rel="stylesheet" href="../css/recomendaciones.css">

<section class="page-header">
    <div class="container text-center">
        <h1>🌱 Centro de Consejos EcoSmart</h1>
        <p>Recomendaciones automáticas para mejorar tus hábitos de consumo</p>
    </div>
</section>

<div class="container">
    
    <!-- ================= RESUMEN DE CONSUMOS ================= -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="section-box">
                <h2>📊 Tu Resumen de Consumos</h2>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="resumen-card">
                            <div class="resumen-icon">⚡</div>
                            <div class="resumen-info">
                                <span class="resumen-label">Energía</span>
                                <span class="resumen-valor"><?= number_format($total_energia, 2) ?> kWh</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="resumen-card">
                            <div class="resumen-icon">💧</div>
                            <div class="resumen-info">
                                <span class="resumen-label">Agua</span>
                                <span class="resumen-valor"><?= number_format($total_agua, 2) ?> L</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="resumen-card">
                            <div class="resumen-icon">🔥</div>
                            <div class="resumen-info">
                                <span class="resumen-label">Gas</span>
                                <span class="resumen-valor"><?= number_format($total_gas, 2) ?> m³</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= RECOMENDACIONES POR CATEGORÍA ================= -->
    
    <!-- Energía -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="section-box categoria-box categoria-energia">
                <div class="categoria-header">
                    <h2>⚡ Recomendaciones de Energía</h2>
                    <span class="badge-categoria"><?= count($recomendaciones_energia) ?> consejos</span>
                </div>
                <hr>
                <div class="recomendaciones-grid">
                    <?php foreach($recomendaciones_energia as $reco): ?>
                        <div class="recomendacion-item">
                            <?= $reco ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Agua -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="section-box categoria-box categoria-agua">
                <div class="categoria-header">
                    <h2>💧 Recomendaciones de Agua</h2>
                    <span class="badge-categoria"><?= count($recomendaciones_agua) ?> consejos</span>
                </div>
                <hr>
                <div class="recomendaciones-grid">
                    <?php foreach($recomendaciones_agua as $reco): ?>
                        <div class="recomendacion-item">
                            <?= $reco ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Gas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="section-box categoria-box categoria-gas">
                <div class="categoria-header">
                    <h2>🔥 Recomendaciones de Gas</h2>
                    <span class="badge-categoria"><?= count($recomendaciones_gas) ?> consejos</span>
                </div>
                <hr>
                <div class="recomendaciones-grid">
                    <?php foreach($recomendaciones_gas as $reco): ?>
                        <div class="recomendacion-item">
                            <?= $reco ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= CONSEJOS GENERALES ================= -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="section-box">
                <h2>🌱 Consejos Generales para Ahorrar</h2>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="consejo-general">
                            <span class="consejo-icon">🏠</span>
                            <div>
                                <h5>En el hogar</h5>
                                <ul>
                                    <li>Aprovecha la luz natural</li>
                                    <li>Mantén una temperatura adecuada</li>
                                    <li>Revisa periódicamente instalaciones</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="consejo-general">
                            <span class="consejo-icon">🛒</span>
                            <div>
                                <h5>En las compras</h5>
                                <ul>
                                    <li>Elige electrodomésticos eficientes</li>
                                    <li>Compara precios de servicios</li>
                                    <li>Compra productos duraderos</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="consejo-general">
                            <span class="consejo-icon">♻️</span>
                            <div>
                                <h5>En el reciclaje</h5>
                                <ul>
                                    <li>Separa residuos correctamente</li>
                                    <li>Reutiliza materiales</li>
                                    <li>Participa en programas de reciclaje</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="consejo-general">
                            <span class="consejo-icon">📱</span>
                            <div>
                                <h5>Con tecnología</h5>
                                <ul>
                                    <li>Usa termostatos inteligentes</li>
                                    <li>Monitorea tu consumo digitalmente</li>
                                    <li>Automatiza el apagado de equipos</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= DATOS DE INTERÉS ================= -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="section-box">
                <h2>📊 Datos de Interés</h2>
                <hr>
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="dato-card">
                            <div class="dato-icon">🌍</div>
                            <div class="dato-valor">40%</div>
                            <div class="dato-label">Ahorro con bombillas LED</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="dato-card">
                            <div class="dato-icon">🚿</div>
                            <div class="dato-valor">100L</div>
                            <div class="dato-label">Ahorro por ducha de 5 min</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="dato-card">
                            <div class="dato-icon">🍳</div>
                            <div class="dato-valor">30%</div>
                            <div class="dato-label">Ahorro con ollas a presión</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="dato-card">
                            <div class="dato-icon">💡</div>
                            <div class="dato-valor">10%</div>
                            <div class="dato-label">Ahorro apagando standby</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
