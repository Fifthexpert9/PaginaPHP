/**
 * Script para gestionar la funcionalidad de añadir o quitar un anuncio de favoritos desde la vista de detalles.
 *
 * - Escucha el evento click en el botón de favoritos.
 * - Envía una petición POST a /toggle-favorite con el ID del anuncio.
 * - Si la respuesta contiene un redirect, redirige al usuario (por ejemplo, si no está autenticado).
 * - Si la operación es exitosa, cambia el color del icono y el tooltip según el estado de favorito.
 *
 * Dependencias:
 * - El botón debe tener id="favorite-btn" y un atributo data-advert-id con el ID del anuncio.
 * - El icono de favorito debe estar dentro del botón.
 */

document.getElementById('favorite-btn').addEventListener('click', function () {
    const btn = this;
    const advertId = btn.getAttribute('data-advert-id');
    fetch('/toggle-favorite', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'advert_id=' + encodeURIComponent(advertId)
    })
        .then(response => response.json())
        .then((data) => {
            if (data.redirect) {
                window.location.href = data.redirect;
            } else if (data.success) {
                btn.querySelector('i').style.color = data.is_favorite ? 'red' : '#ccc';
                btn.title = data.is_favorite ? 'Quitar de favoritos' : 'Añadir a favoritos';
            }
        });
});