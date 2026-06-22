// Mensajes de bienvenida usando SweetAlert2 

Swal.fire({
    imageUrl: "IMAGENES/logo-temixco.png",
    imageWidth: 90,
    imageAlt: "Logo Biblioteca Amoxcalli",
    title: "¡Bienvenido a la Biblioteca Amoxcalli!",
    text: "Tu biblioteca de confianza en Temixco, Morelos",
    background: "#f5f7f5",
    color: "#1a3e1f",
    confirmButtonText: "Siguiente",
    confirmButtonColor: "#1a3e1f",
    customClass: {
        popup: 'popup-amoxcalli'
    }
}).then(function () {
    Swal.fire({
        title: "Aviso",
        text: "Dale \"Aceptar\" para cerrar estos mensajes",
        icon: "success",
        iconColor: "#2e6b35",
        background: "#f5f7f5",
        color: "#1a3e1f",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#1a3e1f",
        customClass: {
            popup: 'popup-amoxcalli'
        }
    });
});