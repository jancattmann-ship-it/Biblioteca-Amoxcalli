<?php
session_start();
include_once("CONEXION.php");

// Recibir título del libro
$titulo_libro = $_POST["libro"] ?? "";

// Buscar cod_libro por título
$cod_libro = null;
if ($titulo_libro !== "") {
    $stmt = mysqli_prepare($con, "SELECT cod_libro FROM libros WHERE titulo = ?");
    mysqli_stmt_bind_param($stmt, "s", $titulo_libro);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        $cod_libro = $fila["cod_libro"];
    }
    mysqli_stmt_close($stmt);
}

// Fechas del préstamo
$fecha_prestamo   = date("Y-m-d");
$fecha_devolucion = date("Y-m-d", strtotime("+3 days"));
$fecha_prestamo_display   = date("d/m/Y");
$fecha_devolucion_display = date("d/m/Y", strtotime("+3 days"));

// Guardar en BD si hay sesión y se encontró el libro
$guardado = false;
$error_guardado = "";
// Si llegó por GET (redirect post-insert), marcar como guardado
if (isset($_GET["id"]) && $_GET["id"] > 0) {
    $guardado = true;
    $titulo_libro = $_GET["libro"] ?? "";

    // Buscar cod_libro por título para mostrarlo en el ticket
    if ($titulo_libro !== "") {
        $stmt_get = mysqli_prepare($con, "SELECT cod_libro FROM libros WHERE titulo = ?");
        mysqli_stmt_bind_param($stmt_get, "s", $titulo_libro);
        mysqli_stmt_execute($stmt_get);
        $res_get = mysqli_stmt_get_result($stmt_get);
        if ($fila_get = mysqli_fetch_assoc($res_get)) {
            $cod_libro = $fila_get["cod_libro"];
        }
        mysqli_stmt_close($stmt_get);
    }
}

