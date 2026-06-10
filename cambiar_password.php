<?php
session_start();
include 'config/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: auth/login.php");
    exit();
}

$id = $_SESSION['id'];

if (isset($_POST['cambiar'])) {

    $actual = $_POST['actual'];
    $nueva = $_POST['nueva'];
    $confirmar = $_POST['confirmar'];

    if ($nueva !== $confirmar) {
        $error = "Las contraseñas no coinciden";
    } else {

        $stmt = $conexion->prepare("SELECT password FROM usuarios WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();

        if (password_verify($actual, $user['password'])) {

            $hash = password_hash($nueva, PASSWORD_DEFAULT);

            $stmt = $conexion->prepare("UPDATE usuarios SET password=? WHERE id=?");
            $stmt->bind_param("si", $hash, $id);

            if ($stmt->execute()) {
                $ok = "Contraseña actualizada correctamente";
            } else {
                $error = "Error al actualizar contraseña";
            }

        } else {
            $error = "Contraseña actual incorrecta";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container mt-4">

    <h2>EcoSmart - Cambiar contraseña</h2>

    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>

    <?php if (isset($ok)) { ?>
        <div class="alert alert-success"><?php echo $ok; ?></div>
    <?php } ?>

    <form method="POST" class="card p-3">

        <label>Contraseña actual</label>
        <input type="password" name="actual" class="form-control" required>

        <label class="mt-2">Nueva contraseña</label>
        <input type="password" name="nueva" class="form-control" required>

        <label class="mt-2">Confirmar contraseña</label>
        <input type="password" name="confirmar" class="form-control" required>

        <button class="btn btn-warning mt-3" name="cambiar">
            Cambiar contraseña
        </button>

    </form>
</div>

<?php include 'includes/footer.php'; ?>