<?php
session_start();
include 'config/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: auth/login.php");
    exit();
}

$id = $_SESSION['id'];

$stmt = $conexion->prepare(
    "SELECT nombre, correo, telefono, foto
     FROM usuarios
     WHERE id=?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$usuario = $stmt->get_result()->fetch_assoc();

if(isset($_POST['actualizar'])){

    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);

    $foto = $usuario['foto'];

    /* SUBIR NUEVA FOTO */

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

        if(in_array($extension, $permitidos)){

            if(!is_dir("uploads/perfiles")){
                mkdir(
                    "uploads/perfiles",
                    0777,
                    true
                );
            }

            $nuevoNombre =
            time() .
            "_" .
            uniqid() .
            "." .
            $extension;

            move_uploaded_file(
                $_FILES['foto']['tmp_name'],
                "uploads/perfiles/" .
                $nuevoNombre
            );

            $foto = $nuevoNombre;
        }
    }

    $stmt = $conexion->prepare(
        "UPDATE usuarios
         SET nombre=?,
             correo=?,
             telefono=?,
             foto=?
         WHERE id=?"
    );

    $stmt->bind_param(
        "ssssi",
        $nombre,
        $correo,
        $telefono,
        $foto,
        $id
    );

    if($stmt->execute()){

        $_SESSION['usuario'] = $nombre;
        $_SESSION['correo'] = $correo;
        $_SESSION['telefono'] = $telefono;
        $_SESSION['foto'] = $foto;

        $mensaje =
        "Perfil actualizado correctamente";

        $usuario['foto'] = $foto;

    }else{

        $mensaje =
        "Error al actualizar perfil";
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container mt-5">

    <div class="card">

        <div class="card-header bg-success text-white">

            Editar Perfil

        </div>

        <div class="card-body">

            <?php if(isset($mensaje)){ ?>

                <div class="alert alert-info">
                    <?php echo $mensaje; ?>
                </div>

            <?php } ?>

            <form
                method="POST"
                enctype="multipart/form-data">

                <div class="text-center mb-4">

                    <img
                    src="uploads/perfiles/<?=
                    !empty($usuario['foto'])
                    ? $usuario['foto']
                    : 'default.png'
                    ?>"
                    style="
                    width:150px;
                    height:150px;
                    border-radius:50%;
                    object-fit:cover;
                    border:4px solid #28a745;">

                </div>

                <div class="mb-3">

                    <label>
                        Cambiar Foto
                    </label>

                    <input
                    type="file"
                    name="foto"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp,.avif">

                </div>

                <div class="mb-3">

                    <label>Nombre</label>

                    <input
                    type="text"
                    name="nombre"
                    class="form-control"
                    value="<?= htmlspecialchars($usuario['nombre']) ?>"
                    required>

                </div>

                <div class="mb-3">

                    <label>Correo</label>

                    <input
                    type="email"
                    name="correo"
                    class="form-control"
                    value="<?= htmlspecialchars($usuario['correo']) ?>"
                    required>

                </div>

                <div class="mb-3">

                    <label>Teléfono</label>

                    <input
                    type="text"
                    name="telefono"
                    class="form-control"
                    value="<?= htmlspecialchars($usuario['telefono']) ?>">

                </div>

                <button
                type="submit"
                name="actualizar"
                class="btn btn-success">

                    Guardar Cambios

                </button>

            </form>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>

