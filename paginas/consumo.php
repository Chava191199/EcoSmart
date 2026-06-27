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
$costo = 0;
$nivel = "";



if($_SERVER["REQUEST_METHOD"]=="POST"){


    $consumo = floatval($_POST["consumo"]);


    mysqli_query(
        $conexion,
        "INSERT INTO consumo_energetico(usuario_id, consumo)
        VALUES('$usuario_id','$consumo')"
    );



    $precio_kwh = 0.799;

    $costo = $consumo * $precio_kwh;



    if($consumo < 100){

        $nivel = "🟢 Bajo";

    }elseif($consumo < 200){

        $nivel = "🟡 Medio";

    }else{

        $nivel = "🔴 Alto";

    }

}

?>


<section class="page-header">

<div class="container text-center">

<h1>⚡ Consumo Energético</h1>

<p>Ingresa tu consumo eléctrico</p>

</div>

</section>



<div class="container">



<!-- FORMULARIO -->

<div class="section-box">


<h2>⚡ Registrar Consumo</h2>

<hr>


<form method="POST">


<label>

kWh consumidos

</label>


<input

type="number"

step="0.01"

name="consumo"

class="form-control"

required>



<button class="btn btn-success mt-4 w-100">

Calcular

</button>


</form>


</div>





<?php if($_SERVER["REQUEST_METHOD"]=="POST"): ?>



<!-- RESULTADO -->


<div class="section-box">


<h2>📊 Resultado</h2>

<hr>


<h3>
Consumo:
<?= number_format($consumo,2) ?> kWh
</h3>


<h3>
Costo:
$<?= number_format($costo,2) ?>
</h3>


<h3>

<?= $nivel ?>

</h3>


</div>





<!-- RECOMENDACIONES -->


<?php


$recoEnergia = [];


if($consumo >= 200){


    $tituloReco = "🔴 Consumo alto";


    $recoEnergia[] = "🚨 Alto consumo eléctrico detectado.";

    $recoEnergia[] = "💡 Sustituye focos tradicionales por focos LED.";

    $recoEnergia[] = "❄️ Reduce el uso prolongado del aire acondicionado.";

    $recoEnergia[] = "🔌 Desconecta aparatos que no utilices.";



}elseif($consumo >=100){


    $tituloReco = "🟡 Consumo medio";


    $recoEnergia[] = "⚠️ Consumo medio de energía.";

    $recoEnergia[] = "💡 Evita dejar equipos conectados sin uso.";

    $recoEnergia[] = "🖥️ Apaga dispositivos cuando no los utilices.";



}else{


    $tituloReco = "🟢 Consumo eficiente";


    $recoEnergia[] = "✅ Excelente consumo energético.";

    $recoEnergia[] = "🌎 Mantén tus hábitos de ahorro.";

    $recoEnergia[] = "💚 Continúa utilizando energía responsable.";

}


?>




<div class="section-box text-center">


<h2>💡 Recomendaciones Personalizadas</h2>

<hr>



<button

type="button"

class="btn btn-primary btn-lg"

onclick="abrirRecomendaciones()">


💡 Ver recomendaciones


</button>



</div>






<!-- VENTANA RECOMENDACIONES -->


<div id="ventanaReco"

style="

display:none;

position:fixed;

top:0;

left:0;

width:100%;

height:100%;

background:rgba(0,0,0,.6);

z-index:9999;

">





<div style="

background:white;

color:#333;

width:90%;

max-width:500px;

margin:8% auto;

padding:30px;

border-radius:15px;

box-shadow:0 5px 20px rgba(0,0,0,.3);

">





<h2 style="

text-align:center;

color:#222;

">

<?= $tituloReco ?>

</h2>



<hr>




<?php foreach($recoEnergia as $r): ?>



<div style="

background:#f1f1f1;

color:#333;

padding:15px;

margin:12px 0;

border-radius:10px;

font-size:16px;

">


<?= $r ?>


</div>



<?php endforeach; ?>





<div style="text-align:center;margin-top:20px;">



<button

class="btn btn-secondary"

onclick="cerrarRecomendaciones()">


Cerrar


</button>



</div>




</div>



</div>







<script>


function abrirRecomendaciones(){

    document.getElementById("ventanaReco").style.display="block";

}



function cerrarRecomendaciones(){

    document.getElementById("ventanaReco").style.display="none";

}



window.onclick=function(event){

    let modal=document.getElementById("ventanaReco");


    if(event.target==modal){

        modal.style.display="none";

    }

}


</script>





<?php endif; ?>



</div>




<?php include __DIR__.'/../includes/footer.php'; ?>