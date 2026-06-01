<?php
session_start();

$libro = $_POST["libro"];
$fecha_prestamo = date("d/m/Y");
$fecha_devolucion = date("d/m/Y", strtotime("+3 days"));

echo "<title>Ticket de Préstamo | Amoxcalli</title>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<link rel='stylesheet' href='../CSS/REGISTRO.css'>";
echo "<link rel='stylesheet' href='../CSS/BASE.css'>";
echo "<link rel='stylesheet' href='../CSS/RESERVAR.css'>";
echo "<link rel='icon' href='../IMAGENES/Fav.png' type='image/png'>";

echo "<body>";
echo "<div class='contenedor-ticket-wrapper'>";
echo "<div class='ticket-prestamo'>";

// ENCABEZADO DEL TICKET
echo "<div class='ticket-header'>
        <img src='../IMAGENES/libro_Encantado.gif' alt='Préstamo' class='icono-pagina'>
        <h2>Ticket de Préstamo</h2>
        </div>";

// SECCIÓN LIBRO
echo "<div class='ticket-seccion'>
        <div class='ticket-seccion-titulo'>Libro apartado</div>
        <table>
            <tbody>
                <tr><td><strong>Título</strong></td><td>" . htmlspecialchars($libro) . "</td></tr>
                <tr><td><strong>Fecha de préstamo</strong></td><td>" . $fecha_prestamo . "</td></tr>
                <tr><td><strong>Fecha de devolución</strong></td><td>" . $fecha_devolucion . "</td></tr>
                <tr><td><strong>Cantidad</strong></td><td>1 ejemplar</td></tr>
            </tbody>
        </table>
        </div>";

// SECCIÓN USUARIO
echo "<div class='ticket-seccion'>";
echo "<div class='ticket-seccion-titulo'>Datos del solicitante</div>";

if (isset($_SESSION["usuario"])) {
    $u = $_SESSION["usuario"];
    echo "<table>
            <tbody>
                <tr><td><strong>Nombre</strong></td><td>" . htmlspecialchars($u["nombre"]) . "</td></tr>
                <tr><td><strong>Correo</strong></td><td>" . htmlspecialchars($u["email"]) . "</td></tr>
                <tr><td><strong>Teléfono</strong></td><td>" . htmlspecialchars($u["telefono"]) . "</td></tr>
                <tr><td><strong>Tipo de cuenta</strong></td><td>" . htmlspecialchars($u["tipo"]) . "</td></tr>
            </tbody>
        </table>";
} else {
    echo "<p class='aviso-sesion'>No has iniciado sesión. 
        <a href='../PHP/LOGIN.php'>Regístrate aquí</a> para guardar tu información.</p>";
}

echo "</div>";

// NOTA FINAL CON ESTILO TICKET
echo "<div class='ticket-totales'>
        <p class='ticket-nota'>Recuerda devolver el libro en la fecha indicada.</p>
        <p class='ticket-nota'>El préstamo tiene una duración de <strong>3 días</strong>.</p>
        <p class='ticket-agradecimiento'>¡Gracias por usar los servicios de la Biblioteca Amoxcalli!</p>
    </div>";

echo "<div class='ticket-acciones'>
        <a href='../HTML/CATALOGO.html' class='btn-regresar'>Regresar al catálogo</a>
    </div>";

echo "</div>"; // ticket-prestamo
echo "</div>"; // contenedor-ticket-wrapper

// FOOTER
echo "<footer>
    <div class='footer-redes'>
        <p>Síguenos en nuestras redes sociales</p>
        <div class='footer-redes-links'>
            <a href='https://www.facebook.com/AyuntamientodeTemixco/'><img src='../IMAGENES/Facebook.png' alt='Facebook'> Facebook</a>
            <a href='https://www.instagram.com/ayuntamientodetemixco/'><img src='../IMAGENES/Instagram.png' alt='Instagram'> Instagram</a>
            <a href='https://www.threads.net/@ayuntamientodetemixco?xmt=AQGziTwa__iNhTN6HzJ7QUfuMemPmw3gtZIfNjpT2JE6Mw'><img src='../IMAGENES/Threads.png' alt='Threads'> Threads</a>
            <a href='https://x.com/AdeTemixco2527'><img src='../IMAGENES/Twitter.png' alt='X'> Twitter</a>
        </div>
    </div>
    <div class='footer-cuerpo'>
        <div class='footer-col footer-logo'>
            <img src='../IMAGENES/Logo_god.png' alt='Logo Temixco'>
            <p>Gobierno Municipal de Temixco, Morelos. Trabajando por un futuro próspero y seguro para nuestra comunidad.</p>
        </div>
        <div class='footer-col'>
            <h4>Navegación</h4>
            <ul>
                <li><a href='../index.php'>Inicio</a></li>
                <li><a href='../HTML/CATALOGO.html'>Catálogo</a></li>
                <li><a href='../PHP/LOGIN.php'>Mi cuenta</a></li>
                <li><a href='../HTML/UBICACION.html'>Ubicación</a></li>
            </ul>
        </div>
        <div class='footer-col'>
            <h4>Contacto</h4>
            <p>Av. Miguel Hidalgo y Costilla #20<br>Pueblo, Temixco, Morelos C.P. 62580</p>
            <p>Tel: 55 4104 9360</p>
            <p>amoxcallip.viejo@gmail.com</p>
            <p>Lun–Vie 8:00am–8:00pm<br>Sáb 9:00am–1:00pm</p>
        </div>
    </div>
    <div class='footer-creditos'>
        <p>&copy; 2026 H. Ayuntamiento de Temixco. Todos los derechos reservados.</p>
    </div>
</footer>";

echo "</body>";
?>