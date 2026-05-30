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
  <script type="text/javascript" src="JS/MENSAJE.js"> </script>
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
  </header>

  <nav> <!-- MENU -->
    <ul>
      <li><a href="index.php" class="activo">Inicio</a></li>
      <li><a href="HTML/MISION.html">Misión y Visión</a></li>
      <li><a href="HTML/TEMPORADA.html">Talleres de Temporada </a></li>
      <li><a href="HTML/CATALOGO.html">Catálogo</a></li>
      <li><a href="HTML/HORARIO.html">Horario</a></li>
      <li><a href="HTML/SERVICIOS.html">Servicios</a></li>
      <li><a href="HTML/CREDENCIAL.html">Credencial</a></li>
      <li><a href="HTML/UBICACION.html">Ubicación</a></li>
      <li><a href="HTML/PARTICIPANTES.html">Participantes</a></li>
    </ul>
  </nav>

  <main>
    <!-- CONTADOR Y FRASE ALEATORIA -->
    <div class="bloque-bienvenida-contador">
      <p class="contador-visitas"><?php echo $mensaje_visitas; ?></p>
      <p class="frase-aleatoria"><?php echo $frase_del_dia; ?></p>
    </div>

    <div class="seccion-bienvenida"> <!-- BIENVENIDA -->
      <div class="bienvenida-texto">
        <h2>Bienvenido a la Biblioteca Amoxcalli</h2>
        <p>
          Somos una biblioteca pública al servicio de la comunidad de Temixco, Morelos.
          Fomentamos la lectura, el aprendizaje y la convivencia sana entre familias.
        </p>
        <p class="frase-inst">"Un gobierno cercano a la gente"</p>
      </div>
      <img src="IMAGENES/Amoxcalli.jpg" alt="Fachada Biblioteca Amoxcalli">
    </div>

    <h3>¿Qué deseas hacer?</h3>
    <div class="tarjetas"> <!-- TARJETAS CON ICONOS -->
      <a href="HTML/HORARIO.html" class="tarjeta">
        <img src="IMAGENES/Reloj.gif" alt="Horario">
        <p>Horario</p>
        <small>Lun–Vie 8am–7pm</small>
      </a>
      <a href="HTML/SERVICIOS.html" class="tarjeta">
        <img src="IMAGENES/cofre_ender.gif" alt="Servicios">
        <p>Servicios</p>
        <small>Ver todos</small>
      </a>
      <a href="HTML/CATALOGO.html" class="tarjeta">
        <img src="IMAGENES/libro_Encantado.gif" alt="Catálogo">
        <p>Catálogo</p>
        <small>Ver libros</small>
      </a>
      <a href="HTML/UBICACION.html" class="tarjeta">
        <img src="IMAGENES/Compas.gif" alt="Ubicación">
        <p>Ubicación</p>
        <small>Pueblo Viejo, Temixco</small>
      </a>
    </div>

    <div class="frase-bloque"> <!-- FRASE -->
      <p>"Somos una red de apoyo para esta comunidad donde la convivencia sana y la integración familiar es lo principal."</p>
    </div>

    <div class="dos-columnas">
      <div class="columna">
        <h3>Horario de atención</h3>
        <table>
          <tbody>
            <tr><td>Lunes a viernes</td><td>8:00 a.m. – 7:00 p.m.</td></tr>
            <tr><td>Sábado</td><td>9:00 a.m. – 1:00 p.m.</td></tr>
            <tr><td>Domingo</td><td>Cerrado</td></tr>
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

    <!-- FORMULARIO DE REGISTRO -->
    <div class="formulario-seccion" id="registro">
      <div class="formulario-titulo">
        <h3>Crear una cuenta</h3>
        <p>Regístrate para acceder a todos los servicios de la biblioteca.</p>
      </div>

      <?php if ($exito_registro !== ""): ?>
        <p class="mensaje-exito"><?php echo $exito_registro; ?></p>
      <?php endif; ?>
      <?php if ($error_registro !== ""): ?>
        <p class="mensaje-error"><?php echo $error_registro; ?></p>
      <?php endif; ?>

      <?php if (!isset($_SESSION["usuario_activo"])): ?>
        <form method="POST" action="index.php#registro" class="formulario-credencial">

          <div class="campo">
            <label for="nombre">Nombre completo</label>
            <input type="text" id="nombre" name="nombre" placeholder="Ej. Juan Carlos Bodoque" required>
          </div>

          <div class="campo">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" placeholder="Ej. correo@ejemplo.com" required>
          </div>

          <div class="campo">
            <label for="telefono">Número de teléfono</label>
            <input type="tel" id="telefono" name="telefono" placeholder="Ej. 7771234567"
              pattern="[0-9]{10}" maxlength="10" required>
          </div>

          <div class="campo">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password"
              placeholder="Mínimo 6 caracteres" required>
          </div>

          <div class="campo">
            <label>Género</label>
            <div class="radio-grupo">
              <label class="radio-opcion">
                <input type="radio" name="genero" value="masculino" required checked> Masculino
              </label>
              <label class="radio-opcion">
                <input type="radio" name="genero" value="femenino"> Femenino
              </label>
            </div>
          </div>

          <div class="campo">
            <label class="checkbox-opcion">
              <input type="checkbox" name="terminos" id="terminos" required>
              Acepto los términos y políticas de privacidad
            </label>
          </div>

          <input type="submit" name="registrar" value="Crear cuenta">
          <input type="reset" name="limpiar" value="Borrar datos">

        </form>

        <p class="texto-registro">¿Ya tienes cuenta? <a href="HTML/LOGIN.php">Inicia sesión aquí</a>.</p>

      <?php else: ?>
        <p>Ya tienes sesión iniciada como <strong><?php echo htmlspecialchars($_SESSION["usuario_activo"]["nombre"]); ?></strong>.
          <a href="HTML/LOGIN.php">Ir a mi cuenta</a>.
        </p>
      <?php endif; ?>

    </div>

  </main>

  <footer>
    <div class="footer-redes">
      <p>Síguenos en nuestras redes sociales</p>
      <div class="footer-redes-links">
        <a href="https://www.facebook.com/AyuntamientodeTemixco/"><img src="IMAGENES/Facebook.png" alt="Facebook"> Facebook</a>
        <a href="https://www.instagram.com/ayuntamientodetemixco/"><img src="IMAGENES/Instagram.png" alt="Instagram"> Instagram</a>
        <a href="https://www.threads.net/@ayuntamientodetemixco?xmt=AQGziTwa__iNhTN6HzJ7QUfuMemPmw3gtZIfNjpT2JE6Mw"><img src="IMAGENES/Threads.png" alt="Threads"> Threads</a>
        <a href="https://x.com/AdeTemixco2527"><img src="IMAGENES/Twitter.png" alt="X"> Twitter</a>
      </div>
    </div>
    <div class="footer-cuerpo">
      <div class="footer-col footer-logo">
        <img src="IMAGENES/Logo_god.png" alt="Logo Temixco">
        <p>Gobierno Municipal de Temixco, Morelos. Trabajando por un futuro próspero y seguro para nuestra comunidad.</p>
      </div>
      <div class="footer-col">
        <h4>Navegación</h4>
        <ul>
          <li><a href="index.php" class="activo">Inicio</a></li>
          <li><a href="HTML/MISION.html">Misión y Visión</a></li>
          <li><a href="HTML/TEMPORADA.html">Talleres de Temporada</a></li>
          <li><a href="HTML/CATALOGO.html">Catálogo</a></li>
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

</body>
</html>