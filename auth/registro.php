<?php

include '../config/conexion.php';

$mensaje = "";

if(isset($_POST['registro'])){

    $nombre = trim(
        mysqli_real_escape_string(
            $conexion,
            $_POST['nombre']
        )
    );

    $correo = trim(
        mysqli_real_escape_string(
            $conexion,
            $_POST['correo']
        )
    );

    $telefono = trim(
        mysqli_real_escape_string(
            $conexion,
            $_POST['telefono']
        )
    );

    $tipo_usuario = mysqli_real_escape_string(
        $conexion,
        $_POST['tipo_usuario']
    );

    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );

    /* FOTO POR DEFECTO */

    $foto = "default.png";

    /* VALIDAR TELÉFONO */

    if(!preg_match('/^[0-9]{10,15}$/', $telefono)){

        $mensaje =
        "El teléfono debe contener entre 10 y 15 dígitos.";

    }else{

        /* VALIDAR CORREO DUPLICADO */

        $verificar = mysqli_query(
            $conexion,
            "SELECT id
             FROM usuarios
             WHERE correo='$correo'"
        );

        if(mysqli_num_rows($verificar) > 0){

            $mensaje =
            "El correo ya está registrado.";

        }else{

            /* SUBIR FOTO */

            if(
                isset($_FILES['foto']) &&
                $_FILES['foto']['error'] == 0
            ){

                $permitidos = [
                    'jpg',
                    'jpeg',
                    'png',
                    'webp',
                    'avif'
                ];

                $extension = strtolower(
                    pathinfo(
                        $_FILES['foto']['name'],
                        PATHINFO_EXTENSION
                    )
                );

                if(
                    !in_array(
                        $extension,
                        $permitidos
                    )
                ){

                    $mensaje =
                    "Formato de imagen no permitido.";

                }elseif(
                    $_FILES['foto']['size']
                    > 5 * 1024 * 1024
                ){

                    $mensaje =
                    "La imagen supera los 5MB.";

                }else{

                    if(
                        !is_dir(
                            "../uploads/perfiles"
                        )
                    ){

                        mkdir(
                            "../uploads/perfiles",
                            0777,
                            true
                        );
                    }

                    $foto =
                    time()
                    . "_"
                    . uniqid()
                    . "."
                    . $extension;

                    move_uploaded_file(

                        $_FILES['foto']['tmp_name'],

                        "../uploads/perfiles/"
                        . $foto

                    );
                }
            }

            /* INSERTAR USUARIO */

            if($mensaje == ""){

                $sql = "

                INSERT INTO usuarios(

                    nombre,
                    correo,
                    telefono,
                    tipo_usuario,
                    foto,
                    password,
                    rol

                )

                VALUES(

                    '$nombre',
                    '$correo',
                    '$telefono',
                    '$tipo_usuario',
                    '$foto',
                    '$password',
                    'usuario'

                )

                ";

                if(
                    mysqli_query(
                        $conexion,
                        $sql
                    )
                ){

                    header(
                        'Location: login.php?registro=ok'
                    );

                    exit();

                }else{

                    $mensaje =
                    "Error al registrar usuario.";
                }
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
        src="/EcoSmart/assets/img/logo.png"
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