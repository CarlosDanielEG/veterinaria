document.querySelector('.contactForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Evitar el envío del formulario por defecto

    const formData = new FormData(this); // Crear un objeto FormData con los datos del formulario

    fetch('../plantilla/send_email.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta de la red: ' + response.statusText); // Manejar errores de red
        }
        return response.json(); // Procesar la respuesta como JSON
    })
    .then(data => {
        if (data.status === 'success') {
            // Mostrar SweetAlert2 para éxito
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: data.message,
            });
        } else {
            // Mostrar SweetAlert2 para error
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message,
            });
        }
    })
    .catch(error => {
        // Mostrar SweetAlert2 para errores de JavaScript o problemas de red
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un problema al enviar el mensaje: ' + error.message,
        });
    });
});
