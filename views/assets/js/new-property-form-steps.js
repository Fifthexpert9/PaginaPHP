function showError(inputId, message) {
    let input = document.getElementById(inputId);
    let errorDiv = document.getElementById(inputId + 'Error');
    if (errorDiv) {
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
    }
    if (input) input.classList.add('is-invalid');
}

function clearError(inputId) {
    let input = document.getElementById(inputId);
    let errorDiv = document.getElementById(inputId + 'Error');
    if (errorDiv) errorDiv.style.display = 'none';
    if (input) input.classList.remove('is-invalid');
}

async function validateStep1() {
    let valid = true;
    let fields = ['street','city','province','postal_code','country'];
    let fieldLabels = {
        street: 'calle',
        city: 'ciudad',
        province: 'provincia',
        postal_code: 'código postal',
        country: 'país'
    };
    fields.forEach(clearError);

    let values = {};
    let firstEmpty = null;
    fields.forEach(function(id) {
        let el = document.getElementById(id);
        values[id] = el ? el.value.trim() : '';
        if (!values[id] && !firstEmpty) {
            showError(id, 'Este campo es obligatorio.');
            valid = false;
            firstEmpty = id;
        }
    });
    if (!valid) return false;

    // Validar existencia real usando Nominatim
    let query = `${values.street}, ${values.city}, ${values.province}, ${values.postal_code}, ${values.country}`;
    let url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`;
    try {
        let response = await fetch(url, {headers: {'Accept-Language': 'es'}});
        let data = await response.json();
        if (!data || data.length === 0) {
            // Solo muestra el error en el campo más relevante (el primero no vacío empezando por calle)
            for (let i = 0; i < fields.length; i++) {
                if (values[fields[i]]) {
                    showError(fields[i], `Introduce una ${fieldLabels[fields[i]]} real.`);
                    break;
                }
            }
            return false;
        }
    } catch (e) {
        showError('street', 'No se pudo validar la dirección. Intenta de nuevo.');
        return false;
    }
    return true;
}
window.validateStep1 = validateStep1;

// nextStep debe esperar a validateStep1 si es el paso 2
function nextStep(step) {
    if (step === 2 && typeof validateStep1 === 'function') {
        Promise.resolve(validateStep1()).then(valid => {
            if (!valid) return;
            showStep(step);
        });
        return;
    }
    showStep(step);
}
function prevStep(step) {
    document.querySelectorAll('.step').forEach(el => el.classList.add('d-none'));
    document.getElementById('step-' + step).classList.remove('d-none');
}
function showStep(step) {
    document.querySelectorAll('.step').forEach(el => el.classList.add('d-none'));
    document.getElementById('step-' + step).classList.remove('d-none');
}