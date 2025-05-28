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
                        <input type="radio" class="me-1" id="property_type_1" name="property_type" value="Habitación" checked />
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
                        <input type="radio" class="me-1" id="status_1" name="status" value="Habitación" checked />
                        <label for="Obra nueva" class="me-3">Obra nueva</label>
                        <input type="radio" class="me-1" id="status_2" name="status" value="Estudio" />
                        <label for="Reformado" class="me-3">Reformado</label>
                        <input type="radio" class="me-1" id="status_3" name="status" value="Piso" />
                        <label for="A reformar" class="me-3">A reformar</label>
                        <input type="radio" class="me-1" id="status_4" name="status" value="Casa" />
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
                <div id="room-fields" class="mb-3">
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
                        <!-- Este campo igual hay q borrarlo de la tabla... no tiene mucho sentido :/-->
                        <label for="max_roommates" class="form-label">
                            ¿La habitación es compartida?
                        </label>
                        <div class="d-flex align-items-center">
                            <input type="radio" class="me-1" id="private_bathroom_1" name="private_bathroom" value="true" checked />
                            <label for="true" class="me-3">Sí</label>
                            <input type="radio" class="me-1" id="private_bathroom_2" name="private_bathroom" value="false" />
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
                </div>

                <div id="studio-fields" class="mb-3">
                    <label for="rooms" class="form-label">Número de habitaciones</label>
                    <input type="number" class="form-control" id="rooms" name="rooms" min="1" max="20" value="1" required>
                </div>

                <div id="apartment-fields" class="mb-3">
                    <label for="rooms" class="form-label">Número de habitaciones</label>
                    <input type="number" class="form-control" id="rooms" name="rooms" min="1" max="20" value="1" required>
                </div>

                <div id="house-fields" class="mb-3">
                    <label for="rooms" class="form-label">Número de habitaciones</label>
                    <input type="number" class="form-control" id="rooms" name="rooms" min="1" max="20" value="1" required>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-secondary btn-font mt-3 me-2" onclick="prevStep(2)">anterior</button>
                    <button type="button" class="btn btn-secondary btn-font mt-3" onclick="nextStep(4)">siguiente</button>
                </div>
            </div>

            <!-- Paso 4 -->
            <div class="step d-none" id="step-4">
                <h4>Confirmar datos</h4>
                <div class="mb-3">
                    <!-- Mostrar datos divididos en 3 secciones -->
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

<?php require_once __DIR__ . '/partials/footer.php'; ?>