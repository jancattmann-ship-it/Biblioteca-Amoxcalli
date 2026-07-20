<?php
session_start();
include_once("PHP/CONTADOR.php");
?>
<!DOCTYPE html>
<html lang="es">

<head> <!-- ENCABEZADO -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Biblioteca Amoxcalli</title>
  <link rel="stylesheet" href="CSS/BASE.css">
  <link rel="stylesheet" href="CSS/index.css">
  <link rel="icon" href="IMAGENES/Fav.png" type="image/png">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script> <!-- Libreria para sweetalert -->
  <script type="text/javascript" src="JS/MENSAJE.js" defer></script> <!-- El "defer" hace que el navegador cargue eso primero -->
</head>

<body>
  <noscript>
    <p> La página que estas viendo requiere para su funcionamiento el uso de JavaScript, si lo has desactivado
      intencionalmente, por favor vuelve a activarlo </p>
  </noscript>

  <header>
    <img src="IMAGENES/logo-temixco.png" alt="Logo Temixco">
    <div>
      <h1>Biblioteca Amoxcalli</h1>
      <p>Tu biblioteca de confianza</p>
    </div>
    <div class="header-login">
      <button type="button" id="btn-toggle-busqueda" class="btn-header-accion" aria-label="Buscar libros">
        <img src="IMAGENES/lupa.png" alt="Buscar" class="icono-header-pixel">
      </button>
      <a href="PHP/LOGIN.php" class="btn-header-login">
        <img src="IMAGENES/cuenta.png" alt="Cuenta" class="icono-header-pixel"> <span class="texto-cuenta"><?php echo isset($_SESSION["usuario"]) ? ($_SESSION["usuario"]["nombre"]) : "Mi cuenta"; ?></span></a>
      </a>
    </div>
  </header>

  <div id="barra-busqueda" class="barra-busqueda-desplegable" hidden>
    <form action="PHP/CATALOGO.php" method="get" class="form-busqueda-header">
      <input type="text" name="buscar" placeholder="Buscar libro por título..." autocomplete="off">
      <button type="submit">Buscar</button>
    </form>
  </div>
  </header>
  <nav> <!-- MENU antiguo -->
    <ul>
      <li><a href="index.php" class="activo">Inicio</a></li>
      <li><a href="HTML/MISION.html">Misión y Visión</a></li>
      <li><a href="HTML/TEMPORADA.html">Talleres de Temporada</a></li>
      <li><a href="PHP/CATALOGO.php">Catálogo</a></li>
      <li><a href="HTML/SERVICIOS.html">Servicios</a></li>
      <li><a href="HTML/HORARIO.html">Horario</a></li>
      <li><a href="HTML/CREDENCIAL.html">Credencial</a></li>
      <li><a href="PHP/LOGIN.php">Cuenta</a></li>
      <li><a href="HTML/UBICACION.html">Ubicación</a></li>
      <li>
        <a href="#">Más <span class="nav-flecha">▾</span></a> <!-- MENU despegable -->
        <ul class="dropdown">
          <li><a href="HTML/REGLAMENTO.html">Reglamento</a></li>
          <li><a href="HTML/PARTICIPANTES.html">Participantes</a></li>
          <li><a href="HTML/FAQ.html">FAQ</a></li>
          <li><a href="HTML/GALERIA.html">Galería</a></li>
        </ul>
      </li>
    </ul>
  </nav>

  <main>
    <div class="seccion-bienvenida"> <!-- BIENVENIDA -->
      <div class="bienvenida-texto">
        <h2>Bienvenido a la Biblioteca Amoxcalli</h2>
        <p>
          Somos una biblioteca pública al servicio de la comunidad de Temixco, Morelos.
          Fomentamos la lectura, el aprendizaje y la convivencia sana entre familias.
        </p>
        <p class="frase-inst">"Un gobierno cercano a la gente"</p>
      </div>
      <img src="IMAGENES/Fachada_Biblioteca.jfif" alt="Fachada Biblioteca Amoxcalli">
    </div>
    <!-- CONTADOR Y FRASE ALEATORIA -->
    <div class="bloque-bienvenida-contador">
      <p class="contador-visitas"><?php echo $mensaje_visitas; ?></p>
      <p class="frase-aleatoria"><?php echo $frase_del_dia; ?></p>
    </div>

    <h3>¿Qué deseas hacer?</h3>
    <div class="tarjetas"> <!-- TARJETAS CON ICONOS -->
      <a href="HTML/HORARIO.html" class="tarjeta fade-in-scroll">
        <img src="IMAGENES/Reloj.gif" alt="Horario">
        <p>Horario</p>
        <small>Lun–Vie 8am–7pm</small>
      </a>
      <a href="HTML/SERVICIOS.html" class="tarjeta fade-in-scroll">
        <img src="IMAGENES/cofre_ender.gif" alt="Servicios">
        <p>Servicios</p>
        <small>Ver todos</small>
      </a>
      <a href="PHP/CATALOGO.php" class="tarjeta fade-in-scroll">
        <video src="/IMAGENES/libro_Encantado.webm" class="icono-pagina" autoplay loop muted playsinline></video>
        <p>Catálogo</p>
        <small>Ver libros</small>
      </a>
      <a href="HTML/UBICACION.html" class="tarjeta fade-in-scroll">
        <img src="IMAGENES/Compas.gif" alt="Ubicación">
        <p>Ubicación</p>
        <small>Pueblo Viejo, Temixco</small>
      </a>
    </div>

    <div class="info-lateral info-lateral--rosa">
      <div class="info-lateral-imagen">
        <img src="IMAGENES/vacaciones2.jpg" alt="Mis Vacaciones en la Biblioteca 2026">
      </div>
      <div class="info-lateral-texto">
        <span class="info-lateral-etiqueta">¡Inscríbete ya!</span>
        <h3>Mis Vacaciones en la Biblioteca 2026</h3>
        <p>Del 20 al 31 de julio, de 9:00 a.m. a 12:00 p.m. Taller de lectura y actividades para niñas y niños de 7 a 13 años. Cupos limitados.</p>
        <a href="HTML/TEMPORADA.html" class="btn-regresar">Más información</a>
      </div>
    </div>

    <div class="info-lateral info-lateral--verde info-lateral--derecha">
      <div class="info-lateral-imagen">
        <img src="IMAGENES/cincuenta_años.jpg" alt="Libro del mes">
      </div>
      <div class="info-lateral-texto">
        <span class="info-lateral-etiqueta">Libro del mes</span>
        <h3>Cincuenta años de Shinzaburo Takeda en México</h3>
        <p>Shinzaburo Takeda, un artista enriquecido por la paciencia y precisión técnica de su natal Japón, y la belleza, colores y magias del mundo oaxaqueño.</p>
        <a href="PHP/CATALOGO.php?cat=nuevos" class="btn-regresar">Ver en el catálogo</a>
      </div>
    </div>
    <div class="frase-bloque"> <!-- FRASE -->
      <p>"Somos una red de apoyo para esta comunidad donde la convivencia sana y la integración familiar es lo
        principal."</p>
    </div>

    <div class="dos-columnas">
      <div class="columna">
        <h3>Horario de atención</h3>
        <table>
          <tbody>
            <tr>
              <td>Lunes a viernes</td>
              <td>8:00 a.m. – 7:00 p.m.</td>
            </tr>
            <tr>
              <td>Sábado</td>
              <td>9:00 a.m. – 1:00 p.m.</td>
            </tr>
            <tr>
              <td>Domingo</td>
              <td>Cerrado</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="columna">
        <h3>Algunos servicios</h3>
        <ul>
          <li>Consulta de libros gratuita</li>
          <li>Préstamo de libros</li>
          <li>Circulo de lectura</li>
          <li>Cafecito Literario</li>
          <li>Talleres didácticos</li>
        </ul>
      </div>
    </div>

  </main>

  <footer>
    <div class="footer-redes">
      <p>Síguenos en nuestras redes sociales</p>
      <div class="footer-redes-links">
        <a href="https://www.facebook.com/AyuntamientodeTemixco/"><img src="IMAGENES/Facebook.png" alt="Facebook">
          Facebook</a>
        <a href="https://www.instagram.com/ayuntamientodetemixco/"><img src="IMAGENES/Instagram.png" alt="Instagram">
          Instagram</a>
        <a href="https://www.threads.net/@ayuntamientodetemixco?xmt=AQGziTwa__iNhTN6HzJ7QUfuMemPmw3gtZIfNjpT2JE6Mw"><img
            src="IMAGENES/Threads.png" alt="Threads"> Threads</a>
        <a href="https://x.com/AdeTemixco2527"><img src="IMAGENES/Twitter.png" alt="X"> Twitter</a>
      </div>
    </div>
    <div class="footer-cuerpo">
      <div class="footer-col footer-logo">
        <img src="IMAGENES/Logo_god.png" alt="Logo Temixco">
        <p>Gobierno Municipal de Temixco, Morelos. Trabajando por un futuro próspero y seguro para nuestra comunidad.
        </p>
      </div>
      <div class="footer-col">
        <h4>Navegación</h4>
        <ul>
          <li><a href="index.php" class="activo">Inicio</a></li>
          <li><a href="HTML/MISION.html">Misión y Visión</a></li>
          <li><a href="HTML/TEMPORADA.html">Talleres de Temporada</a></li>
          <li><a href="PHP/CATALOGO.php">Catálogo</a></li>
          <li><a href="HTML/HORARIO.html">Horario</a></li>
          <li><a href="HTML/SERVICIOS.html">Servicios</a></li>
          <li><a href="HTML/CREDENCIAL.html">Credencial</a></li>
          <li><a href="HTML/UBICACION.html">Ubicación</a></li>
          <li><a href="HTML/PARTICIPANTES.html">Participantes</a></li>
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

  <!-- HERRAMIENTAS GLOBALES: VOLVER ARRIBA Y TAMAÑO DE TEXTO -->
  <button id="btn-volver-arriba" aria-label="Volver arriba">↑</button>
  <div class="control-tamano-texto">
    <button onclick="cambiarTamano(-2)" aria-label="Disminuir tamaño de texto">A-</button>
    <button onclick="cambiarTamano(2)" aria-label="Aumentar tamaño de texto">A+</button>
  </div>

  <script>
    document.getElementById('btn-toggle-busqueda').addEventListener('click', function () {
      var barra = document.getElementById('barra-busqueda');
      barra.hidden = !barra.hidden;
      if (!barra.hidden) {
        barra.querySelector('input').focus();
      }
    });
  </script>

  <script src="JS/HERRAMIENTAS.js"></script>

  <script src="JS/ANIMACIONES.js"></script>

</body>

</html>