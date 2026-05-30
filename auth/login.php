<?php

session_start();

include '../config/conexion.php';

$error = "";

if(isset($_POST['login'])){

    $correo = mysqli_real_escape_string(
        $conexion,
        $_POST['correo']
    );

    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios
            WHERE correo='$correo'";

    $resultado = mysqli_query(
        $conexion,
        $sql
    );

    if(mysqli_num_rows($resultado) > 0){

        $usuario = mysqli_fetch_assoc(
            $resultado
        );

       if(
    md5($password) ==
    $usuario['password']
){

    $_SESSION['id']
    = $usuario['id'];

    $_SESSION['usuario']
    = $usuario['nombre'];

    $_SESSION['correo']
    = $usuario['correo'];

    $_SESSION['rol']
    = $usuario['rol'];

    header(
        "Location: ../index.php"
    );

    exit();
}else{

            $error =
            "Contraseña incorrecta";
        }

    }else{

        $error =
        "Usuario no encontrado";
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

Iniciar Sesión

</h2>

<?php if($error != ""): ?>

<div class="alert alert-danger">

<?php echo $error; ?>

</div>

<?php endif; ?>

<form method="POST">

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
name="login"
class="btn btn-success w-100">

Ingresar

</button>

</form>

<div class="text-center mt-4">

<a href="registro.php">

Registrarse
</a>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>