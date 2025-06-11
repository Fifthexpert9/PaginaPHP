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

// Validación del primer paso: dirección real y no vacía
async function validateStep1() {
    let valid = true;
    let fields = ['street','city','province','postal_code','country'];
    fields.forEach(clearError);

    let values = {};
    fields.forEach(function(id) {
        let el = document.getElementById(id);
        values[id] = el ? el.value.trim() : '';
        if (!values[id]) {
            showError(id, 'Este campo es obligatorio.');
            valid = false;
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
            fields.forEach(id => showError(id, 'Introduce una localización real.'));
            return false;
        }
    } catch (e) {
        fields.forEach(id => showError(id, 'No se pudo validar la dirección. Intenta de nuevo.'));
        return false;
    }
    return true;
}
window.validateStep1 = validateStep1;

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