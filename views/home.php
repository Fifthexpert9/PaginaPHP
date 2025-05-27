<?php
require_once __DIR__ . '/../vendor/autoload.php';

use facades\AdvertFacade;
use converters\AdvertConverter;
use converters\ImageConverter;
use converters\PropertyConverter;

// Crear las dependencias necesarias
$advertFacade = new AdvertFacade(new AdvertConverter(), new PropertyConverter(), new ImageConverter());

// Obtener los anuncios desde la facade
$adverts = $advertFacade->getAllAdverts();
//$adverts = [];
?>

<?php require_once __DIR__ . '/partials/head.php'; ?>
<!-- Header -->
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary py-1">
        <div class="container d-flex align-items-center">
            <a class="navbar-brand logo" href="#">houspecial</a>
            <ul class="navbar-nav mb-2 mb-lg-0 flex-row gap-4">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-plus-lg icon"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-house-heart icon"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-person-fill icon"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
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
                                <label for="tipo" class="form-label">Tipo</label>
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
                                <label for="ciudad" class="form-label">Ciudad</label>
                                <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Ej: Madrid">
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
                        <?php foreach ($adverts as $advert): ?>
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">
                                            <?= htmlspecialchars($advert['title']) ?>
                                        </h5>
                                        <p class="card-text mb-1">
                                            <?= htmlspecialchars($advert['property']->built_size) ?> m²
                                        </p>
                                        <p class="card-text mb-1">
                                            <span class="badge bg-success fs-6"><?= htmlspecialchars($advert['advert']->price) ?> €</span>
                                        </p>
                                        <p class="card-text mb-1">
                                            <span class="badge bg-secondary"><?= htmlspecialchars($advert['property']->status) ?></span>
                                        </p>
                                        <p class="card-text flex-grow-1 d-flex align-items-end">
                                            <?= htmlspecialchars($advert['advert']->description) ?>
                                        </p>
                                        <div class="mt-2 d-flex justify-content-evenly align-items-center">
                                            <button class="btn btn-outline-danger btn-sm" title="Añadir a favoritos"><i class="bi bi-heart-fill"></i></button>
                                            <a href="/detallePropiedad?id=<?= urlencode($advert['advert']->id) ?>" class="btn btn-primary btn-sm">Ver detalles</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>