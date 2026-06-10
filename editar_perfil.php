<?php
session_start();
include 'config/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: auth/login.php");
    exit();
}

$id = $_SESSION['id'];

$stmt = $conexion->prepare(
    "SELECT nombre, correo, telefono
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

    $stmt = $conexion->prepare(
        "UPDATE usuarios
         SET nombre=?,
             correo=?,
             telefono=?
         WHERE id=?"
    );

    $stmt->bind_param(
        "sssi",
        $nombre,
        $correo,
        $telefono,
        $id
    );

    if($stmt->execute()){

        $_SESSION['correo'] = $correo;
        $_SESSION['telefono'] = $telefono;
        $_SESSION['usuario'] = $nombre;

        $mensaje =
        "Perfil actualizado correctamente";

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

            <form method="POST">

                <div class="mb-3">

                    <label>Nombre</label>

                    <input
                    type="text"
                    name="nombre"
                    class="form-control"
                    value="<?=
                    htmlspecialchars(
                    $usuario['nombre']
                    ) ?>"
                    required>

                </div>

                <div class="mb-3">

                    <label>Correo</label>

                    <input
                    type="email"
                    name="correo"
                    class="form-control"
                    value="<?=
                    htmlspecialchars(
                    $usuario['correo']
                    ) ?>"
                    required>

                </div>

                <div class="mb-3">

                    <label>Teléfono</label>

                    <input
                    type="text"
                    name="telefono"
                    class="form-control"
                    value="<?=
                    htmlspecialchars(
                    $usuario['telefono']
                    ) ?>">

                </div>

                <button
                class="btn btn-success"
                name="actualizar">

                    Guardar Cambios

                </button>

            </form>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>