document.getElementById('favorite-btn').addEventListener('click', function () {
    const btn = this; // Referencia al botón
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