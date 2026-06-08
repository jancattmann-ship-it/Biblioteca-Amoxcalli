<?php
session_start();
include_once("CONEXION.php");

// Solo se ejecuta si llegaron datos del formulario
if (!isset($_POST["nombre"])) {
    header("Location: LOGIN.php");
    exit();
}

$nombre   = trim($_POST["nombre"]);
$email    = trim($_POST["email"]);
$telefono = trim($_POST["telefono"]);
$genero   = $_POST["genero"];
$password = $_POST["password"];
$tipo     = $_POST["tipo"];

// Verificar si el correo ya existe
$stmt = mysqli_prepare($con, "SELECT email FROM usuarios WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    // Correo ya registrado — regresar con error
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    header("Location: LOGIN.php?error=existe");
    exit();
}
mysqli_stmt_close($stmt);

// Insertar nuevo usuario
$stmt2 = mysqli_prepare($con, "INSERT INTO usuarios (email, nombre, telefono, genero, tipo, contrasena) VALUES (?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt2, "ssssss", $email, $nombre, $telefono, $genero, $tipo, $password);

if (mysqli_stmt_execute($stmt2)) {
    // Registro exitoso — guardar sesión y redirigir
    $_SESSION["usuario"] = [
        "nombre"   => $nombre,
        "email"    => $email,
        "telefono" => $telefono,
        "genero"   => $genero,
        "tipo"     => $tipo
    ];
    mysqli_stmt_close($stmt2);
    mysqli_close($con);
    header("Location: LOGIN.php?registro=ok");
    exit();
} else {
    mysqli_stmt_close($stmt2);
    mysqli_close($con);
    header("Location: LOGIN.php?error=db");
    exit();
}
?>