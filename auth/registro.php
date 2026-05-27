<?php
include '../config/conexion.php';

if(isset($_POST['registro'])){

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];

    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );

    $sql = "INSERT INTO usuarios(nombre, correo, password)
            VALUES(?,?,?)";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param(
        "sss",
        $nombre,
        $correo,
        $password
    );

    if($stmt->execute()){
        header('Location: login.php');
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
<div class="row justify-content-center">
<div class="col-md-5">

<div class="card shadow p-4">

<h2 class="text-center mb-4">📝 Registro
</h2>

<form method="POST">

<input type="text"
name="nombre"
placeholder="Nombre"
class="form-control mb-3"
required>

<input type="email"
name="correo"
placeholder="Correo"
class="form-control mb-3"
required>

<input type="password"
name="password"
placeholder="Contraseña"
class="form-control mb-3"
required>

<button name="registro" class="btn btn-success w-100">
Registrarse
</button>

</form>

</div>
</div>
</div>
</div>

</body>
</html>
