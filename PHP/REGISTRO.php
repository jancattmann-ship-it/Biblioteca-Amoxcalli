<?php
session_start();

$_SESSION["usuario"] = [
    "nombre"   => $_POST["nombre"],
    "email"    => $_POST["email"],
    "telefono" => $_POST["telefono"],
    "genero"   => $_POST["genero"],
    "terminos" => isset($_POST["terminos"]),
    "tipo"     => $_POST["tipo"]
];

header("Location: LOGIN.php");
exit();

echo "<title>Credencial </title>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<link rel='stylesheet'   href='../CSS/REGISTRO.css'>";
echo "<link rel='stylesheet'   href='../CSS/FOOTER.css'>";
echo "<link rel='icon' href='../IMAGENES/Fav.png' type='image/png'>";

$nombre = $_POST["nombre"];
$email = $_POST["email"];
$telefono = $_POST["telefono"];
$date = $_POST["date"];
$genero = $_POST["genero"];
$tipo = $_POST["tipo"];
$terminos = isset($_POST["terminos"]);

echo "<body><div class='contenedor'> <div class='titulo-pagina'>
        <img src='../IMAGENES/shulker.gif' alt='Shulker' class='icono-pagina'>
        <header> <h2> Registro de informacion Biblioteca </h2></header>'
        </div>";
echo "<main> Tu nombre usuario es: " . $nombre . "<br><br>";
echo "Tú email es: " . $email . "<br><br>";
echo "Tú número de teléfono es: " . $telefono . "<br><br>";
echo "Tú fecha de nacimiento es: " . $date . "<br><br>";
echo "Tú género es: " . $genero . "<br><br>";
echo "Tipo de visita: " . $tipo . "<br><br>";

if ($tipo === "administrador") {
    echo "<p><strong>Acceso de administrador:</strong> Bienvenido al panel de gestión de la biblioteca.</p>";
} else {
    echo "<p><strong>Bienvenido visitante:</strong> Tu solicitud de sesion ha sido registrada.</p>";
}
echo "Términos aceptados: " . ($terminos ? 'si' : 'no') . "</main><br><br></div>";
echo "<footer>
    <div class='footer-redes'>
    <p>Síguenos en nuestras redes sociales</p>
    <div class='footer-redes-links'>
        <a href='https://www.facebook.com/AyuntamientodeTemixco/'><img src='../IMAGENES/facebook.png' alt='Facebook'>
        Facebook</a>
        <a href='https://www.instagram.com/ayuntamientodetemixco/'><img src='../IMAGENES/instagram.png' alt='Instagram'>
        Instagram</a>
        <a href='https://www.threads.net/@ayuntamientodetemixco?xmt=AQGziTwa__iNhTN6HzJ7QUfuMemPmw3gtZIfNjpT2JE6Mw'><img
        src='../IMAGENES/threads.png' alt='Threads'> Threads</a>
        <a href='https://x.com/AdeTemixco2527'><img src='../IMAGENES/Twitter.png' alt='X'> Twitter</a>
    </div>
    </div>
    <!--3 COLUMNAS -->
    <div class='footer-cuerpo'>
    <!-- COLUMNA 1: Logo y descripción -->
    <div class='footer-col footer-logo'>
        <img src='../IMAGENES/Logo_god.png' alt='Logo Temixco'>
        <p>Gobierno Municipal de Temixco, Morelos. Trabajando por un futuro próspero y seguro para nuestra comunidad.
        </p>
    </div>
    <!-- COLUMNA 2: Navegación -->
    <div class='footer-col'>
        <h4>Navegación</h4>
        <ul>
        <li><a href='../index.php'>Inicio</a></li>
        <li><a href='../HTML/MISION.html'>Misión y Visión</a></li>
        <li><a href='../HTML/TEMPORADA.html'>Talleres de Temporada</a></li>
        <li><a href='../HTML/CATALOGO.html'>Catálogo</a></li>
        <li><a href='../HTML/SERVICIOS.html'>Servicios</a></li>
        <li><a href='../HTML/CREDENCIAL.html'>Credencial</a></li>
        <li><a href='../HTML/UBICACION.html'>Ubicación</a></li>
        </ul>
    </div>
    <!-- COLUMNA 3: Contacto -->
    <div class='footer-col'>
        <h4>Contacto</h4>
        <p>Av. Miguel Hidalgo y Costilla #20<br>
        Pueblo, Temixco, Morelos C.P. 62580</p>S
        <p>Tel: 55 4104 9360</p>
        <p>amoxcallip.viejo@gmail.com</p>
        <p>Lun–Vie 8:00am–8:00pm<br>Sáb 9:00am–1:00pm</p>
    </div>

    </div>

    <!-- CRÉDITOS -->
    <div class='footer-creditos'>
    <p>&copy; 2026 H. Ayuntamiento de Temixco. Todos los derechos reservados.</p>
    </div>
    </footer></body>";



?>