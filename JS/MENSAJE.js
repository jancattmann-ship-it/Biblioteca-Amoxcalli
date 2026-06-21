// Mensajes de bienvenida usando SweetAlert2 

Swal.fire({
    title: "¡Bienvenido a la Biblioteca Amoxcalli!",
    icon: "info",
    confirmButtonText: "Siguiente",
    confirmButtonColor: "#1a3e1f"
}).then(function () {
    Swal.fire({
        title: "Aviso",
        text: "Dale \"Aceptar\" para cerrar estos mensajes",
        icon: "success",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#1a3e1f"
    });
});