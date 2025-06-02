<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

use facades\PropertyFacade;
use converters\PropertyConverter;
use converters\RoomConverter;
use converters\StudioConverter;
use converters\ApartmentConverter;
use converters\HouseConverter;
use converters\AddressConverter;
use converters\ImageConverter;

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

$properties = [];
if ($user && isset($user->id)) {
    $propertyFacade = new PropertyFacade(
        new PropertyConverter(),
        new RoomConverter(),
        new StudioConverter(),
        new ApartmentConverter(),
        new HouseConverter(),
        new AddressConverter(),
        new ImageConverter()
    );
    $properties = $propertyFacade->getPropertiesByUserId($user->id);
}
?>

<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>
<main>
    <div class="container my-5">
        <h3 class="logo text-center mb-4">mis propiedades</h3>
        <?php if (!$user): ?>
            <div class="alert alert-warning text-center">No has iniciado sesión.</div>
        <?php elseif (empty($properties)): ?>
            <div class="alert alert-secondary text-center">No tienes propiedades registradas.</div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($properties as $property): ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?= htmlspecialchars($property['text'] ?? ($property['id'] . ' - ' . ($property['property_type'] ?? 'Propiedad'))) ?>
                                </h5>
                                <?php if (isset($property['city'])): ?>
                                    <p class="card-text mb-1"><strong>Ciudad:</strong> <?= htmlspecialchars($property['city']) ?></p>
                                <?php endif; ?>
                                <?php if (isset($property['property_type'])): ?>
                                    <p class="card-text mb-1"><strong>Tipo:</strong> <?= htmlspecialchars($property['property_type']) ?></p>
                                <?php endif; ?>
                                <a href="/detallePropiedad?id=<?= urlencode($property['id']) ?>" class="btn btn-primary btn-sm mt-2">Ver detalles</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php require_once __DIR__ . '/partials/footer.php'; ?>