// Hace que los elementos con la clase "fade-in-scroll" aparezcan suavemente
// cuando entran en la pantalla al hacer scroll

const elementosAnimados = document.querySelectorAll('.fade-in-scroll');

const observador = new IntersectionObserver(function (entradas) {
    entradas.forEach(function (entrada) {
        if (entrada.isIntersecting) {
            entrada.target.classList.add('visible');
            observador.unobserve(entrada.target); // ya no hace falta seguir observando
        }
    });
}, {
    threshold: 0.15 // se activa cuando el 15% del elemento es visible
});

elementosAnimados.forEach(function (el) {
    observador.observe(el);
});