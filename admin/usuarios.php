<?php

session_start();
include '../config/conexion.php';

if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin'){
    header("Location: ../index.php");
    exit();
}

/* ELIMINAR USUARIO */

if(isset($_GET['eliminar'])){

    $id = intval($_GET['eliminar']);

    mysqli_query(
        $conexion,
        "DELETE FROM usuarios WHERE id=$id"
    );

    header("Location: usuarios.php");
    exit();
}

/* CAMBIAR ROL */

if(isset($_GET['admin'])){

    $id = intval($_GET['admin']);

    mysqli_query(
        $conexion,
        "UPDATE usuarios
        SET rol='admin'
        WHERE id=$id"
    );

    header("Location: usuarios.php");
    exit();
}

if(isset($_GET['usuario'])){

    $id = intval($_GET['usuario']);

    mysqli_query(
        $conexion,
        "UPDATE usuarios
        SET rol='usuario'
        WHERE id=$id"
    );

    header("Location: usuarios.php");
    exit();
}

$usuarios = mysqli_query(
    $conexion,
    "SELECT * FROM usuarios
    ORDER BY id DESC"
);

include '../includes/header.php';
include '../includes/navbar.php';

?>

<div class="container dashboard-container">

    <div class="section-box">

        <h2>
            👥 Usuarios Registrados
        </h2>

        <p>
            Administración de usuarios del sistema.
        </p>

        <div class="table-container">

            <table class="table-admin">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Registro</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <?php while($u = mysqli_fetch_assoc($usuarios)): ?>

                    <tr>

                        <td><?= $u['id'] ?></td>

                        <td><?= $u['nombre'] ?></td>

                        <td><?= $u['correo'] ?></td>

                        <td>

                            <span class="role-badge">

                                <?= $u['rol'] ?>

                            </span>

                        </td>

                        <td>

                            <?= $u['fecha_registro'] ?>

                        </td>

                        <td>

                            <?php if($u['rol'] == 'usuario'): ?>

                                <a
                                href="?admin=<?= $u['id'] ?>"
                                class="btn-admin">

                                    👑 Hacer Admin

                                </a>

                            <?php else: ?>

                                <a
                                href="?usuario=<?= $u['id'] ?>"
                                class="btn-user">

                                    👤 Quitar Admin

                                </a>

                            <?php endif; ?>

                            <a
                            href="?eliminar=<?= $u['id'] ?>"
                            class="btn-delete"
                            onclick="return confirm('¿Eliminar usuario?')">

                                🗑 Eliminar

                            </a>

                        </td>

                    </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>