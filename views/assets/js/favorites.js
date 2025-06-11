document.querySelectorAll('.favorite-btn').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
        e.preventDefault(); // Evita el submit si está en un formulario
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
                    // Quitar el anuncio de la lista si ya no es favorito
                    if (!data.is_favorite) {
                        // Elimina la tarjeta del DOM
                        btn.closest('.col-12').remove();
                    } else {
                        // Cambia el color y el título si se añade de nuevo (opcional)
                        btn.querySelector('i').style.color = 'red';
                        btn.title = 'Quitar de favoritos';
                    }
                }
            });
    });
});