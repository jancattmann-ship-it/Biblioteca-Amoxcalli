<?php

//  LOCAL (XAMPP) 
$servername = "localhost";
$username   = "root";
$password   = "";
$db         = "amoxcalli";

// Infinityfree - datos de conexión

// $servername = "sql107.infinityfree.com";
// $username   = "if0_42184654";
// $password   = "4zTUS1p2kXJG";  
//$db         = "if0_42184654_amoxcalli";

$con = mysqli_connect($servername, $username, $password, $db);

if (!$con) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8mb4");
?>