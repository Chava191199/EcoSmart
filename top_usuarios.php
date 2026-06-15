<?php

session_start();

include 'config/conexion.php';

$ranking = mysqli_query(

    $conexion,

    "SELECT nombre,
            eco_puntos
     FROM usuarios
     ORDER BY eco_puntos DESC
     LIMIT 10"

);

include 'includes/header.php';
include 'includes/navbar.php';

?>

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-success text-white">

🏆 Top 10 Usuarios Ecológicos

</div>

<div class="card-body">

<table class="table table-striped">

<thead>

<tr>

<th>Posición</th>
<th>Usuario</th>
<th>EcoPuntos</th>

</tr>

</thead>

<tbody>

<?php
$posicion = 1;

while($row = mysqli_fetch_assoc($ranking)):
?>

<tr>

<td>

<?php

if($posicion == 1){

    echo "🥇";

}elseif($posicion == 2){

    echo "🥈";

}elseif($posicion == 3){

    echo "🥉";

}else{

    echo $posicion;

}

?>

</td>

<td>

<?= htmlspecialchars($row['nombre']) ?>

</td>

<td>

<?= $row['eco_puntos'] ?>

</td>

</tr>

<?php
$posicion++;
endwhile;
?>

</tbody>

</table>

</div>

</div>

</div>

<?php include 'includes/footer.php'; ?>