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

$gas = 0;
$costo = 0;
$nivel = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $gas = floatval($_POST["gas"]);
    
    mysqli_query(
        $conexion,
        "INSERT INTO consumo_gas(usuario_id, consumo)
        VALUES('$usuario_id', '$gas')"
    );
    
    $precio = 12.50;
    $costo = $gas * $precio;
    
    if($gas < 20){
        $nivel = "🟢 Bajo";
    } elseif($gas < 40){
        $nivel = "🟡 Medio";
    } else {
        $nivel = "🔴 Alto";
    }
}
?>

<section class="page-header">
    <div class="container text-center">
        <h1>🔥 Consumo de Gas</h1>
        <p>Calcula tu consumo de gas</p>
    </div>
</section>

<div class="container">

    <!-- ================= FORMULARIO ================= -->
    <div class="section-box">
        <h2>🔥 Registrar Consumo</h2>
        <hr>
        
        <form method="POST">
            <label>Gas consumido (m³)</label>
            <input type="number" name="gas" step="0.01" class="form-control" required>
            
            <button class="btn btn-danger mt-4 w-100">Calcular</button>
        </form>
    </div>

    <!-- ================= RESULTADOS ================= -->
    <?php if($_SERVER["REQUEST_METHOD"]=="POST"): ?>
    
    <div class="section-box">
        <h2>📊 Resultado</h2>
        <hr>
        
        <h3>Consumo: <?= number_format($gas, 2) ?> m³</h3>
        <h3>Costo: $<?= number_format($costo, 2) ?></h3>
        <h3><?= $nivel ?></h3>
    </div>
    
    <!-- ================= RECOMENDACIONES (SIN IA) ================= -->
    <div class="section-box">
        <h2>💡 Recomendaciones Personalizadas</h2>
        <hr>
        
        <?php
        $recoGas = [];
        
        if($gas > 40){
            $recoGas[] = "🚨 Consumo alto de gas detectado.";
            $recoGas[] = "💡 Posible fuga o uso prolongado de calentador.";
            $recoGas[] = "💡 Revisa válvulas y mantenimiento de estufa.";
        }
        elseif($gas > 20){
            $recoGas[] = "⚠️ Consumo medio de gas.";
            $recoGas[] = "💡 Optimiza tiempos de cocción.";
        }
        else{
            $recoGas[] = "✅ Consumo eficiente de gas.";
            $recoGas[] = "💡 Buen control energético en cocina.";
        }
        
        if($gas > 30){
            $recoGas[] = "🛁 Posible uso intensivo de calentador de agua.";
        }
        
        foreach($recoGas as $r){
            echo "<p>$r</p>";
        }
        ?>
    </div>
    
    <?php endif; ?>

</div>

<?php include __DIR__.'/../includes/footer.php'; ?>