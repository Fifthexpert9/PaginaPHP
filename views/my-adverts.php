<?php
require_once __DIR__ . '/../vendor/autoload.php';

use facades\AdvertFacade;
use converters\AdvertConverter;
use converters\PropertyConverter;
use converters\AddressConverter;

session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user']->id)) {
    $_SESSION['message'] = 'Debes iniciar sesión para acceder a esta funcionalidad.';
    header('Location: /message');
    exit();
}

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

$adverts = [];
if ($user && isset($user->id)) {
    $advertFacade = new AdvertFacade(
        new AdvertConverter(),
        new PropertyConverter(),
        new AddressConverter()
    );
    $adverts = $advertFacade->getAdvertsByUserId($user->id);
}
?>

<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>
<main>
    <div class="container my-5">
        <h3 class="logo text-center mb-4">mis anuncios</h3>
        <?php if (!$user): ?>
            <div class="alert alert-warning text-center">No has iniciado sesión.</div>
        <?php elseif (empty($adverts)): ?>
            <div class="alert alert-secondary text-center">No tienes anuncios registrados.</div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($adverts as $advert):
                    $mainImage = $advert['advert']->main_image;
                    $property = isset($advert['property']) ? $advert['property'] : [];
                ?>
                    <div class="col-12">
                        <div class="card h-100 shadow-sm">
                            <div class="row g-0 align-items-center">
                                <!-- Imagen principal a la izquierda -->
                                <div class="col-lg-3">
                                    <img src="/<?= htmlspecialchars($mainImage) ?>" alt="Imagen principal" class="d-block d-lg-none img-fluid rounded-top" style="object-fit: cover;">
                                    <img src="/<?= htmlspecialchars($mainImage) ?>" alt="Imagen principal" class="d-none d-lg-block img-fluid rounded-start">
                                </div>
                                <!-- Información en el centro -->
                                <div class="col-lg-7">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3"><?= htmlspecialchars($advert['title']) ?></h4>
                                        <?php if (isset($advert['address']->city)): ?>
                                            <p class="card-text mb-1"><strong>Ciudad:</strong> <?= htmlspecialchars($advert['address']->city) ?></p>
                                        <?php endif; ?>
                                        <?php if (isset($advert['property']->property_type)): ?>
                                            <p class="card-text mb-1"><strong>Tipo:</strong> <?= htmlspecialchars($advert['property']->property_type) ?></p>
                                        <?php endif; ?>
                                        <?php if (isset($advert['property']->id)): ?>
                                            <p class="card-text mb-1"><strong>ID de propiedad:</strong> <?= htmlspecialchars($advert['property']->id) ?></p>
                                        <?php endif; ?>
                                        <?php if (isset($advert['advert']->price)): ?>
                                            <?php if ($advert['advert']->action == 'Alquiler'): ?>
                                                <p class="card-text mb-1"><strong>Precio:</strong> <?= htmlspecialchars($advert['advert']->price) ?> €/mes</p>
                                            <?php else: ?>
                                                <p class="card-text mb-1"><strong>Precio:</strong> <?= htmlspecialchars($advert['advert']->price) ?> €</p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if (isset($advert['advert']->description)): ?>
                                            <p class="card-text mb-1"><strong>Descripción:</strong></p>
                                            <p class="card-text flex-grow-1 d-flex align-items-end">
                                                <?= htmlspecialchars(mb_strimwidth($advert['advert']->description, 0, 250, '...')) ?>
                                            </p> <?php endif; ?>
                                        <?php if (isset($advert['advert']->created_at)): ?>
                                            <p class="card-text mb-1"><strong>Fecha de publicación:</strong> <?= htmlspecialchars($advert['advert']->created_at) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- Botones a la derecha -->
                                <div class="col-lg-2 d-flex flex-column align-items-center justify-content-center p-3">
                                    <a href="/advert-details?id=<?= urlencode($advert['advert']->id) ?>" class="btn btn-secondary btn-sm mb-2 btn-font w-100">ver detalles</a>
                                    <a href="/edit-advert?id=<?= urlencode($advert['advert']->id) ?>" class="btn btn-secondary btn-sm mb-2 btn-font w-100">editar</a>
                                    <form action="/delete-advert" method="post" class="border w-100" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($advert['advert']->id) ?>">
                                        <button type="submit" class="btn btn-danger btn-sm btn-font w-100" onclick="return confirm('¿Seguro que quieres borrar este anuncio?')">borrar</button>
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