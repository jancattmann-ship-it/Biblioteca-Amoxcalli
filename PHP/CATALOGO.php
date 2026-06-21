<?php
session_start();
/** @var mysqli $con */
include_once("CONEXION.php");

// Obtener libros de la BD 
$resultado = mysqli_query($con, "SELECT * FROM libros ORDER BY titulo ASC");

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Catálogo de Libros | Amoxcalli</title>
  <link rel="stylesheet" href="../CSS/BASE.css">
  <link rel="stylesheet" href="../CSS/CATALOGO.css">
  <link rel="icon" href="../IMAGENES/Fav.png" type="image/png">
  <script type="text/javascript" src="../JS/MENSAJE2.js"></script>
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
        <?php echo isset($_SESSION["usuario"]) ? ($_SESSION["usuario"]["nombre"]) : "Mi cuenta"; ?>
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

  <main>
    <div class="titulo-pagina">
      <img src="../IMAGENES/libro_Encantado.gif" alt="Catalogo" class="icono-pagina">
      <h2>Catálogo de Libros</h2>
    </div>

    <div class="aviso-colores">
      <p><b>Filtra visualmente por género usando los colores:</b></p>
      <div class="leyendas">
        <span class="leyenda politica">Política y Sociedad</span>
        <span class="leyenda literatura">Literatura y Arte</span>
        <span class="leyenda educacion">Educación y Ciencia</span>
        <span class="leyenda economia">Economía y Desarrollo</span>
        <span class="leyenda historia">Historia y Cultura</span>
      </div>
    </div>

    <div class="buscador-wrap">
      <input type="text" id="buscador" placeholder="Buscar libro..." oninput="filtrar()">
      <select id="filtro-genero" onchange="filtrar()">
        <option value="todos">Todos los géneros</option>
        <option value="politica">Política y Sociedad</option>
        <option value="literatura">Literatura y Arte</option>
        <option value="educacion">Educación y Ciencia</option>
        <option value="economia">Economía y Desarrollo</option>
        <option value="historia">Historia y Cultura</option>
      </select>
    </div>

    <div class="banner-nuevos">
      Nuevas Adquisiciones - Mayo 2026
    </div>

    <div class="catalogo">
      <?php while ($libro = mysqli_fetch_assoc($resultado)): ?>

        <?php
        // Verificar si el libro ya está apartado
        $stmt_disp = mysqli_prepare($con, "SELECT id FROM saca WHERE cod_libro = ? AND fecha_devuelto IS NULL");
        mysqli_stmt_bind_param($stmt_disp, "s", $libro['cod_libro']);
        mysqli_stmt_execute($stmt_disp);
        mysqli_stmt_store_result($stmt_disp);
        $ocupado = mysqli_stmt_num_rows($stmt_disp) > 0;
        mysqli_stmt_close($stmt_disp);
        ?>

        <div class="card <?php echo ($libro['categoria']); ?>">
          <img src="../IMAGENES/<?php echo ($libro['imagen']); ?>" alt="<?php echo ($libro['titulo']); ?>">
          <div class="titulo"><?php echo ($libro['titulo']); ?></div>
          <div class="descripcion">
            Tema: <?php echo ucfirst(($libro['categoria'])); ?>
          </div>

          <?php if ($ocupado): ?>
            <div class="sin-sesion">
              <p class="disponibilidad no-disponible">No disponible</p>
              <span class="btn-reservar btn-no-disponible">No disponible</span>
            </div>
          <?php elseif (isset($_SESSION["usuario"])): ?>
            <form action="../PHP/RESERVAR.php" method="post">
              <input type="hidden" name="libro" value="<?php echo ($libro['titulo']); ?>">
              <input type="hidden" name="cantidad" value="1">
              <p class="disponibilidad">1 ejemplar disponible</p>
              <input type="submit" class="btn-reservar" value="Apartar">
            </form>
          <?php else: ?>
            <div class="sin-sesion">
              <p class="disponibilidad">1 ejemplar disponible</p>
              <a href="../PHP/LOGIN.php" class="btn-reservar">Inicia sesión para apartar</a>
            </div>
          <?php endif; ?>

        </div>
      <?php endwhile; ?>
      <?php mysqli_close($con); ?>
    </div>

    <a href="../index.php" class="btn-regresar">Regresar al inicio</a>
  </main>

  <footer>
    <div class="footer-redes">
      <p>Síguenos en nuestras redes sociales</p>
      <div class="footer-redes-links">
        <a href="https://www.facebook.com/AyuntamientodeTemixco/"><img src="../IMAGENES/Facebook.png" alt="Facebook">
          Facebook</a>
        <a href="https://www.instagram.com/ayuntamientodetemixco/"><img src="../IMAGENES/Instagram.png" alt="Instagram">
          Instagram</a>
        <a href="https://www.threads.net/@ayuntamientodetemixco?xmt=AQGziTwa__iNhTN6HzJ7QUfuMemPmw3gtZIfNjpT2JE6Mw"><img
            src="../IMAGENES/Threads.png" alt="Threads"> Threads</a>
        <a href="https://x.com/AdeTemixco2527"><img src="../IMAGENES/Twitter.png" alt="X"> Twitter</a>
      </div>
    </div>
    <div class="footer-cuerpo">
      <div class="footer-col footer-logo">
        <img src="../IMAGENES/Logo_god.png" alt="Logo Temixco">
        <p>Gobierno Municipal de Temixco, Morelos. Trabajando por un futuro próspero y seguro para nuestra comunidad.
        </p>
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
          <li><a href="../PHP/LOGIN.php">Cuenta</a></li>
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

  <!-- JAVASCRIPT BUSCADOR Y FILTRO -->
  <script>
    function filtrar() {
      var busqueda = document.getElementById('buscador').value.toLowerCase();
      var genero = document.getElementById('filtro-genero').value;
      var tarjetas = document.querySelectorAll('.card');

      tarjetas.forEach(function(card) {
        var titulo = card.querySelector('.titulo').textContent.toLowerCase();
        var coincideBusqueda = titulo.includes(busqueda);
        var coincideGenero = genero === 'todos' || card.classList.contains(genero);

        if (coincideBusqueda && coincideGenero) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    }
  </script>

  <!-- HERRAMIENTAS GLOBALES: VOLVER ARRIBA Y TAMAÑO DE TEXTO -->
  <button id="btn-volver-arriba" aria-label="Volver arriba">↑</button>
  <div class="control-tamano-texto">
    <button onclick="cambiarTamano(-2)" aria-label="Disminuir tamaño de texto">A-</button>
    <button onclick="cambiarTamano(2)" aria-label="Aumentar tamaño de texto">A+</button>
  </div>
  <script src="../JS/HERRAMIENTAS.js"></script>
</body>

</html>