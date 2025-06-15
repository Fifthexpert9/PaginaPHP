document.querySelectorAll('.favorite-btn').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        const advertId = this.getAttribute('data-advert-id');
        const button = this;
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
                // Actualiza color, clase y título del botón al instante
                const icon = button.querySelector('i');
                if (icon) {
                    icon.style.color = data.is_favorite ? 'white' : '#888';
                }
                button.classList.remove('btn-danger', 'btn-outline-secondary');
                button.classList.add(data.is_favorite ? 'btn-danger' : 'btn-outline-secondary');
                button.title = data.is_favorite ? 'Quitar de favoritos' : 'Añadir a favoritos';
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

const overlay = document.getElementById('loader-overlay');
const bar = document.getElementById('loader-bar');

function animateBar(duration = 1800, onComplete) {
    bar.style.width = '0';
    let progress = 0;
    let start = null;

    function step(timestamp) {
        if (!start) start = timestamp;
        let elapsed = timestamp - start;

        // Avance aleatorio
        let target = Math.min(100, progress + Math.random() * 10 + 5);
        progress = Math.min(target, (elapsed / duration) * 100);

        bar.style.width = progress + '%';

        if (progress < 100) {
            requestAnimationFrame(step);
        } else {
            bar.style.width = '100%';
            if (typeof onComplete === 'function') onComplete();
        }
    }
    requestAnimationFrame(step);
}

function startLoader() {
    overlay.style.display = 'flex';
    overlay.classList.remove('fade-out');
    overlay.classList.add('visible');
    bar.style.width = '0';
    void overlay.offsetWidth;
    animateBar(1800, () => {
        overlay.classList.add('fade-out');
        overlay.classList.remove('visible');
        document.body.classList.remove('loading');
        setTimeout(() => {
            overlay.style.display = 'none';
            bar.style.width = '0';
            overlay.classList.remove('fade-out');
        }, 2000);
    });
}

document.body.classList.add('loading');

document.addEventListener('DOMContentLoaded', function() {
    if (!sessionStorage.getItem('houspecialLoaded')) {
        startLoader();
        sessionStorage.setItem('houspecialLoaded', '1');
    } else {
        overlay.style.display = 'none';
        bar.style.width = '0';
        overlay.classList.remove('visible', 'fade-out');
        document.body.classList.remove('loading');
    }
});

// Evento para el logo
var logo = document.querySelector('.logo');
if (logo) {
    logo.style.cursor = 'pointer';
    logo.addEventListener('click', function(e) {
        e.preventDefault();
        sessionStorage.removeItem('houspecialLoaded');
        window.location.href = '/';
    });
}



