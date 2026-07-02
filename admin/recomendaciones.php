<?php
session_start();
include "../config/conexion.php";

/* =========================
   VALIDAR ADMIN
========================= */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== "admin") {
    header("Location: ../index.php");
    exit();
}

/* =========================
   TOGGLE ACTIVO/INACTIVO
========================= */
if (isset($_GET['toggle'])) {

    $id = intval($_GET['toggle']);

    $q = mysqli_query($conexion, "SELECT activa FROM recomendaciones WHERE id=$id");
    if ($row = mysqli_fetch_assoc($q)) {

        $nuevo = $row['activa'] ? 0 : 1;

        mysqli_query($conexion, "
            UPDATE recomendaciones
            SET activa=$nuevo
            WHERE id=$id
        ");
    }

    header("Location: recomendaciones.php");
    exit();
}

/* =========================
   FILTRO
========================= */
$filtro = "";

if (isset($_GET['tipo']) && $_GET['tipo'] !== "") {
    $tipo = mysqli_real_escape_string($conexion, $_GET['tipo']);
    $filtro = "WHERE tipo='$tipo'";
}

$sql = "SELECT * FROM recomendaciones $filtro ORDER BY id DESC";
$resultado = mysqli_query($conexion, $sql);

/* =========================
   VISTA
========================= */
include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-5">

    <div class="d-flex justify-content-between mb-4">
        <h2>⚙ Recomendaciones</h2>

        <a href="agregar_recomendacion.php" class="btn btn-success">
            ➕ Agregar
        </a>
    </div>

    <!-- FILTROS -->
    <div class="mb-3">
        <a href="recomendaciones.php" class="btn btn-secondary btn-sm">Todas</a>
        <a href="?tipo=energia" class="btn btn-warning btn-sm">⚡ Energía</a>
        <a href="?tipo=agua" class="btn btn-primary btn-sm">💧 Agua</a>
        <a href="?tipo=gas" class="btn btn-danger btn-sm">🔥 Gas</a>
    </div>

    <div class="table-responsive">

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Min</th>
                    <th>Max</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

            <?php if (mysqli_num_rows($resultado) > 0): ?>
                <?php while ($r = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= $r['id'] ?></td>

                        <td>
                            <?= match($r['tipo']) {
                                'energia' => '⚡ Energía',
                                'agua' => '💧 Agua',
                                'gas' => '🔥 Gas',
                                default => $r['tipo']
                            } ?>
                        </td>

                        <td><?= $r['consumo_min'] ?></td>
                        <td><?= $r['consumo_max'] ?></td>

                        <td><?= htmlspecialchars($r['titulo']) ?></td>
                        <td><?= htmlspecialchars($r['descripcion']) ?></td>

                        <td>
                            <?php if ($r['activa']): ?>
                                <span class="badge bg-success">Activa</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactiva</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a href="editar_recomendacion.php?id=<?= $r['id'] ?>" class="btn btn-warning btn-sm">
                                ✏
                            </a>

                            <a href="?toggle=<?= $r['id'] ?>" class="btn btn-info btn-sm">
                                🔄
                            </a>

                            <a href="eliminar_recomendacion.php?id=<?= $r['id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Eliminar?')">
                                🗑
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Sin recomendaciones</td>
                </tr>
            <?php endif; ?>

            </tbody>
        </table>

    </div>

</div>

<?php include "../includes/footer.php"; ?>
