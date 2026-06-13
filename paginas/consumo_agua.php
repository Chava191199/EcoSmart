<?php
session_start();

include __DIR__.'/../includes/header.php';
include __DIR__.'/../includes/navbar.php';

$agua = 0;
$costo = 0;
$nivel = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $agua = floatval($_POST["agua"] ?? 0);

    $precio = 0.030;

    $costo = $agua * $precio;

    if($agua < 5000){
        $nivel = "🟢 Bajo";
    }
    elseif($agua < 12000){
        $nivel = "🟡 Medio";
    }
    else{
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

<div class="section-box">

<h2>💧 Registrar Consumo</h2>

<hr>

<form method="POST">

<label>Litros consumidos</label>

<input
type="number"
name="agua"
step="0.01"
class="form-control"
required>

<button
class="btn btn-primary mt-4 w-100">

Calcular

</button>

</form>

</div>

<?php if($_SERVER["REQUEST_METHOD"]=="POST"): ?>

<div class="section-box mt-4">

<h2>📊 Resultado</h2>

<hr>

<div class="card-custom">

<h3>
Consumo:
<?php echo number_format($agua,2); ?>
L
</h3>

<h3>
Costo:
$
<?php echo number_format($costo,2); ?>
</h3>

<h3>

<?php echo $nivel; ?>

</h3>

</div>

</div>

<?php endif; ?>

</div>

<?php
include __DIR__.'/../includes/footer.php';
?>
```
