<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "ecosmart_db";

$conexion = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

if(!$conexion){
    die("Error de conexión");
}

?>