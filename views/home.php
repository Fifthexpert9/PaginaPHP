<?php
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use facades\AdvertFacade;
use converters\AdvertConverter;
use converters\ImageConverter;
use converters\PropertyConverter;
use converters\AddressConverter;

$advertFacade = new AdvertFacade(
    new AdvertConverter(),
    new PropertyConverter(),
    new AddressConverter()
);

// Recoger filtros del formulario
$filters = [];
if (!empty($_GET['tipo'])) {
    $filters['property_types'] = [$_GET['tipo']];
}
if (!empty($_GET['precio'])) {
    $filters['advert_price_max'] = $_GET['precio'];
}
if (!empty($_GET['city'])) {
    $filters['city'] = $_GET['city'];
}
if (!empty($_GET['province'])) {
    $filters['province'] = $_GET['province'];
}
if (isset($_GET['immediate_availability']) && $_GET['immediate_availability'] !== '') {
    $filters['immediate_availability'] = $_GET['immediate_availability'];
}
if (!empty($_GET['status'])) {
    $filters['status'] = $_GET['status'];
}

// Obtener anuncios filtrados o todos si no hay filtros
if (!empty($filters)) {
    $adverts = $advertFacade->searchAdverts($filters);
    if (is_string($adverts)) {
        $adverts = [];
    }
} else {
    $adverts = $advertFacade->getAllAdverts();
}

//$adverts = [];

// Parámetros de paginación
$advertsPerPage = 6;
$totalAdverts = count($adverts);
$totalPages = max(1, ceil($totalAdverts / $advertsPerPage));
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, min($page, $totalPages)); // <-- Limita el valor de $page
$start = ($page - 1) * $advertsPerPage;
$advertsToShow = array_slice($adverts, $start, $advertsPerPage);
?>

<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>
<main>
    <!-- Anuncios y Filtros -->
    <div class="container body-ody-ody">
        <div class="row">
            <!-- Aside de filtros -->
            <aside class="col-12 col-md-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <strong>Filtrar propiedades</strong>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="property_type" class="form-label">Tipo</label>
                                <select class="form-select" id="tipo" name="tipo">
                                    <option value="">Todos</option>
                                    <option value="Habitación" <?= (isset($_GET['tipo']) && $_GET['tipo'] === 'Habitación') ? 'selected' : '' ?>>Habitación</option>
                                    <option value="Estudio" <?= (isset($_GET['tipo']) && $_GET['tipo'] === 'Estudio') ? 'selected' : '' ?>>Estudio</option>
                                    <option value="Piso" <?= (isset($_GET['tipo']) && $_GET['tipo'] === 'Piso') ? 'selected' : '' ?>>Piso</option>
                                    <option value="Casa" <?= (isset($_GET['tipo']) && $_GET['tipo'] === 'Casa') ? 'selected' : '' ?>>Casa</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio máximo</label>
                                <input type="number" class="form-control" id="precio" name="precio" placeholder="Ej: 1000" value="<?= isset($_GET['precio']) ? htmlspecialchars($_GET['precio']) : '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">Ciudad</label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="Ej: Madrid" value="<?= isset($_GET['city']) ? htmlspecialchars($_GET['city']) : '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="province" class="form-label">Provincia</label>
                                <input type="text" class="form-control" id="province" name="province" placeholder="Ej: Barcelona" value="<?= isset($_GET['province']) ? htmlspecialchars($_GET['province']) : '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="immediate_availability" class="form-label">Disponibilidad inmediata</label>
                                <select class="form-select" id="immediate_availability" name="immediate_availability">
                                    <option value="">Cualquiera</option>
                                    <option value="1" <?= (isset($_GET['immediate_availability']) && $_GET['immediate_availability'] === '1') ? 'selected' : '' ?>>Sí</option>
                                    <option value="0" <?= (isset($_GET['immediate_availability']) && $_GET['immediate_availability'] === '0') ? 'selected' : '' ?>>No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Estado</label>
                                <input type="text" class="form-control" id="status" name="status" placeholder="Ej: Reformado" value="<?= isset($_GET['status']) ? htmlspecialchars($_GET['status']) : '' ?>">
                            </div>
                            <button type="submit" class="btn btn-secondary w-100 btn-font">ver propiedades</button>
                        </form>
                    </div>
                </div>
            </aside>
            <!-- Listado de anuncios -->
            <div class="col-12 col-md-9 mb-4">
                <h2 class="mb-4">Propiedades disponibles</h2>
                <div class="row g-4">
                    <?php if (empty($adverts)): ?>
                        <div class="col-12">
                            <div class="alert alert-secondary text-center">
                                No se encontraron propiedades disponibles.
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($advertsToShow as $advert): ?>
                            <div class="col-12 col-lg-6">
                                <div class="card h-100 shadow-sm">
                                    <div class="row g-0 h-100">
                                        <div class="col-6 d-flex align-items-stretch" style="overflow: hidden;">
                                            <img src="<?= htmlspecialchars($advert['advert']->main_image) ?>"
                                                class="img-fluid rounded-start w-100 h-100"
                                                alt="Imagen propiedad"
                                                style="object-fit: cover; min-height: 200px;">
                                        </div>
                                        <div class="col-6">
                                            <div class="card-body d-flex flex-column h-100">
                                                <h5 class="card-title">
                                                    <?= htmlspecialchars($advert['title']) ?>
                                                </h5>
                                                <p class="card-text mb-1">
                                                    <?= htmlspecialchars($advert['property']->built_size) ?> m²
                                                </p>
                                                <p class="card-text mb-1">
                                                    <?php if ($advert['advert']->action == 'Alquiler'): ?>
                                                        <span class="badge text-bg-success fs-6"><?= htmlspecialchars($advert['advert']->price) ?> €/mes</span>
                                                    <?php else: ?>
                                                        <span class="badge text-bg-success fs-6"><?= htmlspecialchars($advert['advert']->price) ?> €</span>
                                                    <?php endif; ?>
                                                </p>
                                                <p class="card-text mb-1">
                                                    <span class="badge text-bg-secondary fs-6">
                                                        <?= htmlspecialchars($advert['property']->status) ?>
                                                    </span>
                                                </p>
                                                <!-- Añade la ciudad y provincia aquí -->
                                                <p class="card-text mb-1">
                                                    <i class="bi bi-geo-alt"></i>
                                                    <?= htmlspecialchars($advert['address']->city ?? '') ?>, <?= htmlspecialchars($advert['address']->province ?? '') ?>
                                                </p>
                                                <p class="card-text flex-grow-1 d-flex align-items-end">
                                                    <?= htmlspecialchars(mb_strimwidth($advert['advert']->description, 0, 120, '...')) ?>
                                                </p>
                                                <div class="mt-2 d-flex justify-content-evenly align-items-center">
                                                    <button class="btn btn-outline-danger btn-sm btn-font" title="Añadir a favoritos"><i class="bi bi-heart-fill mx-2"></i></button>
                                                    <a href="/advert-details?id=<?= urlencode($advert['advert']->id) ?>" class="btn btn-secondary btn-sm btn-font w-50" title="Ver detalles">ver detalles</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <!-- Paginación -->
                <nav aria-label="Página de navegación" class="mt-5">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $page === 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>" tabindex="-1">&laquo;</a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $page === $i ? 'active' : '' ?>">
                                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $page === $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>