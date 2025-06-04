<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>

<main>
    <div class="container my-5">
        <?php if (!isset($advertDto) || !$advertDto): ?>
            <div class="alert alert-danger text-center">No se ha encontrado el anuncio solicitado.</div>
        <?php else: ?>
            <div class="row">
                <!-- Imagen principal y galería en carrusel -->
                <div class="col-12 col-md-5 mb-4">
                    <?php if (!empty($propertyDto->images) && sizeof($propertyDto->images) > 1): ?>
                        <div id="propertyImagesCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <?php foreach ($propertyDto->images as $idx => $img): ?>
                                    <button type="button"
                                            data-bs-target="#propertyImagesCarousel"
                                            data-bs-slide-to="<?= $idx ?>"
                                            <?= $idx === 0 ? 'class="active" aria-current="true"' : '' ?>
                                            aria-label="Imagen <?= $idx + 1 ?>"></button>
                                <?php endforeach; ?>
                            </div>
                            <div class="carousel-inner">
                                <?php foreach ($propertyDto->images as $idx => $img): ?>
                                    <div class="carousel-item <?= $idx === 0 ? 'active' : '' ?>">
                                        <img src="/<?= htmlspecialchars($img) ?>"
                                             class="d-block w-100 rounded shadow-sm"
                                             alt="Imagen propiedad"
                                             style="object-fit:cover; min-height:250px; max-height:350px;">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if (count($propertyDto->images) > 1): ?>
                                <button class="carousel-control-prev" type="button" data-bs-target="#propertyImagesCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Anterior</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#propertyImagesCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Siguiente</span>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php elseif (sizeof($propertyDto->images) == 1): ?>
                        <img src="/<?= htmlspecialchars($propertyDto->main_image) ?>"
                             alt="Imagen principal"
                             class="img-fluid rounded shadow-sm w-100 mb-3"
                             style="object-fit:cover; min-height:250px; max-height:350px;">
                    <?php endif; ?>
                </div>
                <!-- Información principal -->
                <div class="col-12 col-md-7">
                    <h2 class="mb-3"><?= htmlspecialchars($title) ?></h2>
                    <p>
                        <strong>Tipo:</strong>
                        <?= htmlspecialchars($propertyDto->property_type ?? 'No especificado') ?>
                    </p>
                    <p>
                        <strong>Ciudad:</strong>
                        <?= htmlspecialchars($propertyDto->address->city ?? 'No especificada') ?>
                    </p>
                    <p>
                        <strong>Precio:</strong>
                        <?= htmlspecialchars($advertAux['advert']->price) ?>
                        <?= $advertAux['advert']->action === 'Alquiler' ? '€/mes' : '€' ?>
                    </p>
                    <p>
                        <strong>Estado:</strong>
                        <?= htmlspecialchars($propertyDto->status ?? 'No especificado') ?>
                    </p>
                    <p>
                        <strong>Descripción:</strong><br>
                        <?= nl2br(htmlspecialchars($advertDto->description ?? '')) ?>
                    </p>
                    <!-- Puedes añadir más campos aquí según tu DTO -->
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>