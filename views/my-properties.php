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
                <?php foreach ($properties as $property): 
                    $mainImage = isset($property['main_image']) ? $property['main_image'] : 'media/no-image.png';
                    $propertyDto = isset($property['property']) ? $property['property'] : null;
                ?>
                    <div class="col-12">
                        <div class="card h-100 shadow-sm">
                            <div class="row g-0 align-items-center">
                                <!-- Imagen principal a la izquierda -->
                                <div class="col-lg-3 text-center">
                                    <img src="/<?= htmlspecialchars($mainImage) ?>" alt="Imagen principal" class="img-fluid rounded-start" style="object-fit: cover;">
                                </div>
                                <!-- Información en el centro -->
                                <div class="col-lg-7">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3"><?= htmlspecialchars($property['text']) ?></h4>
                                        <?php if ($propertyDto && isset($propertyDto->id)): ?>
                                            <p class="card-text mb-1"><strong>ID de propiedad:</strong> <?= htmlspecialchars($propertyDto->id) ?></p>
                                        <?php endif; ?>
                                        <?php if ($propertyDto && isset($propertyDto->property_type)): ?>
                                            <p class="card-text mb-1"><strong>Tipo:</strong> <?= htmlspecialchars($propertyDto->property_type) ?></p>
                                        <?php endif; ?>
                                        <?php if ($propertyDto && isset($propertyDto->built_size)): ?>
                                            <p class="card-text mb-1"><strong>Tamaño construido:</strong> <?= htmlspecialchars($propertyDto->built_size) ?> m²</p>
                                        <?php endif; ?>
                                        <?php if ($propertyDto && isset($propertyDto->status)): ?>
                                            <p class="card-text mb-1"><strong>Estado:</strong> <?= htmlspecialchars($propertyDto->status) ?></p>
                                        <?php endif; ?>
                                        <?php if ($propertyDto && isset($propertyDto->immediate_availability)): ?>
                                            <?php if ($propertyDto->immediate_availability): ?>
                                                <p class="card-text mb-1"><strong>Disponibilidad inmediata:</strong> Sí</p>
                                            <?php else: ?>
                                                <p class="card-text mb-1"><strong>Disponibilidad inmediata:</strong> No</p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- Botones a la derecha -->
                                <div class="col-lg-2 d-flex flex-column align-items-center justify-content-center p-3">
                                    <a href="/detallePropiedad?id=<?= urlencode($property['id']) ?>" class="btn btn-secondary btn-sm mb-2 w-100 btn-font">ver detalles</a>
                                    <a href="/editarPropiedad?id=<?= urlencode($property['id']) ?>" class="btn btn-secondary btn-sm mb-2 w-100 btn-font">editar</a>
                                    <form action="/delete-property" method="post" class="border w-100" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($property['id']) ?>">
                                        <button type="submit" class="btn btn-danger btn-sm w-100  btn-font" onclick="return confirm('¿Seguro que quieres borrar esta propiedad? También se borrará la dirección asignada a esta propiedad.')">borrar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php require_once __DIR__ . '/partials/footer.php'; ?>