<?php
session_start();
include '../config/conexion.php';

if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin'){
    header("Location: ../index.php");
    exit();
}

if(isset($_GET['id'])){

    $id = intval($_GET['id']);

    mysqli_query(
        $conexion,
        "UPDATE noticias
         SET estado='archivada'
         WHERE id=$id"
    );
}

header("Location: Noticias.php");
exit();
