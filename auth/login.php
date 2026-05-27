<?php
session_start();
include '../config/conexion.php';

if(isset($_POST['login'])){

    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE correo = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if($resultado->num_rows > 0){

        $usuario = $resultado->fetch_assoc();

        if(password_verify($password, $usuario['password'])){

            $_SESSION['usuario'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];
            $_SESSION['id'] = $usuario['id'];

            header('Location: ../admin/dashboard.php');
            exit();

        } else {
            $error = "Contraseña incorrecta";
        }

    } else {
        $error = "Usuario no encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

<div class="row justify-content-center">
<div class="col-md-5">

<div class="card shadow p-4">

<h2 class="text-center mb-4">
🔐 Iniciar Sesión
</h2>

<?php if(isset($error)): ?>
<div class="alert alert-danger">
    <?php echo $error; ?>
</div>
<?php endif; ?>

<form method="POST">

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

<button name="login" class="btn btn-success w-100">
Entrar
</button>

</form>

<div class="text-center mt-3">
<a href="registro.php">
Crear Cuenta
</a>
</div>

</div>
</div>
</div>
</div>

</body>
</html>