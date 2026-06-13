<?php
session_start();

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

$consumo = 0;
$nivel = "";
$costo = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $consumo = floatval($_POST["consumo"]);

    // Precio ejemplo
    $precio_kwh = 0.799;

    $costo = $consumo * $precio_kwh;

    if ($consumo < 100) {
        $nivel = "🟢 Consumo Bajo";
    }
    elseif ($consumo < 200) {
        $nivel = "🟡 Consumo Medio";
    }
    else {
        $nivel = "🔴 Consumo Alto";
    }
}
?>

<section class="page-header">
    <div class="container text-center">
        <h1>⚡ Mi Consumo Energético</h1>
        <p>Ingresa tu consumo y conoce tu nivel energético</p>
    </div>
</section>

<div class="container">

<!-- FORMULARIO -->

<section>

<div class="section-box">

<h2>✏️ Registrar Consumo</h2>

<hr>

<form method="POST">

<div class="row justify-content-center">

<div class="col-md-6">

<label class="form-label">

⚡ Cantidad consumida (kWh)

</label>

<input
type="number"
step="0.01"
name="consumo"
class="form-control"
placeholder="Ejemplo: 150"
required>

</div>

</div>

<button
class="btn btn-success mt-4 w-100"
type="submit">

📊 Calcular Consumo

</button>

</form>

</div>

</section>


<?php if($_SERVER["REQUEST_METHOD"]=="POST"): ?>

<section>

<div class="section-box">

<h2>📊 Resultado</h2>

<hr>

<div class="row g-4">

<div class="col-md-4">

<div class="card-custom text-center">

<h4>Consumo</h4>

<h2>

<?php echo number_format($consumo,2); ?>

kWh

</h2>

</div>

</div>

<div class="col-md-4">

<div class="card-custom text-center">

<h4>Costo Aproximado</h4>

<h2>

$

<?php echo number_format($costo,2); ?>

MXN

</h2>

</div>

</div>

<div class="col-md-4">

<div class="card-custom text-center">

<h4>Nivel</h4>

<h2>

<?php echo $nivel; ?>

</h2>

</div>

</div>

</div>

</div>

</section>

<?php endif; ?>


<section>

<div class="section-box">

<h2>💡 Recomendaciones</h2>

<hr>

<ul>

<li>🔌 Desconecta aparatos que no uses.</li>

<li>💡 Cambia focos tradicionales por LED.</li>

<li>🌞 Aprovecha la iluminación natural.</li>

<li>❄️ Reduce el uso innecesario del aire acondicionado.</li>

</ul>

</div>

</section>

</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
```
