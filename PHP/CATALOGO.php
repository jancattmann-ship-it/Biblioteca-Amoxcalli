<?php
session_start();
/** @var mysqli $con */
include_once("CONEXION.php");

// Convierte un color hex (#RRGGBB) a un rgba() suave para el fondo de la tarjeta
function tinte_color($hex, $alpha = 0.08)
{
  if (!$hex) return '';
  $hex = ltrim($hex, '#');
  if (strlen($hex) !== 6) return '';
  $r = hexdec(substr($hex, 0, 2));
  $g = hexdec(substr($hex, 2, 2));
  $b = hexdec(substr($hex, 4, 2));
  return "background-color: rgba($r,$g,$b,$alpha); border-color: #$hex;";
}

// Decide si el texto debe ser blanco o negro según qué tan clara es la categoria
function texto_contraste($hex)
{
  if (!$hex) return '#C9A96E'; // valor por defecto si no hay color
  $hex = ltrim($hex, '#');
  if (strlen($hex) !== 6) return '#C9A96E';
  $r = hexdec(substr($hex, 0, 2));
  $g = hexdec(substr($hex, 2, 2));
  $b = hexdec(substr($hex, 4, 2));
  // Fórmula de luminancia percibida
  $luminancia = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
  return $luminancia > 0.6 ? '#1a3e1f' : '#ffffff';
}

$termino_busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

$slug_categoria = isset($_GET['cat']) ? trim($_GET['cat']) : '';
$slug_subcategoria = isset($_GET['sub']) ? trim($_GET['sub']) : '';
$slug_tema = isset($_GET['tema']) ? trim($_GET['tema']) : '';

$categoria_actual = null;
$subcategoria_actual = null;
$tema_actual = null;

$subcategorias = [];   // subcategorías de la categoría actual (para grid o filtro)
$temas = [];           // temas de la subcategoría actual (para filtro)
$categorias = null;
$resultado = null;

// Categorías especiales que usan el filtro directo (estilo "Nuevos"),
// en vez del grid de subcategorías con tarjetas
$categorias_filtro_directo = ['nuevos', 'fce', 'fedem'];


