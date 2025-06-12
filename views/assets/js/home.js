document.querySelectorAll('.favorite-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const advertId = this.getAttribute('data-advert-id');
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
                    this.querySelector('i').style.color = data.is_favorite ? 'red' : '#ccc';
                    this.title = data.is_favorite ? 'Quitar de favoritos' : 'Añadir a favoritos';
                }
            });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const propertyTypeInputs = document.querySelectorAll('input[name="property_types[]"]');
    const dynamicContainer = document.getElementById('dynamic-characteristics');

    function loadCharacteristics() {
        const checkedTypes = Array.from(propertyTypeInputs)
            .filter(input => input.checked)
            .map(input => input.value);

        if (checkedTypes.length === 0) {
            dynamicContainer.innerHTML = '';
            return;
        }

        // Construir la query string para múltiples tipos
        const params = new URLSearchParams();
        checkedTypes.forEach(type => params.append('type[]', type));

        fetch(`/views/partials/property-characteristics.php?${params.toString()}`)
            .then(res => res.text())
            .then(html => {
                dynamicContainer.innerHTML = html;
            });
    }

    propertyTypeInputs.forEach(input => {
        input.addEventListener('change', loadCharacteristics);
    });

    // Cargar al inicio si ya hay alguno seleccionado
    loadCharacteristics();
});