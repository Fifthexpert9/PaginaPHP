<?php

namespace views;

require_once __DIR__ . '/../vendor/autoload.php';

use facades\AdvertFacade;
use facades\PropertyFacade;
use converters\AdvertConverter;
use converters\PropertyConverter;
use converters\RoomConverter;
use converters\StudioConverter;
use converters\ApartmentConverter;
use converters\HouseConverter;
use converters\AddressConverter;
use converters\ImageConverter;

session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user']->id)) {
    $_SESSION['message'] = 'Debes iniciar sesión para acceder a esta funcionalidad.';
    header('Location: /message');
    exit();
}

$advertId = $_GET['id'] ?? null;
$advert = null;
$property = null;

if ($advertId) {
    $advertFacade = new AdvertFacade(new AdvertConverter(), new PropertyConverter(), new AddressConverter());
    $advertData = $advertFacade->getAdvertById($advertId);
    if ($advertData && isset($advertData['advert'])) {
        $advert = $advertData['advert'];
        $propertyFacade = new PropertyFacade(
            new PropertyConverter(),
            new RoomConverter(),
            new StudioConverter(),
            new ApartmentConverter(),
            new HouseConverter(),
            new AddressConverter(),
            new ImageConverter()
        );
        $property = $propertyFacade->getCompletePropertyById($advert->property_id);
    }
}

if (!$advert || !$property || $property->user_id != $_SESSION['user']->id) {
    $_SESSION['message'] = 'No tienes permisos para editar este anuncio.';
    header('Location: /message');
    exit();
}

?>

<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>
<main class="container d-flex justify-content-center align-items-center my-3">
    <div class="card shadow-sm pt-2 ps-4 pe-4 pb-4" style="max-width: 500px; width: 100%;">
        <div class="text-center mt-1 mb-3">
            <h2 class="logo">editar anuncio</h2>
        </div>
        <form action="/controllers/EditAdvert.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($advertId) ?>">
            <input type="hidden" name="property_id" value="<?= htmlspecialchars($advert->property_id) ?>">
            <div class="mb-3">
                <label for="action" class="form-label">¿Vendes o alquilas?</label>
                <div class="d-flex align-items-center">
                    <input type="radio" class="me-1" id="action_1" name="action" value="Venta" <?= ($advert->action ?? '') === 'Venta' ? 'checked' : '' ?> />
                    <label for="action_1" class="me-3">Vendo</label>
                    <input type="radio" class="me-1" id="action_2" name="action" value="Alquiler" <?= ($advert->action ?? '') === 'Alquiler' ? 'checked' : '' ?> />
                    <label for="action_2" class="me-3">Alquilo</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">
                    ¿Qué precio va a tener?
                    <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Por favor, sé justo en el precio."></i>
                </label>
                <div class="d-flex align-items-center">
                    <input type="number" class="form-control w-25" id="price" name="price" min="1" placeholder="Ej: 241000" value="<?= htmlspecialchars($advert->price ?? '') ?>" required>
                    <p class="ms-2"> €</p>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">
                    Descripción
                    <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="¡Añade una pequeña descripción para que los interesados sepan más sobre lo que ofreces!"></i>
                </label>
                <textarea class="form-control" id="description" name="description" placeholder="Ej: Vendo mi propiedad porque me mudo... Alquilo mi propiedad a gente que quiera compartir piso..."><?= htmlspecialchars($advert->description ?? '') ?></textarea>
            </div>
            <button type="submit" class="btn btn-secondary btn-font d-flex mx-auto mt-3">guardar cambios</button>
        </form>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>