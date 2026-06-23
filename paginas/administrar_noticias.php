<?php
session_start();
include '../config/conexion.php';

/* =========================
   VALIDAR ADMIN
========================= */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

/* =========================
   ARCHIVAR NOTICIA
========================= */
if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    mysqli_query($conexion,
        "UPDATE noticias SET estado='archivada' WHERE id=$id"
    );

    header("Location: administrar_noticias.php");
    exit();
}

/* =========================
   CONSULTA
========================= */
$noticias = mysqli_query($conexion,
    "SELECT * FROM noticias ORDER BY fecha DESC"
);

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<h2>Archivar Noticias</h2>

<table border="1" width="100%">
    <tr>
        <th>Título</th>
        <th>Estado</th>
        <th>Acción</th>
    </tr>

    <?php while($n = mysqli_fetch_assoc($noticias)): ?>
    <tr>
        <td><?= htmlspecialchars($n['titulo']) ?></td>
        <td><?= $n['estado'] ?></td>
        <td>
            <?php if ($n['estado'] === 'activa'): ?>
                <a href="administrar_noticias.php?id=<?= $n['id'] ?>">
                    📦 Archivar
                </a>
            <?php else: ?>
                <span>Archivada</span>
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include __DIR__ . '/../includes/footer.php'; ?>