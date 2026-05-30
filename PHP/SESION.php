<?php

if (!isset($_SESSION["usuarios"])) {
    $_SESSION["usuarios"] = [
        [
            "nombre" => "Admins",
            "email" => "aamoxcallip.viejo@gmail.com",
            "telefono" => "5541049360",
            "genero" => "masculino",
            "password" => "admin123",
            "tipo" => "admin"
        ]
    ];
}

$error_login = "";
$error_registro = "";
$exito_registro = "";

// REGISTRO DE USUARIO
if (isset($_POST["registrar"])) { // REGISTRO DE USUARIO

    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $telefono = trim($_POST["telefono"]);
    $genero = $_POST["genero"];
    $password = $_POST["password"];


    $existe = false; // VERIFICAR SI EXISTE
    foreach ($_SESSION["usuarios"] as $u) {
        if ($u["email"] === $email) {
            $existe = true;
            break;
        }
    }

    if ($existe) {
        $error_registro = "Ya existe una cuenta con ese correo.";
    } elseif (strlen($password) < 6) {
        $error_registro = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        // Agregar usuario al arreglo de sesión
        $_SESSION["usuarios"][] = [
            "nombre" => $nombre,
            "email" => $email,
            "telefono" => $telefono,
            "genero" => $genero,
            "password" => $password,
            "tipo" => "usuario"
        ];
        $exito_registro = "¡Cuenta creada exitosamente! Ya puedes iniciar sesión.";
    }
}


if (isset($_POST["iniciar_sesion"])) { // INICIO DE SESIÓN

    $email = trim($_POST["email_login"]);
    $password = $_POST["password_login"];

    $encontrado = false;
    foreach ($_SESSION["usuarios"] as $u) {
        if ($u["email"] === $email && $u["password"] === $password) {
            $encontrado = true;
            $_SESSION["usuario_activo"] = $u;
            break;
        }
    }

    if (!$encontrado) {
        $error_login = "Correo o contraseña incorrectos.";
    }
}

// CERRAR SESIÓN
if (isset($_POST["cerrar_sesion"])) {
    unset($_SESSION["usuario_activo"]);
}
?>F