<?php
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use facades\PropertyFacade;
use facades\ImageFacade;
use converters\PropertyConverter;
use converters\RoomConverter;
use converters\StudioConverter;
use converters\ApartmentConverter;
use converters\HouseConverter;
use converters\AddressConverter;
use converters\ImageConverter;

$propertyFacade = new PropertyFacade(
    new ImageFacade(new ImageConverter()),
    new PropertyConverter(),
    new RoomConverter(),
    new StudioConverter(),
    new ApartmentConverter(),
    new HouseConverter(),
    new AddressConverter(),
    new ImageConverter()
);

$properties = $propertyFacade->getPropertiesByUserId($_SESSION['user']->id);

?>

<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>
<main class="container d-flex justify-content-center align-items-center my-3">
    <div class="card shadow-sm pt-2 ps-4 pe-4 pb-4" style="max-width: 500px; width: 100%;">
        <div class="text-center mt-1 mb-3">
            <h2 class="logo">crear anuncio</h2>
        </div>
        <form id="multiStepForm" action="/controllers/CreateAdvert.php" method="POST">
            <div class="mb-3">
                <label for="property_id" class="form-label">¿Qué propiedad vas a anunciar?</label>
                <select class="form-select" id="property_id" name="property_id" required>
                    <option value="">Selecciona una propiedad</option>
                    <?php if (empty($properties)): ?>
                        <option value="" disabled>No tienes propiedades registradas.</option>
                    <?php else: ?>
                        <?php foreach ($properties as $property): ?>
                            <option value="<?= htmlspecialchars($property['id']) ?>">
                                <?= htmlspecialchars($property['text']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="action" class="form-label">¿Vendes o alquilas?</label>
                <div class="d-flex align-items-center">
                    <input type="radio" class="me-1" id="action_1" name="action" value="Venta" />
                    <label for="true" class="me-3">Vendo</label>
                    <input type="radio" class="me-1" id="action_2" name="action" value="Alquiler" />
                    <label for="false" class="me-3">Alquilo</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">
                    ¿Qué precio va a tener?
                    <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Por favor, sé justo en el precio."></i>
                </label>
                <div class="d-flex align-items-center">
                    <input type="number" class="form-control w-25" id="price" name="price" min="1" placeholder="Ej: 241000" required>
                    <p class="ms-2"> €</p>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">
                    Descripción
                    <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="¡Añade una pequeña descripción para que los interesados sepan más sobre lo que ofreces!"></i>
                </label>
                <textarea class="form-control" id="description" name="description" placeholder="Ej: Vendo mi propiedad porque me mudo... Alquilo mi propiedad a gente que quiera compartir piso..."></textarea>
            </div>

            <button type="submit" class="btn btn-secondary btn-font d-flex mx-auto mt-3">crear anuncio</button>
        </form>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>