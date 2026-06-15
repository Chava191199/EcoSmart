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

$consumo = 0;
$nivel = "";
$costo = 0;

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $consumo = floatval($_POST["consumo"]);

    mysqli_query(
        $conexion,
        "INSERT INTO consumo_energetico(
            usuario_id,
            consumo
        )
        VALUES(
            '$usuario_id',
            '$consumo'
        )"
    );

    $precio_kwh = 0.799;

    $costo = $consumo * $precio_kwh;

    if($consumo < 100){
        $nivel = "🟢 Consumo Bajo";
    }
    elseif($consumo < 200){
        $nivel = "🟡 Consumo Medio";
    }
    else{
        $nivel = "🔴 Consumo Alto";
    }
}
?>

<section class="page-header">
    <div class="container text-center">

        <h1>⚡ Mi Consumo Energético</h1>

        <p>
            Ingresa tu consumo y conoce tu nivel energético
        </p>

    </div>
</section>

<div class="container">

<div class="section-box">

<h2>✏️ Registrar Consumo</h2>

<hr>

<form method="POST">

<label>⚡ Cantidad consumida (kWh)</label>

<input
type="number"
step="0.01"
name="consumo"
class="form-control"
required>

<button
class="btn btn-success mt-4 w-100">

📊 Calcular Consumo

</button>

</form>

</div>

<?php if($_SERVER["REQUEST_METHOD"]=="POST"): ?>

<div class="section-box">

<h2>📊 Resultado</h2>

<hr>

<h3>
Consumo:
<?= number_format($consumo,2) ?>
kWh
</h3>

<h3>
Costo:
$
<?= number_format($costo,2) ?>
</h3>

<h3>
<?= $nivel ?>
</h3>

</div>

<?php endif; ?>

</div>

<?php include __DIR__.'/../includes/footer.php'; ?>