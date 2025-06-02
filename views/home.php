<?php
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use facades\AdvertFacade;
use converters\AdvertConverter;
use converters\ImageConverter;
use converters\PropertyConverter;

$advertFacade = new AdvertFacade(new AdvertConverter(), new PropertyConverter(), new ImageConverter());

$adverts = $advertFacade->getAllAdverts();
//$adverts = [];

// Parámetros de paginación
$advertsPerPage = 6;
$totalAdverts = count($adverts);
$totalPages = ceil($totalAdverts / $advertsPerPage);
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
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
                                    <option value="Habitación">Habitación</option>
                                    <option value="Estudio">Estudio</option>
                                    <option value="Piso">Piso</option>
                                    <option value="Casa">Casa</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio máximo</label>
                                <input type="number" class="form-control" id="precio" name="precio" placeholder="Ej: 1000">
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">Ciudad</label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="Ej: Madrid">
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
                                            <?php if ($advert['advert']->main_image): ?>
                                                <img src="<?= htmlspecialchars($advert['advert']->main_image) ?>"
                                                     class="img-fluid rounded-start w-100 h-100"
                                                     alt="Imagen propiedad"
                                                     style="object-fit: cover; min-height: 200px;">
                                            <?php else: ?>
                                                <img src="/ruta/a/imagen-default.jpg"
                                                     class="img-fluid rounded-start w-100 h-100"
                                                     alt="Sin imagen"
                                                     style="object-fit: cover; min-height: 200px;">
                                            <?php endif; ?>
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
                                                    <span class="badge text-bg-success fs-6"><?= htmlspecialchars($advert['advert']->price) ?> €</span>
                                                </p>
                                                <p class="card-text mb-1">
                                                    <span class="badge text-bg-secondary"><?= htmlspecialchars($advert['property']->status) ?></span>
                                                </p>
                                                <p class="card-text flex-grow-1 d-flex align-items-end">
                                                    <?= htmlspecialchars($advert['advert']->description) ?>
                                                </p>
                                                <div class="mt-2 d-flex justify-content-evenly align-items-center">
                                                    <button class="btn btn-outline-danger btn-sm" title="Añadir a favoritos"><i class="bi bi-heart-fill"></i></button>
                                                    <a href="/detallePropiedad?id=<?= urlencode($advert['advert']->id) ?>" class="btn btn-primary btn-sm" title="Ver detalles">Ver detalles</a>
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
                            <a class="page-link" href="?page=<?= $page - 1 ?>" tabindex="-1">&laquo;</a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $page === $i ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $page === $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>