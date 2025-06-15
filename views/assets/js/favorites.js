/**
 * Script para gestionar la eliminación de anuncios de la lista de favoritos.
 *
 * - Escucha el evento click en todos los botones con la clase .favorite-btn.
 * - Envía una petición POST a /controllers/ToggleFavorite.php con el ID del anuncio.
 * - Si la respuesta contiene un redirect, redirige al usuario (por ejemplo, si no está autenticado).
 * - Si la operación es exitosa y el anuncio se elimina de favoritos, elimina el elemento del DOM.
 * - Si el anuncio sigue siendo favorito, actualiza el color y el tooltip del icono.
 *
 * Dependencias:
 * - Cada botón debe tener la clase .favorite-btn y el atributo data-advert-id con el ID del anuncio.
 * - El icono de favorito debe estar dentro del botón.
 * - El contenedor del anuncio debe tener la clase .col-12 para ser eliminado correctamente del DOM.
 */

document.querySelectorAll('.favorite-btn').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        const advertId = btn.getAttribute('data-advert-id');
        fetch('/controllers/ToggleFavorite.php', {
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
                    if (!data.is_favorite) {
                        btn.closest('.col-12').remove();
                    } else {
                        btn.querySelector('i').style.color = 'red';
                        btn.title = 'Quitar de favoritos';
                    }
                }
            });
    });
});