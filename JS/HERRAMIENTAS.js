// Botón flotante "Volver arriba" + control de tamaño de texto
// Se usa en todas las páginas del sitio

// VOLVER ARRIBA 
const btnArriba = document.getElementById('btn-volver-arriba');

window.addEventListener('scroll', function () {
    if (window.scrollY > 300) {
        btnArriba.classList.add('visible');
    } else {
        btnArriba.classList.remove('visible');
    }
});

btnArriba.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// TAMAÑO DE TEXTO
const TAMANO_MIN = 14;
const TAMANO_MAX = 22;

function cambiarTamano(delta) {
    const actual = parseInt(getComputedStyle(document.documentElement).fontSize);
    let nuevo = actual + delta;
    if (nuevo < TAMANO_MIN) nuevo = TAMANO_MIN;
    if (nuevo > TAMANO_MAX) nuevo = TAMANO_MAX;
    document.documentElement.style.fontSize = nuevo + 'px';
    localStorage.setItem('tamanoTexto', nuevo);
}

// Aplicar tamaño guardado (si existe) al cargar la página
const tamanoGuardado = localStorage.getItem('tamanoTexto');
if (tamanoGuardado) {
    document.documentElement.style.fontSize = tamanoGuardado + 'px';
}