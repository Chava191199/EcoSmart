<?php

session_start();

include '../config/conexion.php';

if(
!isset($_SESSION['rol']) ||
$_SESSION['rol'] != 'admin'
){

header(
"Location: ../index.php"
);

exit();

}

$totalUsuarios =
mysqli_num_rows(
mysqli_query(
$conexion,
"SELECT * FROM usuarios"
)
);

include '../includes/header.php';
include '../includes/navbar.php';

?>

<div class="container mt-5 pt-5">

<h1 class="text-center mb-5">

Dashboard EcoSmart

</h1>

<div class="row">

<div class="col-md-4">

<div class="dashboard-card">

<h4>

Usuarios

</h4>

<div class="dashboard-number">

<?= $totalUsuarios ?>

</div>

</div>

</div>

<div class="col-md-4">

<div class="dashboard-card">

<h4>

Campañas

</h4>

<div class="dashboard-number">

12

</div>

</div>

</div>

<div class="col-md-4">

<div class="dashboard-card">

<h4>

Proyectos

</h4>

<div class="dashboard-number">

8

</div>

</div>

</div>

</div>

<hr class="my-5">

<canvas id="consumoChart"></canvas>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx =
document.getElementById(
'consumoChart'
);

new Chart(ctx,{

type:'bar',

data:{

labels:[
'Enero',
'Febrero',
'Marzo',
'Abril',
'Mayo'
],

datasets:[{

label:
'Impacto ecológico',

data:[
30,
55,
40,
75,
90
]

}]

}

});

</script>

<?php include '../includes/footer.php'; ?>