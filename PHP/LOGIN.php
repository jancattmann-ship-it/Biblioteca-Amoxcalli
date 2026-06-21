<?php
session_start();
/** @var mysqli $con */
include_once("CONEXION.php");

// CERRAR SESIÓN
if (isset($_POST["cerrar_sesion"])) {
    session_destroy();
    header("Location: LOGIN.php");
    exit();
}

// ELIMINAR CUENTA
if (isset($_POST["eliminar_cuenta"])) {
    $email = $_SESSION["usuario"]["email"];

    // Primero eliminar los préstamos activos del usuario (saca) para no violar la FK
    $stmt0 = mysqli_prepare($con, "DELETE FROM saca WHERE email = ?");
    mysqli_stmt_bind_param($stmt0, "s", $email);
    mysqli_stmt_execute($stmt0);
    mysqli_stmt_close($stmt0);

    // Ahora sí eliminar la cuenta
    $stmt = mysqli_prepare($con, "DELETE FROM usuarios WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    session_destroy();
    header("Location: LOGIN.php?eliminado=ok");
    exit();
}

// --- DEVOLVER LIBRO ---
if (isset($_POST["devolver"])) {
    $id_saca = $_POST["id_saca"];
    $email_actual = $_SESSION["usuario"]["email"];
    $fecha_hoy = date("Y-m-d");

    //Esto es para que la tabla "Registro" se actualice al devolver el libro, ya que al no estar relacionada del todo, no se actualiza sola

    // Obtener el cod_libro y fecha_pedido de ese préstamo antes de actualizar
    $stmt_get = mysqli_prepare($con, "SELECT cod_libro, fecha_pedido FROM saca WHERE id = ? AND email = ?");
    mysqli_stmt_bind_param($stmt_get, "is", $id_saca, $email_actual);
    mysqli_stmt_execute($stmt_get);
    $res_get = mysqli_stmt_get_result($stmt_get);
    $datos_saca = mysqli_fetch_assoc($res_get);
    mysqli_stmt_close($stmt_get);

    // Actualizar saca
    $stmt_dev = mysqli_prepare($con, "UPDATE saca SET fecha_devuelto = ? WHERE id = ? AND email = ?");
    mysqli_stmt_bind_param($stmt_dev, "sis", $fecha_hoy, $id_saca, $email_actual);
    mysqli_stmt_execute($stmt_dev);
    mysqli_stmt_close($stmt_dev);

    // Actualizar también el registro correspondiente en "registros"
    if ($datos_saca) {
        $stmt_dev2 = mysqli_prepare($con, "UPDATE registros SET fecha_devuelto = ? WHERE email = ? AND cod_libro = ? AND fecha_pedido = ? AND fecha_devuelto IS NULL");
        mysqli_stmt_bind_param($stmt_dev2, "ssss", $fecha_hoy, $email_actual, $datos_saca["cod_libro"], $datos_saca["fecha_pedido"]);
        mysqli_stmt_execute($stmt_dev2);
        mysqli_stmt_close($stmt_dev2);
    }

    header("Location: LOGIN.php");
    exit();
}

// ACTUALIZAR DATOS
$msg_update = "";
if (isset($_POST["actualizar"])) {
    $email = $_SESSION["usuario"]["email"];
    $telefono = trim($_POST["telefono_nuevo"]);
    $password = trim($_POST["password_nuevo"]);

    if ($telefono !== "" && $password !== "") {
        $stmt = mysqli_prepare($con, "UPDATE usuarios SET telefono = ?, contrasena = ? WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "sss", $telefono, $password, $email);
    } elseif ($telefono !== "") {
        $stmt = mysqli_prepare($con, "UPDATE usuarios SET telefono = ? WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "ss", $telefono, $email);
    } elseif ($password !== "") {
        $stmt = mysqli_prepare($con, "UPDATE usuarios SET contrasena = ? WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "ss", $password, $email);
    } else {
        $msg_update = "vacio";
        $stmt = null;
    }

    if ($stmt) {
        if (mysqli_stmt_execute($stmt)) {
            if ($telefono !== "")
                $_SESSION["usuario"]["telefono"] = $telefono;
            $msg_update = "ok";
        } else {
            $msg_update = "error";
        }
        mysqli_stmt_close($stmt);
    }
}

// INICIAR SESIÓN
$error_login = "";
if (isset($_POST["iniciar_sesion"])) {
    $email = trim($_POST["email_login"]);
    $password = $_POST["password_login"];

    $stmt = mysqli_prepare($con, "SELECT nombre, email, telefono, genero, tipo FROM usuarios WHERE email = ? AND contrasena = ?");
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        $_SESSION["usuario"] = $fila;
        mysqli_stmt_close($stmt);
        header("Location: LOGIN.php");
        exit();
    } else {
        $error_login = "Correo o contraseña incorrectos.";
    }
    mysqli_stmt_close($stmt);
}
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
                <img src="../IMAGENES/libro_verde.png" alt="Cuenta" class="icono-cuenta">
                <?php echo isset($_SESSION["usuario"]) ? ($_SESSION["usuario"]["nombre"]) : "Mi cuenta"; ?>
            </a>
        </div>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="../HTML/MISION.html">Misión y Visión</a></li>
            <li><a href="../HTML/TEMPORADA.html">Talleres de Temporada</a></li>
            <li><a href="../PHP/CATALOGO.php">Catálogo</a></li>
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

            <!-- PANEL SEGÚN TIPO DE USUARIO -->
            <div class="titulo-pagina">
                <img src="../IMAGENES/libro_verde.png" alt="Cuenta" class="icono-pagina">
                <h2>Mi cuenta</h2>
            </div>

            <?php if ($u["tipo"] === "administrador"): ?>
                <div class="panel-admin">
                    <span class="badge-tipo">Administrador</span>
                    <p>Bienvenido al panel de administración, <strong><?php echo ($u["nombre"]); ?></strong>.
                        Desde aquí puedes gestionar los recursos de la biblioteca.</p>
                </div>

                <!-- HISTORIAL COMPLETO (TODOS LOS USUARIOS) -->
                <h3>Historial completo de préstamos</h3>

                <input type="text" id="buscador-admin" placeholder="Buscar por nombre o correo..." oninput="filtrarUsuarios()" style="width:100%; padding:9px 13px; border:1px solid #c8e6c9; border-radius:5px; margin-bottom:14px; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

                <?php
                $stmt_r = mysqli_prepare($con, "SELECT email, nombre, titulo_libro, cod_libro, fecha_pedido, fecha_devuelto FROM registros ORDER BY email ASC, fecha_pedido DESC");
                mysqli_stmt_execute($stmt_r);
                $resultado_r = mysqli_stmt_get_result($stmt_r);

                // Agrupar registros por usuario
                $usuarios_hist = [];
                while ($r = mysqli_fetch_assoc($resultado_r)) {
                    $key = $r["email"];
                    if (!isset($usuarios_hist[$key])) {
                        $usuarios_hist[$key] = [
                            "nombre" => $r["nombre"],
                            "email" => $r["email"],
                            "pedidos" => []
                        ];
                    }
                    $usuarios_hist[$key]["pedidos"][] = $r;
                }
                mysqli_stmt_close($stmt_r);
                ?>

                <?php if (count($usuarios_hist) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Correo</th>
                                <th>Total de préstamos</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0;
                            foreach ($usuarios_hist as $uh): $i++; ?>
                                <tr class="fila-usuario-admin">
                                    <td><?php echo htmlspecialchars($uh["nombre"]); ?></td>
                                    <td><?php echo htmlspecialchars($uh["email"]); ?></td>
                                    <td><?php echo count($uh["pedidos"]); ?></td>
                                    <td><button type="button" class="btn-devolver" onclick="togglePedidos(<?php echo $i; ?>)">Ver pedidos</button></td>
                                </tr>
                                <tr id="pedidos-<?php echo $i; ?>" class="fila-usuario-admin" style="display:none;">
                                    <td colspan="4" style="padding:0; border:none;">
                                        <table style="margin:0;">
                                            <thead>
                                                <tr>
                                                    <th>Libro</th>
                                                    <th>Código</th>
                                                    <th>Fecha préstamo</th>
                                                    <th>Fecha devolución</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($uh["pedidos"] as $p): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($p["titulo_libro"]); ?></td>
                                                        <td><?php echo htmlspecialchars($p["cod_libro"]); ?></td>
                                                        <td><?php echo date("d/m/Y", strtotime($p["fecha_pedido"])); ?></td>
                                                        <td><?php echo $p["fecha_devuelto"] ? date("d/m/Y", strtotime($p["fecha_devuelto"])) : "Pendiente"; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="color:#777; font-style:italic;">Aún no hay registros en el historial.</p>
                <?php endif; ?>

                <!-- JS: TOGGLE DE PEDIDOS Y BUSCADOR -->
                <script>
                    function togglePedidos(i) {
                        var fila = document.getElementById('pedidos-' + i);
                        fila.style.display = fila.style.display === 'none' ? 'table-row' : 'none';
                    }

                    function filtrarUsuarios() {
                        var busqueda = document.getElementById('buscador-admin').value.toLowerCase();
                        var filas = document.querySelectorAll('.fila-usuario-admin');

                        filas.forEach(function(fila) {
                            // Solo evalúa el texto de las filas principales (no las de detalle)
                            if (fila.id.startsWith('pedidos-')) return;

                            var texto = fila.textContent.toLowerCase();
                            var coincide = texto.includes(busqueda);
                            fila.style.display = coincide ? '' : 'none';

                            // Si se oculta la fila principal, también ocultar su detalle
                            var idDetalle = fila.querySelector('button').getAttribute('onclick').match(/\d+/)[0];
                            var detalle = document.getElementById('pedidos-' + idDetalle);
                            if (!coincide) {
                                detalle.style.display = 'none';
                            }
                        });
                    }
                </script>

            <?php else: ?>
                <div class="panel-visitante">
                    <span class="badge-tipo">Visitante</span>
                    <p>Hola, <strong><?php echo ($u["nombre"]); ?></strong>. Tu registro ha sido guardado
                        correctamente.</p>
                </div>
            <?php endif; ?>

            <!-- TABLA DE DATOS -->
            <h3>Tus datos registrados</h3>
            <table>
                <tbody>
                    <tr>
                        <td><strong>Nombre</strong></td>
                        <td><?php echo ($u["nombre"]); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Correo</strong></td>
                        <td><?php echo ($u["email"]); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Teléfono</strong></td>
                        <td><?php echo ($u["telefono"]); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Género</strong></td>
                        <td><?php echo ($u["genero"]); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tipo de cuenta</strong></td>
                        <td><?php echo ($u["tipo"]); ?></td>
                    </tr>
                </tbody>
            </table>

            <!-- HISTORIAL DE PRÉSTAMOS -->
            <h3>Mis libros apartados</h3>
            <?php
            $stmt_h = mysqli_prepare($con, "SELECT s.id, l.titulo, s.cod_libro, s.fecha_pedido, s.fecha_devuelto FROM saca s JOIN libros l ON s.cod_libro = l.cod_libro WHERE s.email = ? ORDER BY s.fecha_pedido DESC");
            mysqli_stmt_bind_param($stmt_h, "s", $u["email"]);
            mysqli_stmt_execute($stmt_h);
            $resultado_h = mysqli_stmt_get_result($stmt_h);

            if (mysqli_num_rows($resultado_h) > 0): ?>
                <div class="lista-prestamos">
                    <?php $j = 0;
                    while ($prestamo = mysqli_fetch_assoc($resultado_h)): $j++; ?>
                        <div class="prestamo-item">
                            <div class="prestamo-resumen">
                                <span class="prestamo-titulo"><?php echo ($prestamo["titulo"]); ?></span>
                                <button type="button" class="btn-ver-mas" onclick="togglePrestamo(<?php echo $j; ?>)">Ver más</button>
                            </div>
                            <div id="prestamo-detalle-<?php echo $j; ?>" class="prestamo-detalle" style="display:none;">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td><strong>Código</strong></td>
                                            <td><?php echo ($prestamo["cod_libro"]); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Fecha préstamo</strong></td>
                                            <td><?php echo date("d/m/Y", strtotime($prestamo["fecha_pedido"])); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Fecha devolución</strong></td>
                                            <td><?php echo $prestamo["fecha_devuelto"] ? date("d/m/Y", strtotime($prestamo["fecha_devuelto"])) : "Pendiente"; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Acción</strong></td>
                                            <td>
                                                <?php if (!$prestamo["fecha_devuelto"]): ?>
                                                    <form method="POST">
                                                        <input type="hidden" name="id_saca" value="<?php echo $prestamo["id"]; ?>">
                                                        <input type="submit" name="devolver" value="Devolver" class="btn-devolver">
                                                    </form>
                                                <?php else: ?>
                                                    —
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- JAVASCRIPT TOGGLE PRÉSTAMOS -->
                <script>
                    function togglePrestamo(j) {
                        var detalle = document.getElementById('prestamo-detalle-' + j);
                        var boton = detalle.previousElementSibling.querySelector('.btn-ver-mas');
                        if (detalle.style.display === 'none') {
                            detalle.style.display = 'block';
                            boton.textContent = 'Ver menos';
                        } else {
                            detalle.style.display = 'none';
                            boton.textContent = 'Ver más';
                        }
                    }
                </script>
            <?php else: ?>
                <p style="color:#777; font-style:italic;">No tienes libros apartados aún.</p>
            <?php endif;
            mysqli_stmt_close($stmt_h); ?>

            <!-- MENSAJES DE ACTUALIZACIÓN -->
            <?php if ($msg_update === "ok"): ?>
                <p class="msg-exito">✔ Datos actualizados correctamente.</p>
            <?php elseif ($msg_update === "error"): ?>
                <p class="msg-error">⚠ Error al actualizar. Intenta de nuevo.</p>
            <?php elseif ($msg_update === "vacio"): ?>
                <p class="msg-error">⚠ Llena al menos un campo para actualizar.</p>
            <?php endif; ?>

            <!-- BOTÓN TOGGLE EDITAR -->
            <button type="button" class="btn-editar-toggle" onclick="toggleEditar()">✏ Editar mis datos</button>

            <!-- FORMULARIO EDITAR (oculto por defecto) -->
            <div id="form-editar" style="display:none;">
                <h3>Editar mis datos</h3>
                <form method="POST">
                    <div class="campo">
                        <label for="telefono_nuevo">Nuevo teléfono</label>
                        <input type="tel" id="telefono_nuevo" name="telefono_nuevo" placeholder="10 dígitos"
                            pattern="[0-9]{10}" maxlength="10" value="<?php echo ($u['telefono']); ?>">
                    </div>
                    <div class="campo">
                        <label for="password_nuevo">Nueva contraseña</label>
                        <input type="password" id="password_nuevo" name="password_nuevo" placeholder="Mínimo 8 caracteres"
                            minlength="8">
                    </div>
                    <input type="submit" name="actualizar" value="Guardar cambios">
                </form>
            </div>

            <!-- BOTONES CERRAR Y ELIMINAR -->
            <div class="btns-cuenta">
                <form method="POST" style="flex:1;">
                    <input type="submit" name="cerrar_sesion" value="Cerrar sesión" class="btn-cerrar-sesion">
                </form>
                <form method="POST" style="flex:1;"
                    onsubmit="return confirm('¿Seguro que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');">
                    <input type="submit" name="eliminar_cuenta" value="Eliminar cuenta" class="btn-eliminar">
                </form>
            </div>

            <!-- JAVASCRIPT TOGGLE EDITAR -->
            <script>
                function toggleEditar() {
                    var div = document.getElementById('form-editar');
                    div.style.display = div.style.display === 'none' ? 'block' : 'none';
                }
                <?php if ($msg_update !== ""): ?>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('form-editar').style.display = 'block';
                    });
                <?php endif; ?>
            </script>

        <?php else: ?>

            <!-- TÍTULO -->
            <div class="titulo-pagina">
                <img src="../IMAGENES/Comando_Bloque.png" alt="Sesión" class="icono-pagina">
                <h2>Acceso a mi cuenta</h2>
            </div>

            <!-- MENSAJES DE ERROR / ÉXITO -->
            <?php if (isset($_GET["eliminado"]) && $_GET["eliminado"] === "ok"): ?>
                <p class="msg-exito">✔ Cuenta eliminada correctamente.</p>
            <?php elseif (isset($_GET["error"]) && $_GET["error"] === "existe"): ?>
                <p class="msg-error">⚠ Ese correo ya está registrado. Inicia sesión.</p>
            <?php elseif (isset($_GET["error"]) && $_GET["error"] === "db"): ?>
                <p class="msg-error">⚠ Error al guardar. Intenta de nuevo.</p>
            <?php elseif (isset($_GET["registro"]) && $_GET["registro"] === "ok"): ?>
                <p class="msg-exito">✔ Cuenta creada correctamente.</p>
            <?php endif; ?>
            <?php if ($error_login): ?>
                <p class="msg-error">⚠ <?php echo $error_login; ?></p>
            <?php endif; ?>

            <!-- PESTAÑAS -->
            <div class="tabs">
                <button class="tab-btn activo-tab" onclick="mostrarTab('login', event)">Iniciar sesión</button>
                <button class="tab-btn" onclick="mostrarTab('registro', event)">Registrarse</button>
            </div>

            <!-- FORMULARIO INICIAR SESIÓN -->
            <div id="form-login" class="tab-contenido">
                <form method="POST">
                    <div class="campo">
                        <label for="email_login">Correo electrónico</label>
                        <input type="email" id="email_login" name="email_login" placeholder="correo@ejemplo.com" required>
                    </div>
                    <div class="campo">
                        <label for="password_login">Contraseña</label>
                        <input type="password" id="password_login" name="password_login" placeholder="Tu contraseña"
                            required>
                    </div>
                    <input type="submit" name="iniciar_sesion" value="Entrar">
                </form>
            </div>

            <!-- FORMULARIO REGISTRO -->
            <div id="form-registro" class="tab-contenido" style="display:none;">
                <form action="REGISTRO.php" method="POST">
                    <div class="campo">
                        <label for="nombre">Nombre completo</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej. Juan Carlos Bodoque" required>
                    </div>
                    <div class="campo">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" required>
                    </div>
                    <div class="campo">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" minlength="8"
                            required>
                    </div>
                    <div class="campo">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" placeholder="Ej. 7771234567" pattern="[0-9]{10}"
                            maxlength="10" required>
                    </div>
                    <div class="campo">
                        <label>Género</label>
                        <div class="radio-grupo">
                            <label class="radio-opcion"><input type="radio" name="genero" value="Masculino" checked>
                                Masculino</label>
                            <label class="radio-opcion"><input type="radio" name="genero" value="Femenino"> Femenino</label>
                        </div>
                    </div>

                    <input type="submit" value="Crear cuenta">
                </form>
            </div>

            <!-- TABLA DE BENEFICIOS -->
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

            <!-- JAVASCRIPT PESTAÑAS -->
            <script>
                function mostrarTab(cual, event) {
                    document.getElementById('form-login').style.display = 'none';
                    document.getElementById('form-registro').style.display = 'none';

                    var botones = document.querySelectorAll('.tab-btn');
                    botones.forEach(function(btn) {
                        btn.classList.remove('activo-tab');
                    });

                    document.getElementById('form-' + cual).style.display = 'block';
                    event.target.classList.add('activo-tab');
                }

                <?php if (isset($_GET["error"])): ?>
                    document.addEventListener('DOMContentLoaded', function() {
                        var btnRegistro = document.querySelectorAll('.tab-btn')[1];
                        btnRegistro.click();
                    });
                <?php endif; ?>
            </script>

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

    <!-- HERRAMIENTAS GLOBALES: VOLVER ARRIBA Y TAMAÑO DE TEXTO -->
    <button id="btn-volver-arriba" aria-label="Volver arriba">↑</button>
    <div class="control-tamano-texto">
        <button onclick="cambiarTamano(-2)" aria-label="Disminuir tamaño de texto">A-</button>
        <button onclick="cambiarTamano(2)" aria-label="Aumentar tamaño de texto">A+</button>
    </div>
    <script src="../JS/HERRAMIENTAS.js"></script>

</body>

</html>