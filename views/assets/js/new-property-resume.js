function getRadioValue(name) {
    const checked = document.querySelector('input[name="' + name + '"]:checked');
    return checked ? checked.nextElementSibling.textContent.trim() : '';
}

function getInputValue(id) {
    const el = document.getElementById(id);
    return el ? el.value : '';
}

function showSummary() {
    let html = `<h5 class="mb-2">Ubicación</h5>
    <ul>
        <li><strong>Calle:</strong> ${getInputValue('street')}</li>
        <li><strong>Ciudad:</strong> ${getInputValue('city')}</li>
        <li><strong>Provincia:</strong> ${getInputValue('province')}</li>
        <li><strong>Código postal:</strong> ${getInputValue('postal_code')}</li>
        <li><strong>País:</strong> ${getInputValue('country')}</li>
    </ul>`;

    html += `<h5 class="mb-2">Datos generales</h5>
    <ul>
        <li><strong>Tipo de vivienda:</strong> ${getRadioValue('property_type')}</li>
        <li><strong>Tamaño construido:</strong> ${getInputValue('built_size')} m²</li>
        <li><strong>Estatus:</strong> ${getRadioValue('status')}</li>
        <li><strong>Disponibilidad inmediata:</strong> ${getRadioValue('immediate_availability')}</li>
    </ul>`;

    const type = document.querySelector('input[name="property_type"]:checked').value;
    html += `<h5 class="mb-2">Datos adicionales</h5><ul>`;
    if (type === 'Habitación') {
        html += `
            <li><strong>Baño privado:</strong> ${getRadioValue('private_bathroom')}</li>
            <li><strong>Personas en el piso:</strong> ${getInputValue('max_roommates')}</li>
            <li><strong>Mascotas permitidas:</strong> ${getRadioValue('pets_allowed')}</li>
            <li><strong>Amueblada:</strong> ${getRadioValue('furnished')}</li>
            <li><strong>Sólo estudiantes:</strong> ${getRadioValue('students_only')}</li>
            <li><strong>Restricción de género:</strong> ${getRadioValue('gender_restriction')}</li>
        `;
    } else if (type === 'Estudio') {
        html += `
            <li><strong>Amueblado:</strong> ${getRadioValue('furnished')}</li>
            <li><strong>Balcón/terraza:</strong> ${getRadioValue('balcony')}</li>
            <li><strong>Aire acondicionado:</strong> ${getRadioValue('air_conditioning')}</li>
            <li><strong>Mascotas permitidas:</strong> ${getRadioValue('pets_allowed')}</li>
        `;
    } else if (type === 'Piso') {
        html += `
            <li><strong>Tipo de piso:</strong> ${getRadioValue('apartment_type')}</li>
            <li><strong>Habitaciones:</strong> ${getInputValue('num_rooms')}</li>
            <li><strong>Baños:</strong> ${getInputValue('num_bathrooms')}</li>
            <li><strong>Amueblada:</strong> ${getRadioValue('furnished')}</li>
            <li><strong>Balcón/terraza:</strong> ${getRadioValue('balcony')}</li>
            <li><strong>Planta:</strong> ${getInputValue('floor')}</li>
            <li><strong>Ascensor:</strong> ${getRadioValue('elevator')}</li>
            <li><strong>Aire acondicionado:</strong> ${getRadioValue('air_conditioning')}</li>
            <li><strong>Garaje:</strong> ${getRadioValue('garage')}</li>
            <li><strong>Mascotas permitidas:</strong> ${getRadioValue('pets_allowed')}</li>
        `;
    } else if (type === 'Casa') {
        html += `
            <li><strong>Tipo de casa:</strong> ${getRadioValue('house_type')}</li>
            <li><strong>Tamaño jardín:</strong> ${getInputValue('garden_size')} m²</li>
            <li><strong>Plantas:</strong> ${getInputValue('num_floors')}</li>
            <li><strong>Habitaciones:</strong> ${getInputValue('num_rooms')}</li>
            <li><strong>Baños:</strong> ${getInputValue('num_bathrooms')}</li>
            <li><strong>Garaje privado:</strong> ${getRadioValue('private_garage')}</li>
            <li><strong>Piscina privada:</strong> ${getRadioValue('private_pool')}</li>
            <li><strong>Amueblada:</strong> ${getRadioValue('furnished')}</li>
            <li><strong>Terraza/porche:</strong> ${getRadioValue('terrace')}</li>
            <li><strong>Trastero:</strong> ${getRadioValue('storage_room')}</li>
            <li><strong>Aire acondicionado:</strong> ${getRadioValue('air_conditioning')}</li>
            <li><strong>Mascotas permitidas:</strong> ${getRadioValue('pets_allowed')}</li>
        `;
    }
    html += `</ul>`;

    document.getElementById('summary-section').innerHTML = html;
}

const originalNextStepSummary = window.nextStep;
window.nextStep = function (step) {
    originalNextStepSummary(step);
    if (step === 4) {
        showSummary();
    }
};