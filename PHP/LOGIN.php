<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión | Amoxcalli</title>
    <link rel="stylesheet" href="../CSS/BASE.css">
    <link rel="stylesheet" href="../CSS/LOGIN.css">
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
            <a href="PHP/LOGIN.php" class="btn-header-login">
                <img src="../IMAGENES/libro_verde.png" alt="Cuenta" class="icono-cuenta"> Mi cuenta </a>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="../HTML/MISION.html">Misión y Visión</a></li>
            <li><a href="../HTML/TEMPORADA.html">Talleres de Temporada</a></li>
            <li><a href="../HTML/CATALOGO.html">Catálogo</a></li>
            <li><a href="../HTML/SERVICIOS.html">Servicios</a></li>
            <li><a href="../HTML/HORARIO.html">Horario</a></li>
            <li><a href="../HTML/CREDENCIAL.html">Credencial</a></li>
            <li><a href="LOGIN.php" class="activo">Cuenta</a></li>
            <li><a href="../HTML/UBICACION.html">Ubicación</a></li>
            <li><a href="../HTML/PARTICIPANTES.html">Participantes</a></li>
        </ul>
    </nav>

    <main>

        <?php if (isset($_SESSION["usuario"])): ?>

            <?php $u = $_SESSION["usuario"]; ?>

            <!-- PANEL SEGÚN USUARIO -->
            <div class="titulo-pagina">
                <img src="../IMAGENES/libro_verde.png" alt="Cuenta" class="icono-pagina">
                <h2>Mi cuenta</h2>
            </div>

            <?php if ($u["tipo"] === "administrador"): ?>
                <div class="panel-admin">
                    <span class="badge-tipo">Administrador</span>
                    <p>Bienvenido al panel de administración, <strong>
                            <?php echo ($u["nombre"]); ?>
                        </strong>.
                        Desde aquí puedes gestionar los recursos de la biblioteca.</p>
                </div>
            <?php else: ?>
                <div class="panel-visitante">
                    <span class="badge-tipo">Visitante</span>
                    <p>Hola, <strong>
                            <?php echo ($u["nombre"]); ?>
                        </strong>. Tu registro ha sido guardado correctamente.</p>
                </div>
            <?php endif; ?>

            <h3>Tus datos registrados</h3>
            <table>
                <tbody>
                    <tr>
                        <td><strong>Nombre</strong></td>
                        <td>
                            <?php echo ($u["nombre"]); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Correo</strong></td>
                        <td>
                            <?php echo ($u["email"]); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Teléfono</strong></td>
                        <td>
                            <?php echo ($u["telefono"]); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Género</strong></td>
                        <td>
                            <?php echo ($u["genero"]); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Términos aceptados</strong></td>
                        <td>
                            <?php echo $u["terminos"] ? "Sí" : "No"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tipo de cuenta</strong></td>
                        <td>
                            <?php echo ($u["tipo"]); ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php
            if (isset($_POST["cerrar_sesion"])) {
                session_destroy();
                header("Location: LOGIN.php");
                exit();
            }
            ?>

            <form method="POST">
                <input type="submit" name="cerrar_sesion" value="Cerrar sesión" class="btn-cerrar-sesion">
            </form>

        <?php else: ?>

            <div class="titulo-pagina">
                <img src="../IMAGENES/Comando_Bloque.png" alt="Sesión" class="icono-pagina">
                <h2>Iniciar sesión</h2>
            </div>

            <p>Para ver tu información registrada, primero debes completar el formulario de registro en
                <a href="../index.php#registro">la página de inicio</a>.
            </p>

            <h3>Tipos de usuario</h3>
            <table>
                <thead>
                    <tr>
                        <th>Beneficio</th>
                        <th>Visitante</th>
                        <th>Administrador</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Consulta de catálogo</td>
                        <td>✔</td>
                        <td>✔</td>
                    </tr>
                    <tr>
                        <td>Apartar libros con credencial</td>
                        <td>✔</td>
                        <td>✔</td>
                    </tr>
                    <tr>
                        <td>Apartar libros sin credencial</td>
                        <td class="no-disponible">✗</td>
                        <td>✔</td>
                    </tr>
                    <tr>
                        <td>Panel de administración</td>
                        <td class="no-disponible">✗</td>
                        <td>✔</td>
                    </tr>
                </tbody>
            </table>

        <?php endif; ?>

        <a href="../index.php" class="btn-regresar">Regresar al inicio</a>
    </main>

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
                    <li><a href="../HTML/CATALOGO.html">Catálogo</a></li>
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