if (isset($_SESSION["usuario"]) && $cod_libro !== null && !isset($_GET["id"])) {
    $email = $_SESSION["usuario"]["email"];
    $stmt2 = mysqli_prepare($con, "INSERT INTO saca (email, cod_libro, fecha_pedido) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt2, "sss", $email, $cod_libro, $fecha_prestamo);
    if (mysqli_stmt_execute($stmt2)) {
        $id_prestamo = mysqli_insert_id($con);
        mysqli_stmt_close($stmt2);
        mysqli_close($con);
        header("Location: RESERVAR.php?id=" . $id_prestamo . "&libro=" . urlencode($titulo_libro));
        exit();
    } else {
        $error_guardado = "No se pudo registrar el préstamo en la base de datos.";
    }
    mysqli_stmt_close($stmt2);
}

mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Préstamo | Amoxcalli</title>
    <link rel="stylesheet" href="../CSS/BASE.css">
    <link rel="stylesheet" href="../CSS/RESERVAR.css">
    <link rel="icon" href="../IMAGENES/Fav.png" type="image/png">
</head>
<body>

    <header>
        <img src="../IMAGENES/logo-temixco.png" alt="Logo Temixco">
        <div>
            <h1>Biblioteca Amoxcalli</h1>
            <p>Tu biblioteca de confianza</p>
        </div>
        <div class="header-login">
            <a href="../PHP/LOGIN.php" class="btn-header-login">
                <img src="../IMAGENES/libro_verde.png" alt="Cuenta" class="icono-cuenta">
                <?php echo isset($_SESSION["usuario"]) ? htmlspecialchars($_SESSION["usuario"]["nombre"]) : "Mi cuenta"; ?>
            </a>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="../HTML/MISION.html">Misión y Visión</a></li>
            <li><a href="../HTML/TEMPORADA.html">Talleres de Temporada</a></li>
            <li><a href="../PHP/CATALOGO.php" class="activo">Catálogo</a></li>
            <li><a href="../HTML/SERVICIOS.html">Servicios</a></li>
            <li><a href="../HTML/HORARIO.html">Horario</a></li>
            <li><a href="../HTML/CREDENCIAL.html">Credencial</a></li>
            <li><a href="../PHP/LOGIN.php">Cuenta</a></li>
            <li><a href="../HTML/UBICACION.html">Ubicación</a></li>
            <li><a href="../HTML/PARTICIPANTES.html">Participantes</a></li>
        </ul>
    </nav>

    <div class="contenedor-ticket-wrapper">
        <div class="ticket-prestamo">

            <!-- ENCABEZADO -->
            <div class="ticket-header">
                <img src="../IMAGENES/libro_Encantado.gif" alt="Préstamo" class="icono-pagina">
                <h2>Ticket de Préstamo</h2>
            </div>

            <!-- MENSAJE DE GUARDADO -->
            <?php if ($guardado): ?>
                <p class="msg-exito" style="margin: 16px 32px 0;">✔ Préstamo registrado correctamente en la base de datos.</p>
            <?php elseif ($error_guardado !== ""): ?>
                <p class="msg-error" style="margin: 16px 32px 0;">⚠ <?php echo $error_guardado; ?></p>
            <?php elseif (!isset($_SESSION["usuario"])): ?>
                <p class="aviso-sesion" style="margin: 16px 32px 0;">⚠ No has iniciado sesión. El préstamo no fue guardado. <a href="../PHP/LOGIN.php">Inicia sesión aquí</a>.</p>
            <?php endif; ?>

            <!-- SECCIÓN LIBRO -->
            <div class="ticket-seccion">
                <div class="ticket-seccion-titulo">Libro apartado</div>
                <table>
                    <tbody>
                        <tr><td><strong>Título</strong></td><td><?php echo htmlspecialchars($titulo_libro); ?></td></tr>
                        <tr><td><strong>Código</strong></td><td><?php echo $cod_libro ?? "No encontrado"; ?></td></tr>
                        <tr><td><strong>Fecha de préstamo</strong></td><td><?php echo $fecha_prestamo_display; ?></td></tr>
                        <tr><td><strong>Fecha de devolución</strong></td><td><?php echo $fecha_devolucion_display; ?></td></tr>
                        <tr><td><strong>Cantidad</strong></td><td>1 ejemplar</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- SECCIÓN USUARIO -->
            <div class="ticket-seccion">
                <div class="ticket-seccion-titulo">Datos del solicitante</div>
                <?php if (isset($_SESSION["usuario"])): ?>
                    <?php $u = $_SESSION["usuario"]; ?>
                    <table>
                        <tbody>
                            <tr><td><strong>Nombre</strong></td><td><?php echo htmlspecialchars($u["nombre"]); ?></td></tr>
                            <tr><td><strong>Correo</strong></td><td><?php echo htmlspecialchars($u["email"]); ?></td></tr>
                            <tr><td><strong>Teléfono</strong></td><td><?php echo htmlspecialchars($u["telefono"]); ?></td></tr>
                            <tr><td><strong>Tipo de cuenta</strong></td><td><?php echo htmlspecialchars($u["tipo"]); ?></td></tr>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="aviso-sesion">No has iniciado sesión.
                        <a href="../PHP/LOGIN.php">Regístrate aquí</a> para guardar tu información.
                    </p>
                <?php endif; ?>
            </div>

            <!-- NOTA FINAL -->
            <div class="ticket-totales">
                <p class="ticket-nota">Recuerda devolver el libro en la fecha indicada.</p>
                <p class="ticket-nota">El préstamo tiene una duración de <strong>3 días</strong>.</p>
                <p class="ticket-agradecimiento">¡Gracias por usar los servicios de la Biblioteca Amoxcalli!</p>
            </div>

            <div class="ticket-acciones">
                <a href="../PHP/CATALOGO.php" class="btn-regresar">Regresar al catálogo</a>
            </div>

        </div>
    </div>

    <footer>
        <div class="footer-redes">
            <p>Síguenos en nuestras redes sociales</p>
            <div class="footer-redes-links">
                <a href="https://www.facebook.com/AyuntamientodeTemixco/"><img src="../IMAGENES/Facebook.png"
                        alt="Facebook"> Facebook</a>
                <a href="https://www.instagram.com/ayuntamientodetemixco/"><img src="../IMAGENES/Instagram.png"
                        alt="Instagram"> Instagram</a>
                <a
                    href="https://www.threads.net/@ayuntamientodetemixco?xmt=AQGziTwa__iNhTN6HzJ7QUfuMemPmw3gtZIfNjpT2JE6Mw"><img
                        src="../IMAGENES/Threads.png" alt="Threads"> Threads</a>
                <a href="https://x.com/AdeTemixco2527"><img src="../IMAGENES/Twitter.png" alt="X"> Twitter</a>
            </div>
        </div>
        <div class="footer-cuerpo">
            <div class="footer-col footer-logo">
                <img src="../IMAGENES/Logo_god.png" alt="Logo Temixco">
                <p>Gobierno Municipal de Temixco, Morelos. Trabajando por un futuro próspero y seguro para nuestra
                    comunidad.</p>
            </div>
            <div class="footer-col">
                <h4>Navegación</h4>
                <ul>
                    <li><a href="../index.php">Inicio</a></li>
                    <li><a href="../HTML/MISION.html">Misión y Visión</a></li>
                    <li><a href="../HTML/TEMPORADA.html">Talleres de Temporada</a></li>
                    <li><a href="../PHP/CATALOGO.php">Catálogo</a></li>
                    <li><a href="../HTML/SERVICIOS.html">Servicios</a></li>
                    <li><a href="../HTML/CREDENCIAL.html">Credencial</a></li>
                    <li><a href="LOGIN.php">Cuenta</a></li>
                    <li><a href="../HTML/UBICACION.html">Ubicación</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contacto</h4>
                <p>Av. Miguel Hidalgo y Costilla #20<br>Pueblo, Temixco, Morelos C.P. 62580</p>
                <p>Tel: 55 4104 9360</p>
                <p>amoxcallip.viejo@gmail.com</p>
                <p>Lun–Vie 8:00am–8:00pm<br>Sáb 9:00am–1:00pm</p>
            </div>
        </div>
        <div class="footer-creditos">
            <p>&copy; 2026 H. Ayuntamiento de Temixco. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>