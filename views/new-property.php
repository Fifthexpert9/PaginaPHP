<?php
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user']->id)) {
    $_SESSION['message'] = 'Debes iniciar sesión para acceder a esta funcionalidad.';
    header('Location: /message');
    exit();
}
?>

<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>

<main class="container d-flex justify-content-center align-items-center my-3">
    <div class="card shadow-sm pt-2 ps-4 pe-4 pb-4" style="max-width: 500px; width: 100%;">
        <div class="text-center mt-1 mb-3">
            <h2 class="logo">Registrar propiedad</h2>
        </div>
        <form id="multiStepForm" action="/controllers/CreateAddressCreateProperty.php" method="POST" enctype="multipart/form-data">
            <!-- Paso 1 -->
            <div class="step" id="step-1">
                <h4 class="mb-2">¿Dónde está tu casa?</h4>
                <div class="mb-3">
                    <label for="street" class="form-label">Calle</label>
                    <input type="text" class="form-control" id="street" name="street" placeholder="Ej: Calle de las Amapolas, 70" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">Ciudad</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="Ej: Mejorada del Campo" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="province" class="form-label">Provincia</label>
                    <input type="text" class="form-control" id="province" name="province" placeholder="Ej: Madrid" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="postal_code" class="form-label">Código postal</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Ej: 28840" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="country" class="form-label">País</label>
                    <input type="text" class="form-control" id="country" name="country" placeholder="Ej: España" required>
                    <div class="invalid-feedback"></div>
                </div>
                <button type="button" class="btn btn-secondary btn-font d-flex mx-auto mt-3" onclick="nextStep(2)" disabled>siguiente</button>
            </div>

            <!-- Paso 2 -->
            <div class="step d-none" id="step-2">
                <h4 class="mb-2">¿Qué tipo de casa es?</h4>
                <div class="mb-3">
                    <label for="property_type" class="form-label">Tipo de vivienda</label>
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <input type="radio" class="me-1" id="property_type_1" name="property_type" value="Habitación" required />
                        <label for="property_type_1" class="me-3">Habitación</label>
                        <input type="radio" class="me-1" id="property_type_2" name="property_type" value="Estudio" required />
                        <label for="property_type_2" class="me-3">Estudio</label>
                        <input type="radio" class="me-1" id="property_type_3" name="property_type" value="Piso" required />
                        <label for="property_type_3" class="me-3">Piso</label>
                        <input type="radio" class="me-1" id="property_type_4" name="property_type" value="Casa" required />
                        <label for="property_type_4" class="me-3">Casa</label>
                    </div>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="built_size" class="form-label">Tamaño construido</label>
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <input type="text" class="form-control w-25 me-2" id="built_size" name="built_size" placeholder="Ej: 147" required>
                        <p>m²</p>
                    </div>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">
                        Estatus
                        <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Estado del inmueble"></i>
                    </label>
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <input type="radio" class="me-1" id="status_1" name="status" value="Obra nueva" required />
                        <label for="status_1" class="me-3">Obra nueva</label>
                        <input type="radio" class="me-1" id="status_2" name="status" value="Reformado" required />
                        <label for="status_2" class="me-3">Reformado</label>
                        <input type="radio" class="me-1" id="status_3" name="status" value="A reformar" required />
                        <label for="status_3" class="me-3">A reformar</label>
                        <input type="radio" class="me-1" id="status_4" name="status" value="Buen estado" required />
                        <label for="status_4" class="me-3">Buen estado</label>
                    </div>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="immediate_availability" class="form-label">
                        ¿Disponibilidad inmediata?
                        <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="¿Se puede entrar a vivir en un par de semanas como máximo?"></i>
                    </label>
                   <div class="d-flex align-items-center flex-wrap gap-2">
                        <input type="radio" class="me-1" id="immediate_availability_1" name="immediate_availability" value="true" required />
                        <label for="true" class="me-3">Sí</label>
                        <input type="radio" class="me-1" id="immediate_availability_2" name="immediate_availability" value="false" required />
                        <label for="false">No</label>
                    </div>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-secondary btn-font mt-3 me-2" onclick="prevStep(1)">anterior</button>
                    <button type="button" class="btn btn-secondary btn-font mt-3" onclick="nextStep(3)" disabled>siguiente</button>
                </div>
            </div>

            <!-- Paso 3 -->
            <div class="step d-none" id="step-3">
                <h4>Datos adicionales</h4>
                <div class="mb-3" id="dynamic-fields"></div>
                <div class="mb-3">
                    <label for="images" class="form-label">Imágenes de la propiedad (máx. 6)</label>
                    <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple>
                    <small class="form-text text-muted">Puedes subir hasta 6 imágenes.</small>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-secondary btn-font mt-3 me-2" onclick="prevStep(2)">anterior</button>
                    <button type="button" class="btn btn-secondary btn-font mt-3" onclick="nextStep(4)" disabled>siguiente</button>
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

<!-- Lógica para los pasos del formulario -->
<script>
    <?php require_once __DIR__ . '/assets/js/new-property-form-steps.js'; ?>
    <?php require_once __DIR__ . '/assets/js/new-property-specific-property.js'; ?>
    <?php require_once __DIR__ . '/assets/js/new-property-limit-images.js'; ?>
    <?php require_once __DIR__ . '/assets/js/new-property-resume.js'; ?>
    <?php require_once __DIR__ . '/assets/js/new-property-validation.js'; ?>
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>