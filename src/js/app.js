setTimeout(function() {
    var alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        alert.addEventListener('closed.bs.alert', function () {
            alert.remove(); // Elimina el elemento del DOM después de que se cierra
        });
        alert.querySelector('.btn-close').click(); // Simula hacer clic en el botón cerrar
    });
}, 2500);