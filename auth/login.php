<?php

session_start();

include __DIR__ . '/../config/conexion.php';

$error = "";

if (isset($_POST['login'])) {

    $usuario_input = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $stmt = $conexion->prepare('SELECT id, nombre, correo, telefono, tipo_usuario, foto, password, rol FROM usuarios WHERE correo = ? OR telefono = ? LIMIT 1');

    if ($stmt) {
        $stmt->bind_param('ss', $usuario_input, $usuario_input);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();

            if (password_verify($password, $usuario['password'])) {
                session_regenerate_id(true);

                $_SESSION['id'] = $usuario['id'];
                $_SESSION['usuario'] = $usuario['nombre'];
                $_SESSION['correo'] = $usuario['correo'];
                $_SESSION['telefono'] = $usuario['telefono'];
                $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
                $_SESSION['foto'] = $usuario['foto'];
                $_SESSION['rol'] = $usuario['rol'];

                header('Location: ../index.php');
                exit();
            } else {
                $error = 'Contraseña incorrecta.';
            }
        } else {
            $error = 'Correo o teléfono no encontrado.';
        }

        $stmt->close();
    } else {
        error_log('Prepare failed: ' . $conexion->error);
        $error = 'Error del servidor. Intenta más tarde.';
    }

}

?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="login-container">

    <div class="login-box">

        <img
        src="/assets/img/logo.png"
        class="login-logo">

        <h2 class="text-center mb-4">
            Iniciar Sesión
        </h2>

        <?php if($error != ""): ?>

            <div class="alert alert-danger">

                <?= $error ?>

            </div>

        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">

                <label>
                    Correo o Teléfono
                </label>

                <input
                type="text"
                name="usuario"
                class="form-control"
                placeholder="correo@ejemplo.com o 8123456789"
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
