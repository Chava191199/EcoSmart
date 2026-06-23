<?php
session_start();
include '../config/conexion.php';

/* =========================
   VALIDAR ADMIN PRIMERO
========================= */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

/* =========================
   ELIMINAR NOTICIA (ANTES DE HTML)
========================= */
if (isset($_GET['eliminar'])) {

    $id = intval($_GET['eliminar']);

    mysqli_query($conexion,
        "DELETE FROM noticias WHERE id=$id"
    );

    header("Location: eliminar_noticias.php");
    exit();
}

/* =========================
   CONSULTA
========================= */
$noticias = mysqli_query($conexion,
    "SELECT * FROM noticias ORDER BY fecha DESC"
);
?>

<?php include __DIR__ . '/../includes/header.php'; ?>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

<h2>Eliminar Noticias</h2>

<table border="1" width="100%">
    <tr>
        <th>Título</th>
        <th>Acción</th>
    </tr>

    <?php while($n = mysqli_fetch_assoc($noticias)): ?>
    <tr>
        <td><?= $n['titulo'] ?></td>
        <td>
            <a href="?eliminar=<?= $n['id'] ?>"
               onclick="return confirm('¿Seguro que deseas eliminar esta noticia?')">
               🗑 Eliminar
            </a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include __DIR__ . '/../includes/footer.php'; ?>