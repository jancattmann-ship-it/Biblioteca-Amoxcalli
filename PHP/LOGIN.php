<?php
session_start();
include_once("../PHP/SESION.php");
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
            <?php if (isset($_SESSION["usuario_activo"])): ?>
                <img src="../IMAGENES/cuenta.png" alt="Cuenta" class="icono-cuenta">
                <span class="header-usuario">
                    <?php echo htmlspecialchars($_SESSION["usuario_activo"]["nombre"]); ?>
                </span>
            <?php else: ?>
                <img src="../IMAGENES/cuenta.png" alt="Cuenta" class="icono-cuenta">
                <a href="LOGIN.php" class="btn-header-login activo">Iniciar sesión</a>
            <?php endif; ?>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="MISION.html">Misión y Visión</a></li>
            <li><a href="TEMPORADA.html">Talleres de Temporada</a></li>
            <li><a href="CATALOGO.html">Catálogo</a></li>
            <li><a href="HORARIO.html">Horario</a></li>
            <li><a href="SERVICIOS.html">Servicios</a></li>
            <li><a href="CREDENCIAL.html">Credencial</a></li>
            <li><a href="LOGIN.php" class="activo">Cuenta</a></li>
            <li><a href="UBICACION.html">Ubicación</a></li>
            <li><a href="PARTICIPANTES.html">Participantes</a></li>
        </ul>
    </nav>

    <main>

        <?php if (isset($_SESSION["usuario_activo"])):
            $u = $_SESSION["usuario_activo"]; ?>

            <!-- PANEL DE USUARIO ACTIVO -->
            <div class="titulo-pagina">
                <img src="../IMAGENES/cuenta.png" alt="Cuenta" class="icono-pagina">
                <h2>Mi cuenta</h2>
            </div>

            <?php if ($u["tipo"] === "admin"): ?>
                <div class="panel-admin">
                    <span class="badge-admin">Administrador</span>
                    <p>Bienvenido al panel de administración, <strong><?php echo htmlspecialchars($u["nombre"]); ?></strong>.
                        Desde aquí puedes gestionar los recursos de la biblioteca.</p>
                </div>
            <?php else: ?>
                <div class="panel-usuario">
                    <p>Hola, <strong><?php echo htmlspecialchars($u["nombre"]); ?></strong>. Bienvenido a tu cuenta.</p>
                </div>
            <?php endif; ?>

            <div class="tarjeta-perfil">
                <h3>Tus datos</h3>
                <table>
                    <tbody>
                        <tr>
                            <td><strong>Nombre</strong></td>
                            <td><?php echo htmlspecialchars($u["nombre"]); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Correo</strong></td>
                            <td><?php echo htmlspecialchars($u["email"]); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Teléfono</strong></td>
                            <td><?php echo htmlspecialchars($u["telefono"]); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Género</strong></td>
                            <td><?php echo htmlspecialchars($u["genero"]); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tipo de cuenta</strong></td>
                            <td><?php echo htmlspecialchars($u["tipo"]); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <form method="POST">
                <input type="submit" name="cerrar_sesion" value="Cerrar sesión" class="btn-cerrar-sesion">
            </form>

        <?php else: ?>

            <!-- FORMULARIO DE INICIO DE SESIÓN -->
            <div class="titulo-pagina">
                <img src="../IMAGENES/cuenta.png" alt="Cuenta" class="icono-pagina">
                <h2>Iniciar sesión</h2>
            </div>

            <?php if ($error_login !== ""): ?>
                <p class="mensaje-error"><?php echo $error_login; ?></p>
            <?php endif; ?>

            <form method="POST" class="formulario-credencial">
                <div class="campo">
                    <label for="email_login">Correo electrónico</label>
                    <input type="email" id="email_login" name="email_login" placeholder="Ej. correo@ejemplo.com" required>
                </div>
                <div class="campo">
                    <label for="password_login">Contraseña</label>
                    <input type="password" id="password_login" name="password_login" placeholder="Tu contraseña" required>
                </div>
                <input type="submit" name="iniciar_sesion" value="Entrar">
            </form>

            <p class="texto-registro">¿No tienes cuenta? Regístrate en la <a href="../index.php#registro">página de
                    inicio</a>.</p>

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
                    <li><a href="MISION.html">Misión y Visión</a></li>
                    <li><a href="TEMPORADA.html">Talleres de Temporada</a></li>
                    <li><a href="CATALOGO.html">Catálogo</a></li>
                    <li><a href="SERVICIOS.html">Servicios</a></li>
                    <li><a href="CREDENCIAL.html">Credencial</a></li>
                    <li><a href="LOGIN.php">Cuenta</a></li>
                    <li><a href="UBICACION.html">Ubicación</a></li>
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