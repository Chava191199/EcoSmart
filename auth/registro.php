<?php

include '../config/conexion.php';

$mensaje = "";

if(isset($_POST['registro'])){

    $nombre = mysqli_real_escape_string(
        $conexion,
        $_POST['nombre']
    );

    $correo = mysqli_real_escape_string(
        $conexion,
        $_POST['correo']
    );

    $password = md5(
        $_POST['password']
    );

    $verificar = mysqli_query(
        $conexion,
        "SELECT * FROM usuarios
         WHERE correo='$correo'"
    );

    if(mysqli_num_rows($verificar) > 0){

        $mensaje =
        "El correo ya existe";

    }else{

        $sql = "INSERT INTO usuarios(
                nombre,
                correo,
                password
                )

                VALUES(
                '$nombre',
                '$correo',
                '$password'
                )";

        if(mysqli_query(
            $conexion,
            $sql
        )){

            header(
            "Location: login.php"
            );

            exit();
        }
    }
}

?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="login-container">

<div class="login-box">

<img
src="/EcoSmart/assets/img/logo.png"
class="login-logo">

<h2 class="text-center mb-4">

Registro

</h2>

<?php if($mensaje != ""): ?>

<div class="alert alert-warning">

<?php echo $mensaje; ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="mb-3">

<label>

Nombre

</label>

<input
type="text"
name="nombre"
class="form-control"
required>

</div>

<div class="mb-3">

<label>

Correo

</label>

<input
type="email"
name="correo"
class="form-control"
required>

</div>

<div class="mb-4">

<label>

Contraseña

</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
type="submit"
name="registro"
class="btn btn-success w-100">

Registrarse

</button>

</form>

<div class="text-center mt-4">

<a href="login.php">

Ya tengo cuenta

</a>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>