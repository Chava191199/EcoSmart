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
        VALUES('$usuario_id','$agua')"
    );



    $precio = 0.030;


    $costo = $agua * $precio;



    if($agua < 5000){

        $nivel = "🟢 Bajo";


    }elseif($agua < 12000){


        $nivel = "🟡 Medio";


    }else{


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


<label>

Litros consumidos

</label>



<input

type="number"

name="agua"

step="0.01"

class="form-control"

required>




<button class="btn btn-primary mt-4 w-100">


Calcular


</button>



</form>



</div>







<?php if($_SERVER["REQUEST_METHOD"]=="POST"): ?>





<!-- ================= RESULTADOS ================= -->


<div class="section-box">


<h2>📊 Resultado</h2>


<hr>



<h3>

Consumo:

<?= number_format($agua,2) ?> L

</h3>



<h3>

Costo:

$<?= number_format($costo,2) ?>

</h3>



<h3>

<?= $nivel ?>

</h3>



</div>









<!-- ================= RECOMENDACIONES ================= -->


<?php


$recoAgua = [];



if($agua >= 12000){



    $tituloAgua = "🔴 Consumo alto de agua";



    $recoAgua[] = "🚨 Tu consumo de agua es muy alto.";

    $recoAgua[] = "🔧 Revisa posibles fugas en llaves, sanitarios y tuberías.";

    $recoAgua[] = "🚿 Reduce el tiempo de ducha.";

    $recoAgua[] = "🌱 Riega las plantas durante la noche o temprano.";





}elseif($agua >= 5000){



    $tituloAgua = "🟡 Consumo moderado";



    $recoAgua[] = "⚠️ Tu consumo es moderado.";

    $recoAgua[] = "💧 Utiliza dispositivos ahorradores de agua.";

    $recoAgua[] = "🧺 Usa la lavadora únicamente con carga completa.";

    $recoAgua[] = "🚰 Cierra la llave mientras no utilices el agua.";





}else{



    $tituloAgua = "🟢 Consumo eficiente";



    $recoAgua[] = "✅ Excelente consumo de agua.";

    $recoAgua[] = "🌎 Continúa manteniendo hábitos sostenibles.";

    $recoAgua[] = "💙 Sigue cuidando el recurso del agua.";

}



?>







<div class="section-box text-center">



<h2>

💧 Consejos de Ahorro de Agua

</h2>



<hr>




<button

type="button"

class="btn btn-primary btn-lg"

onclick="abrirAgua()">



💧 Ver consejos



</button>



</div>









<!-- ================= VENTANA ================= -->



<div id="ventanaAgua"

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


<?= $tituloAgua ?>


</h2>




<hr>






<?php foreach($recoAgua as $r): ?>



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








<div class="text-center mt-4">



<button

class="btn btn-secondary"

onclick="cerrarAgua()">



Cerrar



</button>




</div>




</div>




</div>









<script>


function abrirAgua(){


    document.getElementById("ventanaAgua").style.display="block";


}



function cerrarAgua(){


    document.getElementById("ventanaAgua").style.display="none";


}




window.onclick=function(event){


    let ventana=document.getElementById("ventanaAgua");


    if(event.target==ventana){


        ventana.style.display="none";


    }


}



</script>







<?php endif; ?>




</div>






<?php include __DIR__.'/../includes/footer.php'; ?>