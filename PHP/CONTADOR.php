<?php

if (isset($_SESSION["numero_acceso"])) { // CONTADOR 
    $_SESSION["numero_acceso"]++;
} else {
    $_SESSION["numero_acceso"] = 1;
}

$visitas = $_SESSION["numero_acceso"];

// FRASES ALEATORIAS (con array)
$frases = [
    "\"Un libro es un sueño que tienes en tus manos.\" Neil Gaiman",
    "\"Leer es vivir dos veces.\" Umberto Eco",
    "\"Los libros son espejos: solo se ve en ellos lo que uno ya lleva dentro.\" Carlos Ruiz Zafón",
    "\"Una habitación sin libros es como un cuerpo sin alma.\" Cicerón",
    "\"No hay amigo tan leal como un libro.\" Ernest Hemingway",
    "\"Los libros son, entre mis consejeros, los que más me agradan.\" Alfonso V de Aragón",
    "\"Quien lee mucho y anda mucho, ve mucho y sabe mucho.\" Miguel de Cervantes",
    "\"Un libro abierto es un cerebro que habla.\" Victor Hugo",
    "\"La lectura es el camino por el que el conocimiento pasa al corazón.\" Voltaire",
    "\"Siempre imaginé que el paraíso sería algún tipo de biblioteca.\" Jorge Luis Borges",
    "\"Hasta que no te conviertes en un lector, no puedes ser un escritor.\" Franz Kafka (Mi escritor favorito ~ Romeo)",
    "\"El que lee mucho y anda mucho, ve mucho y sabe mucho.\" Miguel de Cervantes",
    "\"Los libros son el espejo del alma.\" Virginia Woolf",
    "\"Una novela es un espejo que se pasea por un camino.\" Stendhal",
    "\"El libro es el único lugar donde dos extraños pueden encontrarse.\" Octavio Paz",
    "\"Escribe lo que debería ser escrito, aunque no sea lo que se espera.\" Gabriel García Márquez (Mi escritor favorito ~ Jan)",
    "\"Ningún hombre que sepa leer ha llegado a ser esclavo del todo.\" Frederick Douglass",
    "\"Los libros son los mejores amigos: siempre disponibles, nunca de mal humor.\" George Bernard Shaw",
];

// ESTO SELECCIONA UNA FRASE ALEATORIA
$indice_aleatorio = array_rand($frases);
$frase_del_dia = $frases[$indice_aleatorio];

// --- MENSAJE DE BIENVENIDA SEGÚN VISITAS ---
if ($visitas === 1) {
    $mensaje_visitas = "¡Bienvenido! Esta es tu primera visita.";
} else
    if ($visitas <= 5) {
        $mensaje_visitas = "Has visitado esta página <strong>$visitas</strong> veces. Nos alegra verte de nuevo!";
    } else
        if ($visitas <= 10) {
            $mensaje_visitas = "Llevas <strong>$visitas</strong> visitas. Si que te gusta leer!";
        } else
            if ($visitas <= 20) {
                $mensaje_visitas = "Llevas <strong>$visitas</strong> visitas. Eres de nuestro lector más fiel";
            } else
                if ($visitas <= 40) {
                    $mensaje_visitas = "¿¡<strong>$visitas</strong> visitas!?. Ya eres parte de la familia Amoxcalli";
                } else
                if ($visitas <= 80) {
                    $mensaje_visitas = "¿¡<strong>$visitas</strong> visitas!?. A estas alturas ya deberías tener tu credencial (porfa)";
                    } else {
                        $mensaje_visitas = "¿¡¡<strong>$visitas</strong> visitas!!?. Oficialmente haz ido mas veces que envidia ~Jan";
                    }

?>