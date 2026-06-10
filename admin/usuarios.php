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

    $consulta =
    mysqli_query(
        $conexion,
        "SELECT rol FROM usuarios
        WHERE id=$id"
    );

    $usuario =
    mysqli_fetch_assoc($consulta);

    if($usuario['rol'] != 'admin'){

        mysqli_query(
            $conexion,
            "DELETE FROM usuarios
            WHERE id=$id"
        );

    }

    header("Location: usuarios.php");
    exit();
}

/* HACER ADMIN */

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

/* QUITAR ADMIN */

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
            Administración general de usuarios.
        </p>

        <div class="table-responsive">

            <table class="table table-hover table-bordered align-middle">

                <thead class="table-success">

                    <tr>

                        <th>Foto</th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Tipo</th>
                        <th>Rol</th>
                        <th>Registro</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <?php while($u = mysqli_fetch_assoc($usuarios)): ?>

                    <tr>

                        <td>

                            <img
                            src="/EcoSmart/uploads/perfiles/<?= $u['foto'] ?>"
                            alt="Perfil"
                            width="60"
                            height="60"
                            style="
                                border-radius:50%;
                                object-fit:cover;
                                border:2px solid #198754;
                            ">

                        </td>

                        <td>
                            <?= $u['id'] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($u['nombre']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($u['correo']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($u['telefono']) ?>
                        </td>

                        <td>

                            <?php if($u['tipo_usuario'] == 'empresa'): ?>

                                🏢 Empresa

                            <?php else: ?>

                                👤 Personal

                            <?php endif; ?>

                        </td>

                        <td>

                            <?php if($u['rol'] == 'admin'): ?>

                                <span class="badge bg-danger">
                                    Admin
                                </span>

                            <?php else: ?>

                                <span class="badge bg-primary">
                                    Usuario
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>
                            <?= $u['fecha_registro'] ?>
                        </td>

                        <td>

                            <?php if($u['rol'] == 'usuario'): ?>

                                <a
                                href="?admin=<?= $u['id'] ?>"
                                class="btn btn-success btn-sm"
                                onclick="return confirm('¿Convertir en administrador?')">

                                    👑 Admin

                                </a>

                            <?php else: ?>

                                <a
                                href="?usuario=<?= $u['id'] ?>"
                                class="btn btn-warning btn-sm"
                                onclick="return confirm('¿Quitar permisos de administrador?')">

                                    👤 Usuario

                                </a>

                            <?php endif; ?>

                            <?php if($u['id'] != $_SESSION['id']): ?>

                                <a
                                href="?eliminar=<?= $u['id'] ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Eliminar usuario definitivamente?')">

                                    🗑 Eliminar

                                </a>

                            <?php endif; ?>

                        </td>

                    </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>