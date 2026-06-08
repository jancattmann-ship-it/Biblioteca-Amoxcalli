<?php

$servername = "localhost";
$username   = "root";
$password   = "";
$db         = "amoxcalli";

$con = mysqli_connect($servername, $username, $password, $db);

if (!$con) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8mb4");
?>