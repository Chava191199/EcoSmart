<?php

session_start();

include 'config/conexion.php';

if(!isset($_SESSION['id'])){

    header("Location: auth/login.php");
    exit();

}

$usuario_id = $_SESSION['id'];

?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>


<div class="container mt-5">

<div class="section-box">


<h2>📜 Historial de Actividad</h2>

<hr>


<!-- ================= RECICLAJE ================= -->

<h3 class="mt-4">
♻️ Historial de Reciclaje
</h3>


<div class="table-responsive">

<table class="table table-striped">

<thead class="table-success">

<tr>
<th>Fecha</th>
<th>Material</th>
<th>Cantidad</th>
<th>EcoPuntos</th>
</tr>

</thead>


<tbody>


<?php

$reciclaje = mysqli_query(
    $conexion,
    "SELECT *
     FROM reciclaje
     WHERE usuario_id='$usuario_id'
     ORDER BY fecha DESC"
);


if(!$reciclaje){

    die("Error reciclaje: ".mysqli_error($conexion));

}


if(mysqli_num_rows($reciclaje)>0){


while($r=mysqli_fetch_assoc($reciclaje)){


echo "

<tr>

<td>{$r['fecha']}</td>

<td>".htmlspecialchars($r['material'])."</td>

<td>{$r['cantidad']}</td>

<td>{$r['puntos']}</td>

</tr>

";


}


}else{


echo "

<tr>
<td colspan='4' class='text-center'>
Sin registros
</td>
</tr>

";


}


?>


</tbody>

</table>

</div>


<hr>


<!-- ================= ENERGIA ================= -->


<h3 class="mt-4">
⚡ Mi Consumo Energético
</h3>


<div class="table-responsive">

<table class="table table-striped">


<thead class="table-warning">

<tr>

<th>Fecha</th>

<th>Consumo (kWh)</th>

</tr>

</thead>


<tbody>


<?php


$energia=mysqli_query(

$conexion,

"SELECT *
 FROM consumo_energetico
 WHERE usuario_id='$usuario_id'
 ORDER BY fecha DESC"

);



if(!$energia){

die("Error energía: ".mysqli_error($conexion));

}



if(mysqli_num_rows($energia)>0){


while($e=mysqli_fetch_assoc($energia)){


echo "

<tr>

<td>{$e['fecha']}</td>

<td>{$e['consumo']} kWh</td>

</tr>

";


}



}else{


echo "

<tr>

<td colspan='2' class='text-center'>
Sin registros
</td>

</tr>

";


}


?>


</tbody>

</table>

</div>



<hr>



<!-- ================= AGUA ================= -->


<h3 class="mt-4">
💧 Mi Consumo de Agua
</h3>



<div class="table-responsive">


<table class="table table-striped">


<thead class="table-info">


<tr>

<th>Fecha</th>

<th>Consumo (Litros)</th>

</tr>


</thead>


<tbody>



<?php


$agua=mysqli_query(

$conexion,

"SELECT *
 FROM consumo_agua
 WHERE usuario_id='$usuario_id'
 ORDER BY fecha DESC"

);



if(!$agua){

die("Error agua: ".mysqli_error($conexion));

}




if(mysqli_num_rows($agua)>0){



while($a=mysqli_fetch_assoc($agua)){



echo "

<tr>

<td>{$a['fecha']}</td>

<td>{$a['consumo']} L</td>

</tr>


";


}



}else{


echo "

<tr>

<td colspan='2' class='text-center'>
Sin registros
</td>

</tr>

";


}


?>


</tbody>

</table>


</div>



<hr>




<!-- ================= GAS ================= -->


<h3 class="mt-4">
⛽ Mi Consumo de Gas
</h3>


<div class="table-responsive">


<table class="table table-striped">


<thead class="table-danger">


<tr>

<th>Fecha</th>

<th>Consumo</th>

</tr>


</thead>



<tbody>


<?php


$gas=mysqli_query(

$conexion,

"SELECT *
 FROM consumo_gas
 WHERE usuario_id='$usuario_id'
 ORDER BY fecha DESC"

);



if(!$gas){

die("Error gas: ".mysqli_error($conexion));

}




if(mysqli_num_rows($gas)>0){



while($g=mysqli_fetch_assoc($gas)){


echo "

<tr>

<td>{$g['fecha']}</td>

<td>{$g['consumo']}</td>

</tr>


";


}



}else{


echo "

<tr>

<td colspan='2' class='text-center'>
Sin registros
</td>

</tr>


";


}



?>


</tbody>


</table>


</div>


</div>

</div>


<?php include 'includes/footer.php'; ?>
