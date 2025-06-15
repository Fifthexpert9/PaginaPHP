/**
 * Script para gestionar la navegación en la página de mensajes o avisos.
 *
 * Funcionalidades:
 * - Redirige automáticamente al usuario a la página de inicio después de 10 segundos.
 * - Permite volver manualmente al login si existe un botón con id="goBack".
 * - Permite volver manualmente al inicio si existe un botón con id="goHome".
 *
 * Dependencias:
 * - Deben existir en el HTML los botones con id="goBack" y/o id="goHome" según la funcionalidad deseada.
 */

setTimeout(function () {
    window.location.href = '/';
}, 10000);

document.addEventListener('DOMContentLoaded', function () {
    var goBack = document.getElementById('goBack');
    if (goBack) {
        goBack.addEventListener('click', function () {
            window.location.href = '/login';
        });
    }
    var goHome = document.getElementById('goHome');
    if (goHome) {
        goHome.addEventListener('click', function () {
            window.location.href = '/';
        });
    }
});