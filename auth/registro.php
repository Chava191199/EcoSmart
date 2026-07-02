<?php

include '../config/conexion.php';

$mensaje = "";

if (isset($_POST['registro'])) {

    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $tipo_usuario = isset($_POST['tipo_usuario']) ? trim($_POST['tipo_usuario']) : 'personal';
    $password_raw = isset($_POST['password']) ? $_POST['password'] : '';

    $foto = 'default.avif';

    // Validaciones básicas
    if (!preg_match('/^[0-9]{10,15}$/', $telefono)) {
        $mensaje = 'El teléfono debe contener entre 10 y 15 dígitos.';
    } elseif (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = 'Introduce un correo válido.';
    } elseif (empty($password_raw)) {
        $mensaje = 'La contraseña no puede estar vacía.';
    } else {

        // Verificar correo duplicado con sentencia preparada
        $stmt = $conexion->prepare('SELECT id FROM usuarios WHERE correo = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('s', $correo);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $mensaje = 'El correo ya está registrado.';
            }
            $stmt->close();
        } else {
            error_log('Prepare failed: ' . $conexion->error);
            $mensaje = 'Error del servidor. Intenta más tarde.';
        }
    }

    // Si no hay mensajes de error, procesar foto y guardar usuario
    if ($mensaje == '') {

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $permitidos = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
            $extension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

            if (!in_array($extension, $permitidos)) {
                $mensaje = 'Formato de imagen no permitido.';
            } elseif ($_FILES['foto']['size'] > 5 * 1024 * 1024) {
                $mensaje = 'La imagen supera los 5MB.';
            } else {
                if (!is_dir(__DIR__ . '/../uploads/perfiles')) {
                    mkdir(__DIR__ . '/../uploads/perfiles', 0755, true);
                }

                $foto = time() . '_' . uniqid() . '.' . $extension;
                $dest = __DIR__ . '/../uploads/perfiles/' . $foto;
                move_uploaded_file($_FILES['foto']['tmp_name'], $dest);
            }
        }

        if ($mensaje == '') {

            $password = password_hash($password_raw, PASSWORD_DEFAULT);

            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, telefono, tipo_usuario, foto, password, rol) VALUES (?, ?, ?, ?, ?, ?, 'usuario')");

            if ($stmt) {
                $stmt->bind_param('ssssss', $nombre, $correo, $telefono, $tipo_usuario, $foto, $password);
                if ($stmt->execute()) {
                    $stmt->close();
                    header('Location: login.php?registro=ok');
                    exit();
                } else {
                    error_log('Execute failed: ' . $stmt->error);
                    $mensaje = 'Error al registrar usuario.';
                }
            } else {
                error_log('Prepare failed: ' . $conexion->error);
                $mensaje = 'Error del servidor. Intenta más tarde.';
            }
        }
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

            Registro EcoSmart

        </h2>

        <?php if($mensaje != ""): ?>

            <div class="alert alert-warning">

                <?= $mensaje ?>

            </div>

        <?php endif; ?>

        <form
        method="POST"
        enctype="multipart/form-data"
        autocomplete="on">

            <div class="mb-3">

                <label>Nombre</label>

                <input
                type="text"
                name="nombre"
                autocomplete="name"
                class="form-control"
                required>

            </div>

            <div class="mb-3">

                <label>Correo</label>

                <input
                type="email"
                name="correo"
                autocomplete="email"
                class="form-control"
                required>

            </div>

            <div class="mb-3">

                <label>Teléfono</label>

                <input
                type="tel"
                name="telefono"
                autocomplete="tel"
                class="form-control"
                placeholder="8123456789"
                pattern="[0-9]{10,15}"
                required>

            </div>

            <div class="mb-3">

                <label>Tipo de Cuenta</label>

                <select
                name="tipo_usuario"
                class="form-control">

                    <option value="personal">
                        Personal
                    </option>

                    <option value="empresa">
                        Empresa
                    </option>

                </select>

            </div>

            <div class="mb-3">

                <label>Foto de Perfil</label>

                <input
                type="file"
                name="foto"
                accept=".jpg,.jpeg,.png,.webp,.avif"
                class="form-control">

            </div>

            <div class="mb-4">

                <label>Contraseña</label>

                <input
                type="password"
                name="password"
                autocomplete="new-password"
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

    </div>

</div>

<?php include '../includes/footer.php'; ?>