if ($termino_busqueda !== '') {
  // Búsqueda global por título, sin importar categoría
  $like = '%' . $termino_busqueda . '%';
  $stmt_buscar = mysqli_prepare($con, "SELECT l.*, c.nombre AS cat_nombre, c.slug AS cat_slug, sc.nombre AS subcat_nombre, sc.slug AS subcat_slug, sc.color AS subcat_color
        FROM libros l
        LEFT JOIN categorias c ON l.id_categoria = c.id_categoria
        LEFT JOIN subcategorias sc ON l.id_subcategoria = sc.id_subcategoria
        WHERE l.titulo LIKE ?
        ORDER BY l.titulo ASC");
  mysqli_stmt_bind_param($stmt_buscar, "s", $like);
  mysqli_stmt_execute($stmt_buscar);
  $resultado = mysqli_stmt_get_result($stmt_buscar);
} elseif ($slug_categoria !== '') {
  // Buscar la categoría por slug
  $stmt_cat = mysqli_prepare($con, "SELECT * FROM categorias WHERE slug = ?");
  mysqli_stmt_bind_param($stmt_cat, "s", $slug_categoria);
  mysqli_stmt_execute($stmt_cat);
  $res_cat = mysqli_stmt_get_result($stmt_cat);
  $categoria_actual = mysqli_fetch_assoc($res_cat);
  mysqli_stmt_close($stmt_cat);

  // Si el slug no existe, regresamos a la vista de categorías
  if (!$categoria_actual) {
    header("Location: CATALOGO.php");
    exit();
  }

  $es_filtro_directo = in_array($categoria_actual['slug'], $categorias_filtro_directo);

  // Subcategorías de esta categoría
  $stmt_subcats = mysqli_prepare($con, "SELECT * FROM subcategorias WHERE id_categoria = ? ORDER BY orden ASC");
  mysqli_stmt_bind_param($stmt_subcats, "i", $categoria_actual['id_categoria']);
  mysqli_stmt_execute($stmt_subcats);
  $res_subcats = mysqli_stmt_get_result($stmt_subcats);
  $subcategorias = mysqli_fetch_all($res_subcats, MYSQLI_ASSOC);
  mysqli_stmt_close($stmt_subcats);

  if (!$es_filtro_directo && !empty($subcategorias) && $slug_subcategoria === '') {
    // VISTA GRID DE SUBCATEGORÍAS (ej. Ciencias -> Biología/Física)
    // No se hace ninguna consulta de libros aquí, solo se muestra el grid más abajo.

  } elseif (!$es_filtro_directo && $slug_subcategoria !== '') {
    // Se eligió una subcategoría específica (ej. Biología) -> buscarla
    $stmt_sub = mysqli_prepare($con, "SELECT * FROM subcategorias WHERE slug = ? AND id_categoria = ?");
    mysqli_stmt_bind_param($stmt_sub, "si", $slug_subcategoria, $categoria_actual['id_categoria']);
    mysqli_stmt_execute($stmt_sub);
    $res_sub = mysqli_stmt_get_result($stmt_sub);
    $subcategoria_actual = mysqli_fetch_assoc($res_sub);
    mysqli_stmt_close($stmt_sub);

    if (!$subcategoria_actual) {
      header("Location: CATALOGO.php?cat=" . urlencode($categoria_actual['slug']));
      exit();
    }

    // Temas de esta subcategoría (para el filtro tipo "Nuevos")
    $stmt_temas = mysqli_prepare($con, "SELECT * FROM temas WHERE id_subcategoria = ? ORDER BY orden ASC");
    mysqli_stmt_bind_param($stmt_temas, "i", $subcategoria_actual['id_subcategoria']);
    mysqli_stmt_execute($stmt_temas);
    $res_temas = mysqli_stmt_get_result($stmt_temas);
    $temas = mysqli_fetch_all($res_temas, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt_temas);

    // Libros de esta subcategoría, con datos de su tema (si tiene)
    $stmt_libros = mysqli_prepare($con, "SELECT l.*, t.nombre AS tema_nombre, t.slug AS tema_slug, t.color AS tema_color
          FROM libros l
          LEFT JOIN temas t ON l.id_tema = t.id_tema
          WHERE l.id_subcategoria = ?
          ORDER BY l.titulo ASC");
    mysqli_stmt_bind_param($stmt_libros, "i", $subcategoria_actual['id_subcategoria']);
    mysqli_stmt_execute($stmt_libros);
    $resultado = mysqli_stmt_get_result($stmt_libros);
  } else {
    // Categoría de filtro directo (Nuevos) O categoría sin subcategorías -> listado normal
    $stmt_libros = mysqli_prepare($con, "SELECT l.*, sc.nombre AS subcat_nombre, sc.slug AS subcat_slug, sc.color AS subcat_color
          FROM libros l
          LEFT JOIN subcategorias sc ON l.id_subcategoria = sc.id_subcategoria
          WHERE l.id_categoria = ?
          ORDER BY l.titulo ASC");
    mysqli_stmt_bind_param($stmt_libros, "i", $categoria_actual['id_categoria']);
    mysqli_stmt_execute($stmt_libros);
    $resultado = mysqli_stmt_get_result($stmt_libros);
  }
} else {
  // Vista 1: todas las categorías
  $categorias = mysqli_query($con, "SELECT * FROM categorias ORDER BY orden ASC");
}

// Determina si en esta carga se debe mostrar el grid de subcategorías (en vez del listado de libros)
$mostrar_grid_subcategorias = $categoria_actual
  && !in_array($categoria_actual['slug'], $categorias_filtro_directo)
  && !empty($subcategorias)
  && $slug_subcategoria === '';

// El filtro de temas/leyenda solo aplica si: es la categoría de filtro directo (Nuevos),
// o si estamos dentro de una subcategoría que tiene temas
$filtro_activo_items = [];
if ($categoria_actual && in_array($categoria_actual['slug'], $categorias_filtro_directo)) {
  $filtro_activo_items = $subcategorias;
} elseif ($subcategoria_actual) {
  $filtro_activo_items = $temas;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $subcategoria_actual ? htmlspecialchars($subcategoria_actual['nombre']) . " | " : ($categoria_actual ? htmlspecialchars($categoria_actual['nombre']) . " | " : ($termino_busqueda !== '' ? 'Búsqueda | ' : '')); ?>Catálogo | Amoxcalli</title>
  <link rel="stylesheet" href="../CSS/BASE.css">
  <link rel="stylesheet" href="../CSS/CATALOGO.css">
  <script src="../JS/ANIMACIONES.js" defer></script>
  <link rel="icon" href="../IMAGENES/Fav.png" type="image/png">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
  <script type="text/javascript" src="../JS/MENSAJE_FILTRO.js" defer></script>
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
        <img src="../IMAGENES/cuenta.png" alt="Cuenta" class="icono-header-pixel"> <span class="texto-cuenta"><?php echo isset($_SESSION["usuario"]) ? ($_SESSION["usuario"]["nombre"]) : "Mi cuenta"; ?></span></a>
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
      <li>
        <a href="#">Más <span class="nav-flecha">▾</span></a>
        <ul class="dropdown">
          <li><a href="../HTML/REGLAMENTO.html">Reglamento</a></li>
          <li><a href="../HTML/PARTICIPANTES.html">Participantes</a></li>
          <li><a href="../HTML/FAQ.html">FAQ</a></li>
          <li><a href="../HTML/GALERIA.html">Galería</a></li>
        </ul>
      </li>
    </ul>
  </nav>

  <main<?php echo ($categoria_actual && !$mostrar_grid_subcategorias) ? '' : ' class="catalogo-main"'; ?>>

    <div class="titulo-pagina">
      <video src="../IMAGENES/libro_Encantado.webm" class="icono-pagina" autoplay loop muted playsinline></video>
      <h2>
        <?php if ($subcategoria_actual): ?>
          <a href="CATALOGO.php" class="titulo-breadcrumb-link">Catálogo de libros</a>
          <span class="titulo-breadcrumb-separador">›</span>
          <a href="CATALOGO.php?cat=<?php echo urlencode($categoria_actual['slug']); ?>" class="titulo-breadcrumb-link"><?php echo htmlspecialchars($categoria_actual['nombre']); ?></a>
          <span class="titulo-breadcrumb-separador">›</span>
          <?php echo htmlspecialchars($subcategoria_actual['nombre']); ?>
        <?php elseif ($categoria_actual): ?>
          <a href="CATALOGO.php" class="titulo-breadcrumb-link">Catálogo de libros</a>
          <span class="titulo-breadcrumb-separador">›</span>
          <?php echo htmlspecialchars($categoria_actual['nombre']); ?>
        <?php elseif ($termino_busqueda !== ''): ?>
          <a href="CATALOGO.php" class="titulo-breadcrumb-link">Catálogo de libros</a>
          <span class="titulo-breadcrumb-separador">›</span>
          Búsqueda
        <?php else: ?>
          Catálogo de Libros
        <?php endif; ?>
      </h2>
    </div>

    <?php if (!$categoria_actual && $termino_busqueda === ''): ?>

      <!-- VISTA 1: TODAS LAS CATEGORÍAS -->
      <p>Elige una categoría para ver los libros disponibles.</p>

      <div class="categorias-grid">
        <?php while ($cat = mysqli_fetch_assoc($categorias)): ?>
          <a href="CATALOGO.php?cat=<?php echo urlencode($cat['slug']); ?>"
            class="categoria-tarjeta fade-in"
            style="--color-cat: <?php echo htmlspecialchars($cat['color'] ?: '#2e6b35'); ?>; border-left-color: <?php echo htmlspecialchars($cat['color'] ?: '#2e6b35'); ?>;">
            <img src="../IMAGENES/<?php echo $cat['imagen'] ? ($cat['imagen']) : 'libro_verde.png'; ?>"
              alt="<?php echo ($cat['nombre']); ?>">
            <div class="categoria-tarjeta-texto">
              <p class="categoria-tarjeta-nombre"><?php echo ($cat['nombre']); ?></p>
              <p class="categoria-tarjeta-desc"><?php echo ($cat['descripcion'] ?: 'Ver libros'); ?></p>
            </div>
          </a>
        <?php endwhile; ?>
        <?php mysqli_close($con); ?>
      </div>

    <?php elseif ($mostrar_grid_subcategorias): ?>

      <!-- VISTA 2: GRID DE SUBCATEGORÍAS (ej. Ciencias -> Biología / Física) -->
      <p>Elige un tema para ver los libros disponibles.</p>

      <div class="categorias-grid">
        <?php foreach ($subcategorias as $sc): ?>
          <a href="CATALOGO.php?cat=<?php echo urlencode($categoria_actual['slug']); ?>&sub=<?php echo urlencode($sc['slug']); ?>"
            class="categoria-tarjeta fade-in"
            style="--color-cat: <?php echo htmlspecialchars($sc['color'] ?: '#2e6b35'); ?>; border-left-color: <?php echo htmlspecialchars($sc['color'] ?: '#2e6b35'); ?>;">
            <img src="../IMAGENES/<?php echo $sc['imagen'] ? ($sc['imagen']) : 'libro_verde.png'; ?>" alt="<?php echo ($sc['nombre']); ?>">
            <div class="categoria-tarjeta-texto">
              <p class="categoria-tarjeta-nombre"><?php echo ($sc['nombre']); ?></p>
              <p class="categoria-tarjeta-desc">Ver libros</p>
            </div>
          </a>
        <?php endforeach; ?>
        <?php mysqli_close($con); ?>
      </div>

    <?php else: ?>

      <!-- VISTA 3: LISTADO DE LIBROS (categoría directa, o subcategoría/tema ya elegidos) -->

      <?php if (!empty($filtro_activo_items)): ?>
        <div class="aviso-colores">
          <p><b>Filtra visualmente por tema usando los colores:</b></p>
          <div class="leyendas">
            <?php foreach ($filtro_activo_items as $item): ?>
              <span class="leyenda" style="background-color: <?php echo ($item['color'] ?: '#888888'); ?>;">
                <?php echo ($item['nombre']); ?>
              </span>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <div class="buscador-wrap">
        <input type="text" id="buscador" placeholder="Buscar libro..." oninput="filtrar()">

        <?php if (!empty($filtro_activo_items)): ?>
          <select id="filtro-genero" onchange="filtrar()">
            <option value="todos">Todos los temas</option>
            <?php foreach ($filtro_activo_items as $item): ?>
              <option value="<?php echo ($item['slug']); ?>"><?php echo ($item['nombre']); ?></option>
            <?php endforeach; ?>
          </select>
        <?php endif; ?>

        <select id="orden" onchange="filtrar()">
          <option value="az">Título A–Z</option>
          <option value="za">Título Z–A</option>
        </select>
        <div class="vista-toggle">
          <button id="btn-cuadricula" class="btn-vista activo-vista" onclick="setVista('cuadricula')" title="Vista cuadrícula">⊞</button>
          <button id="btn-lista" class="btn-vista" onclick="setVista('lista')" title="Vista lista">☰</button>
        </div>
      </div>

      <?php
      $nombre_banner = $subcategoria_actual ? $subcategoria_actual['nombre'] : ($categoria_actual ? $categoria_actual['nombre'] : null);
      $color_banner = $subcategoria_actual ? ($subcategoria_actual['color'] ?: '#1a3e1f') : ($categoria_actual ? ($categoria_actual['color'] ?: '#1a3e1f') : '#1a3e1f');
      ?>
      <div class="banner-nuevos" style="background-color: <?php echo htmlspecialchars($color_banner); ?>; color: <?php echo texto_contraste($color_banner); ?>;">
        <?php echo $nombre_banner ? htmlspecialchars($nombre_banner) : 'Resultados para: "' . htmlspecialchars($termino_busqueda) . '"'; ?>
      </div>

      <?php if ($termino_busqueda !== '' && mysqli_num_rows($resultado) === 0): ?>
        <p style="text-align:center; color:#777; padding: 30px 0;">
          No encontramos libros con el título "<?php echo htmlspecialchars($termino_busqueda); ?>".
        </p>
      <?php endif; ?>

      <div class="catalogo" id="catalogo">
        <?php while ($libro = mysqli_fetch_assoc($resultado)): ?>

          <?php
          $stmt_disp = mysqli_prepare($con, "SELECT id FROM saca WHERE cod_libro = ? AND fecha_devuelto IS NULL");
          mysqli_stmt_bind_param($stmt_disp, "s", $libro['cod_libro']);
          mysqli_stmt_execute($stmt_disp);
          mysqli_stmt_store_result($stmt_disp);
          $ocupado = mysqli_stmt_num_rows($stmt_disp) > 0;
          mysqli_stmt_close($stmt_disp);

          // La clase de color de la tarjeta puede venir de subcat (filtro directo) o de tema (dentro de subcategoría)
          $clase_filtro = $libro['subcat_slug'] ?? ($libro['tema_slug'] ?? '');
          $color_filtro = $libro['subcat_color'] ?? ($libro['tema_color'] ?? null);
          $estilo_tarjeta = tinte_color($color_filtro);

          $nombre_tema_libro = $libro['subcat_nombre'] ?? ($libro['tema_nombre'] ?? null);
          $nombre_fallback = $subcategoria_actual ? $subcategoria_actual['nombre'] : ($categoria_actual['nombre'] ?? '');
          ?>

          <div class="card fade-in <?php echo ($clase_filtro); ?>"
            <?php if ($estilo_tarjeta): ?>style="<?php echo $estilo_tarjeta; ?>" <?php endif; ?>>
            <img src="../IMAGENES/<?php echo ($libro['imagen']); ?>" alt="<?php echo ($libro['titulo']); ?>">
            <div class="titulo"><?php echo ($libro['titulo']); ?></div>
            <div class="descripcion">
              Tema: <?php echo $nombre_tema_libro ? ($nombre_tema_libro) : ($nombre_fallback); ?>
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

    <?php endif; ?>

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

    <!-- JAVASCRIPT BUSCADOR Y FILTRO (solo aplica en vista de libros) -->
    <script>
      function setVista(vista) {
        var catalogo = document.getElementById('catalogo');
        if (!catalogo) return;
        var btnCuadricula = document.getElementById('btn-cuadricula');
        var btnLista = document.getElementById('btn-lista');

        if (vista === 'lista') {
          catalogo.classList.add('vista-lista');
          btnLista.classList.add('activo-vista');
          btnCuadricula.classList.remove('activo-vista');
        } else {
          catalogo.classList.remove('vista-lista');
          btnCuadricula.classList.add('activo-vista');
          btnLista.classList.remove('activo-vista');
        }
        localStorage.setItem('vista-catalogo', vista);
      }

      document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('catalogo')) {
          var vistaGuardada = localStorage.getItem('vista-catalogo') || 'cuadricula';
          setVista(vistaGuardada);
        }
      });

      function filtrar() {
        var catalogo = document.getElementById('catalogo');
        if (!catalogo) return;

        var busqueda = document.getElementById('buscador').value.toLowerCase();
        var filtroGenero = document.getElementById('filtro-genero');
        var genero = filtroGenero ? filtroGenero.value : 'todos';
        var orden = document.getElementById('orden').value;
        var tarjetas = Array.from(catalogo.querySelectorAll('.card'));

        tarjetas.forEach(function(card) {
          var titulo = card.querySelector('.titulo').textContent.toLowerCase();
          var coincideBusqueda = titulo.includes(busqueda);
          var coincideGenero = genero === 'todos' || card.classList.contains(genero);
          card.style.display = (coincideBusqueda && coincideGenero) ? '' : 'none';
        });

        var visibles = tarjetas.filter(function(card) {
          return card.style.display !== 'none';
        });

        visibles.sort(function(a, b) {
          var tA = a.querySelector('.titulo').textContent.trim().toLowerCase();
          var tB = b.querySelector('.titulo').textContent.trim().toLowerCase();
          return orden === 'az' ? tA.localeCompare(tB) : tB.localeCompare(tA);
        });

        visibles.forEach(function(card) {
          catalogo.appendChild(card);
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