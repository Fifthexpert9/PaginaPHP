function getRoomFields() {
    return `
        <div class="mb-3">
                        <label for="private_bathroom" class="form-label">
                            ¿La habitación tiene baño privado?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="private_bathroom_1" name="private_bathroom" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="private_bathroom_2" name="private_bathroom" value="false" />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="max_roommates" class="form-label">
                            ¿Cuántas personas comparten el piso?
                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Incluye el número de personas que viven ahora mismo en el piso"></i>
                        </label>
                        <input type="number" class="form-control w-25" id="max_roommates" name="max_roommates" min="1" max="10" placeholder="Ej: 3" required>
                    </div>
                    <div class="mb-3">
                        <label for="pets_allowed" class="form-label">
                            ¿Se permiten mascotas?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="pets_allowed_1" name="pets_allowed" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="pets_allowed_2" name="pets_allowed" value="false" />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="furnished" class="form-label">
                            ¿Está amueblada?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="furnished_1" name="furnished" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="furnished_2" name="furnished" value="false" />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="students_only" class="form-label">
                            Sólo estudiantes
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="students_only_1" name="students_only" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="students_only_2" name="students_only" value="false" />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="gender_restriction" class="form-label">
                            ¿Hay restricción de genéro?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="gender_restriction_1" name="gender_restriction" value="Sólo chicos" />
                            <label for="true" class="me-3">Sólo chicos</label>
                            <input type="radio" class="me-1" id="gender_restriction_2" name="gender_restriction" value="Sólo chicas" />
                            <label for="true" class="me-3">Sólo chicas</label>
                            <input type="radio" class="me-1" id="gender_restriction_3" name="gender_restriction" value="Sin restricciones" checked />
                            <label for="false">Sin restricciones</label>
                        </div>
                    </div>
    `;
}

function getStudioFields() {
    return `
        <div class="mb-3">
                        <label for="furnished" class="form-label">
                            ¿Está amueblado?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="furnished_1" name="furnished" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="furnished_2" name="furnished" value="false" />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="balcony" class="form-label">
                            ¿Tiene balcón/terraza?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="balcony_1" name="balcony" value="true" />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="balcony_2" name="balcony" value="false" checked />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="air_conditioning" class="form-label">
                            ¿Tiene aire acondicionado?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="air_conditioning_1" name="air_conditioning" value="true" />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="air_conditioning_2" name="air_conditioning" value="false" checked />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="pets_allowed" class="form-label">
                            ¿Se permiten mascotas?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="pets_allowed_1" name="pets_allowed" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="pets_allowed_2" name="pets_allowed" value="false" />
                            <label for="false">No</label>
                        </div>
                    </div>
    `;
}

function getApartmentFields() {
    return `
        <div class="mb-3">
                        <label for="apartment_type" class="form-label">
                            ¿Qué tipo de piso es?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="apartment_type_1" name="apartment_type" value="Estándar" checked />
                            <label for="true" class="me-3">Estándar</label>
                            <input type="radio" class="me-1" id="fapartment_type_2" name="apartment_type" value="Loft" />
                            <label for="false" class="me-3">Loft</label>
                            <input type="radio" class="me-1" id="apartment_type_3" name="apartment_type" value="Ático" />
                            <label for="false" class="me-3">Ático</label>
                            <input type="radio" class="me-1" id="apartment_type_4" name="apartment_type" value="Dúplex" />
                            <label for="false" class="me-3">Dúplex</label>
                            <input type="radio" class="me-1" id="apartment_type_5" name="apartment_type" value="Bajo con jardín" />
                            <label for="false" class="me-3">Bajo con jardín</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="num_rooms" class="form-label">
                            ¿Cuántas habitaciones tiene?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="number" class="form-control w-25" id="num_rooms" name="num_rooms" min="1" max="10" placeholder="Ej: 3" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="num_bathrooms" class="form-label">
                            ¿Cuántos baños tiene?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="number" class="form-control w-25" id="num_bathrooms" name="num_bathrooms" min="1" max="10" placeholder="Ej: 3" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="furnished" class="form-label">
                            ¿Está amueblado?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="furnished_1" name="furnished" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="furnished_2" name="furnished" value="false" />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="balcony" class="form-label">
                            ¿Tiene balcón/terraza?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="balcony_1" name="balcony" value="true" />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="balcony_2" name="balcony" value="false" checked />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="floor" class="form-label">
                            ¿Qué planta es?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="number" class="form-control w-25" id="floor" name="floor" min="0" max="25" placeholder="Ej: 8" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="elevator" class="form-label">
                            ¿Tiene ascensor?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="elevator_1" name="elevator" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="elevator_2" name="elevator" value="false" />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="air_conditioning" class="form-label">
                            ¿Tiene aire acondicionado?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="air_conditioning_1" name="air_conditioning" value="true" />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="air_conditioning_2" name="air_conditioning" value="false" checked />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="garage" class="form-label">
                            ¿Tiene garaje?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="garage_1" name="garage" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="garage_2" name="garage" value="false" />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="pets_allowed" class="form-label">
                            ¿Se permiten mascotas?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="pets_allowed_1" name="pets_allowed" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="pets_allowed_2" name="pets_allowed" value="false" />
                            <label for="false">No</label>
                        </div>
                    </div>
        `;
}

