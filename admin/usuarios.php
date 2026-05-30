<?php
session_start();
include '../config/conexion.php';

$sql = "SELECT * FROM usuarios";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Usuarios</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">

<h1 class="mb-4">
👥 Usuarios Registrados
</h1>

<table class="table table-bordered table-striped">

<tr>
<th>ID</th>
<th>Nombre</th>
<th>Correo</th>
<th>Rol</th>
</tr>

<?php while($usuario = mysqli_fetch_assoc($resultado)): ?>

<tr>
<td><?php echo $usuario['id']; ?></td>
<td><?php echo $usuario['nombre']; ?></td>
<td><?php echo $usuario['correo']; ?></td>
<td><?php echo $usuario['rol']; ?></td>
</tr>

<?php endwhile; ?>

</table>

</div>

</body>
</html>