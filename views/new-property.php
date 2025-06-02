<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>

<main class="container d-flex justify-content-center align-items-center my-3">
    <div class="card shadow-sm pt-2 ps-4 pe-4 pb-4" style="max-width: 500px; width: 100%;">
        <div class="text-center mt-1 mb-3">
            <h2 class="logo">registrar propiedad</h2>
        </div>
        <form id="multiStepForm" action="/controllers/CreateAddressCreateProperty.php" method="POST">
            <!-- Paso 1 -->
            <div class="step" id="step-1">
                <h4 class="mb-2">¿Dónde está tu casa?</h4>
                <div class="mb-3">
                    <label for="street" class="form-label">Calle</label>
                    <input type="text" class="form-control" id="street" name="street" placeholder="Ej: Calle de las Amapolas, 70" required>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">Ciudad</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="Ej: Mejorada del Campo" required>
                </div>
                <div class="mb-3">
                    <label for="province" class="form-label">Provincia</label>
                    <input type="text" class="form-control" id="province" name="province" placeholder="Ej: Madrid">
                </div>
                <div class="mb-3">
                    <label for="postal_code" class="form-label">Código postal</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Ej: 28840" required>
                </div>
                <div class="mb-3">
                    <label for="country" class="form-label">País</label>
                    <input type="text" class="form-control" id="country" name="country" placeholder="Ej: España" required>
                </div>
                <button type="button" class="btn btn-secondary btn-font d-flex mx-auto mt-3" onclick="nextStep(2)">siguiente</button>
            </div>

            <!-- Paso 2 -->
            <div class="step d-none" id="step-2">
                <h4 class="mb-2">¿Qué tipo de casa es?</h4>
                <div class="mb-3">
                    <label for="property_type" class="form-label">Tipo de vivienda</label>
                    <div class="d-flex align-items-center">
                        <input type="radio" class="me-1" id="property_type_1" name="property_type" value="Habitación" />
                        <label for="true" class="me-3">Habitación</label>
                        <input type="radio" class="me-1" id="property_type_2" name="property_type" value="Estudio" />
                        <label for="false" class="me-3">Estudio</label>
                        <input type="radio" class="me-1" id="property_type_3" name="property_type" value="Piso" />
                        <label for="false" class="me-3">Piso</label>
                        <input type="radio" class="me-1" id="property_type_4" name="property_type" value="Casa" />
                        <label for="false" class="me-3">Casa</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="built_size" class="form-label">Tamaño construido</label>
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control w-25 me-2" id="built_size" name="built_size" placeholder="Ej: 147">
                        <p>m²</p>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">
                        Estatus
                        <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Estado del inmueble"></i>
                    </label>
                    <div class="d-flex align-items-center">
                        <input type="radio" class="me-1" id="status_1" name="status" value="Obra nueva" checked />
                        <label for="Obra nueva" class="me-3">Obra nueva</label>
                        <input type="radio" class="me-1" id="status_2" name="status" value="Reformado" />
                        <label for="Reformado" class="me-3">Reformado</label>
                        <input type="radio" class="me-1" id="status_3" name="status" value="A reformar" />
                        <label for="A reformar" class="me-3">A reformar</label>
                        <input type="radio" class="me-1" id="status_4" name="status" value="Buen estado" />
                        <label for="Buen estado" class="me-3">Buen estado</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="immediate_availability" class="form-label">
                        ¿Disponibilidad inmediata?
                        <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="¿Se puede entrar a vivir en un par de semanas como máximo?"></i>
                    </label>
                    <div class="d-flex align-items-center">
                        <input type="radio" class="me-1" id="immediate_availability_1" name="immediate_availability" value="true" checked />
                        <label for="true" class="me-3">Sí</label>
                        <input type="radio" class="me-1" id="immediate_availability_2" name="immediate_availability" value="false" />
                        <label for="false">No</label>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-secondary btn-font mt-3 me-2" onclick="prevStep(1)">anterior</button>
                    <button type="button" class="btn btn-secondary btn-font mt-3" onclick="nextStep(3)">siguiente</button>
                </div>
            </div>

            <!-- Paso 3 -->
            <div class="step d-none" id="step-3">
                <h4>Datos adicionales</h4>
                <div class="mb-3" id="dynamic-fields"></div>

                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-secondary btn-font mt-3 me-2" onclick="prevStep(2)">anterior</button>
                    <button type="button" class="btn btn-secondary btn-font mt-3" onclick="nextStep(4)">siguiente</button>
                </div>
            </div>

            <!-- Paso 4 -->
            <div class="step d-none" id="step-4">
                <h4>Confirmar datos</h4>
                <div class="mb-3" id="summary-section">
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-secondary btn-font mt-3 me-2" onclick="prevStep(3)">anterior</button>
                    <button type="submit" class="btn btn-success btn-font mt-3">registrar propiedad</button>
                </div>
            </div>
        </form>
    </div>
</main>

<script>
    function nextStep(step) {
        document.querySelectorAll('.step').forEach(el => el.classList.add('d-none'));
        document.getElementById('step-' + step).classList.remove('d-none');
    }

    function prevStep(step) {
        document.querySelectorAll('.step').forEach(el => el.classList.add('d-none'));
        document.getElementById('step-' + step).classList.remove('d-none');
    }
</script>

<!--<script>
    document.addEventListener('DOMContentLoaded', function() {
        function hideAllPropertyFields() {
            document.getElementById('room-fields').style.display = 'none';
            document.getElementById('studio-fields').style.display = 'none';
            document.getElementById('apartment-fields').style.display = 'none';
            document.getElementById('house-fields').style.display = 'none';
        }

        function showPropertyFields(type) {
            hideAllPropertyFields();
            if (type === 'Habitación') {
                document.getElementById('room-fields').style.display = '';
            } else if (type === 'Estudio') {
                document.getElementById('studio-fields').style.display = '';
            } else if (type === 'Piso') {
                document.getElementById('apartment-fields').style.display = '';
            } else if (type === 'Casa') {
                document.getElementById('house-fields').style.display = '';
            }
        }

        document.querySelectorAll('input[name="property_type"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                // Si ya estamos en el paso 3, actualiza los campos visibles
                if (!document.getElementById('step-3').classList.contains('d-none')) {
                    showPropertyFields(this.value);
                }
            });
        });

        const originalNextStep = window.nextStep;
        window.nextStep = function(step) {
            originalNextStep(step);
            if (step === 3) {
                const selected = document.querySelector('input[name="property_type"]:checked');
                if (selected) {
                    showPropertyFields(selected.value);
                }
            }
        };

        hideAllPropertyFields();
    });
</script>-->

<script>
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

    // Evento para los radios
    document.querySelectorAll('input[name="property_type"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            loadFieldsForType(this.value);
        });
    });

    // Al cargar el paso 3, también debes llamar a loadFieldsForType con el valor seleccionado
</script>

<script>
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
    window.nextStep = function(step) {
        originalNextStepSummary(step);
        if (step === 4) {
            showSummary();
        }
    };
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>