function getHouseFields() {
    return `
        <div class="mb-3">
                        <label for="house_type" class="form-label">
                            ¿Qué tipo de casa es?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="house_type_1" name="house_type" value="Unifamiliar" checked />
                            <label for="true" class="me-3">Unifamiliar</label>
                            <input type="radio" class="me-1" id="house_type_2" name="house_type" value="Chalet" />
                            <label for="false" class="me-3">Chalet</label>
                            <input type="radio" class="me-1" id="house_type_3" name="house_type" value="Adosado" />
                            <label for="false" class="me-3">Adosado</label>
                            <input type="radio" class="me-1" id="house_type_4" name="house_type" value="Pareado" />
                            <label for="false" class="me-3">Pareado</label>
                            <input type="radio" class="me-1" id="house_type_5" name="house_type" value="Casa rural" />
                            <label for="false" class="me-3">Casa rural</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="garden_size" class="form-label">
                            ¿Qué tamaño tiene el jardín?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="number" class="form-control w-25 me-2" id="garden_size" name="garden_size" min="1" placeholder="Ej: 25" required>
                            <p>m²</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="num_floors" class="form-label">
                            ¿Cuántas plantas tiene?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="number" class="form-control w-25" id="num_floors" name="num_floors" min="1" max="5" placeholder="Ej: 2" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="num_rooms" class="form-label">
                            ¿Cuántas habitaciones tiene?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="number" class="form-control w-25" id="num_rooms" name="num_rooms" min="1" max="20" placeholder="Ej: 3" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="num_bathrooms" class="form-label">
                            ¿Cuántos baños tiene?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="number" class="form-control w-25" id="num_bathrooms" name="num_bathrooms" min="1" max="20" placeholder="Ej: 2" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="private_garage" class="form-label">
                            ¿Tiene garaje privado?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="private_garage_1" name="private_garage" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="private_garage_2" name="private_garage" value="false" />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="private_pool" class="form-label">
                            ¿Tiene piscina privada?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="private_pool_1" name="private_pool" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="private_pool_2" name="private_pool" value="false" />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="furnished" class="form-label">
                            ¿Está amueblado?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="furnished_1" name="furnished" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="furnished_2" name="furnished" value="false" />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="terrace" class="form-label">
                            ¿Tiene terraza/porche?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="terrace_1" name="terrace" value="true" />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="terrace_2" name="terrace" value="false" checked />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="storage_room" class="form-label">
                            ¿Tiene trastero?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="storage_room_1" name="storage_room" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="storage_room_2" name="storage_room" value="false" />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="air_conditioning" class="form-label">
                            ¿Tiene aire acondicionado?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="air_conditioning_1" name="air_conditioning" value="true" />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="air_conditioning_2" name="air_conditioning" value="false" checked />
                            <label for="false">No</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="pets_allowed" class="form-label">
                            ¿Se permiten mascotas?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="pets_allowed_1" name="pets_allowed" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="pets_allowed_2" name="pets_allowed" value="false" />
                            <label for="false">No</label>
                        </div>
                    </div>
        `;
}

function loadFieldsForType(type) {
    let html = '';
    if (type === 'Habitación') html = getRoomFields();
    else if (type === 'Estudio') html = getStudioFields();
    else if (type === 'Piso') html = getApartmentFields();
    else if (type === 'Casa') html = getHouseFields();
    document.getElementById('dynamic-fields').innerHTML = html;
}

document.querySelectorAll('input[name="property_type"]').forEach(function (radio) {
    radio.addEventListener('change', function () {
        loadFieldsForType(this.value);
    });
});