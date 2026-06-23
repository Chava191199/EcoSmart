<?php
session_start();
include __DIR__.'/../config/conexion.php';

if(!isset($_SESSION['id'])){
    header("Location: ../auth/login.php");
    exit();
}

$usuario_id = $_SESSION['id'];

include __DIR__.'/../includes/header.php';
include __DIR__.'/../includes/navbar.php';

$agua = 0;
$costo = 0;
$nivel = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $agua = floatval($_POST["agua"]);
    
    mysqli_query(
        $conexion,
        "INSERT INTO consumo_agua(usuario_id, consumo)
        VALUES('$usuario_id', '$agua')"
    );
    
    $precio = 0.030;
    $costo = $agua * $precio;
    
    if($agua < 5000){
        $nivel = "🟢 Bajo";
    } elseif($agua < 12000){
        $nivel = "🟡 Medio";
    } else {
        $nivel = "🔴 Alto";
    }
}
?>

<section class="page-header">
    <div class="container text-center">
        <h1>💧 Consumo de Agua</h1>
        <p>Calcula tu consumo de agua</p>
    </div>
</section>

<div class="container">

    <!-- ================= FORMULARIO ================= -->
    <div class="section-box">
        <h2>💧 Registrar Consumo</h2>
        <hr>
        
        <form method="POST">
            <label>Litros consumidos</label>
            <input type="number" name="agua" step="0.01" class="form-control" required>
            
            <button class="btn btn-primary mt-4 w-100">Calcular</button>
        </form>
    </div>

    <!-- ================= RESULTADOS ================= -->
    <?php if($_SERVER["REQUEST_METHOD"]=="POST"): ?>
    
    <div class="section-box">
        <h2>📊 Resultado</h2>
        <hr>
        
        <h3>Consumo: <?= number_format($agua, 2) ?> L</h3>
        <h3>Costo: $<?= number_format($costo, 2) ?></h3>
        <h3><?= $nivel ?></h3>
    </div>
    
    <!-- ================= RECOMENDACIONES (SIN IA) ================= -->
    <div class="section-box">
        <h2>💧 Consejos de Ahorro de Agua</h2>
        <hr>
        
        <?php
        $recoAgua = [];

        if($agua >= 12000){
            $recoAgua[] = "🚨 Tu consumo de agua es muy alto.";
            $recoAgua[] = "🔧 Revisa posibles fugas en llaves, sanitarios y tuberías.";
            $recoAgua[] = "🚿 Reduce el tiempo de ducha.";
            $recoAgua[] = "🌱 Riega las plantas durante la noche o temprano.";
        }
        elseif($agua >= 5000){
            $recoAgua[] = "⚠️ Tu consumo es moderado.";
            $recoAgua[] = "💧 Utiliza dispositivos ahorradores de agua.";
            $recoAgua[] = "🧺 Usa la lavadora únicamente con carga completa.";
        }
        else{
            $recoAgua[] = "✅ Excelente consumo de agua.";
            $recoAgua[] = "🌎 Continúa manteniendo hábitos sostenibles.";
        }

        foreach($recoAgua as $r){
            echo "<p class='mb-2'>$r</p>";
        }
        ?>
    </div>
    
    <?php endif; ?>

</div>

<?php include __DIR__.'/../includes/footer.php'; ?>