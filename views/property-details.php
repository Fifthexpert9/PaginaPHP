<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>

<?php if (!isset($_SESSION['user']) || !isset($_SESSION['user']->id)) {
    $_SESSION['message'] = 'Debes iniciar sesión para acceder a esta funcionalidad.';
    header('Location: /message');
    exit();
}
?>

<main>
    <div class="container my-5">
        <?php if (!isset($propertyDto) || !$propertyDto): ?>
            <?php $_SESSION['message'] = 'No se ha encontrado la propiedad solicitada.'; ?>
            <?php header('Location: /message'); exit(); ?>
        <?php elseif ($propertyDto->user_id !== $_SESSION['user']->id): ?>
            <?php $_SESSION['message'] = 'No puedes ver los detalles de esta propiedad porque no te pertenece.'; ?>
            <?php header('Location: /message'); exit(); ?>
        <?php else: ?>
            <div class="row">
                <!-- Título -->
                <h2 class="mb-3"><?= htmlspecialchars($title) ?></h2>

                <!-- Información principal -->
                <div class="col-12 col-lg-5">
                    <div>
                        <h4>Características generales de la vivienda</h4>
                        <ul class="list-unstyled ms-3">
                            <li><strong>Tipo:</strong> <?= htmlspecialchars($propertyDto->property_type ?? 'No especificado') ?></li>
                            <li><strong>Ubicación:</strong> <?= htmlspecialchars($propertyDto->address->city ?? 'No especificada') ?>, <?= htmlspecialchars($propertyDto->address->province ?? 'no especificada') ?> (<?= htmlspecialchars($propertyDto->address->country ?? 'no especificado') ?>)</li>
                            <li><strong>Estado:</strong> <?= htmlspecialchars($propertyDto->status ?? 'No especificado') ?></li>
                            <li><strong>Disponibilidad:</strong> <?= htmlspecialchars($propertyDto->immediate_availability ? 'Inmediata' : 'Tendrás que esperar un poco ^^U') ?></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Características específicas de la vivienda</h4>
                        <ul class="list-unstyled ms-3">
                            <?php if ($propertyDto instanceof dtos\RoomDto): ?>
                                <li><strong>¿Baño privado?</strong> <?= htmlspecialchars($propertyDto->private_bathroom ? 'Sí' : 'No') ?></li>
                                <li><strong>¿Cuántos vivimos en el piso?</strong> Actualmente somos <?= htmlspecialchars($propertyDto->max_roommates) ?></li>
                                <li><strong>¿Está amueblado?</strong> <?= htmlspecialchars($propertyDto->furnished ? 'Sí' : 'No') ?></li>
                                <li><strong>¿Hay restricciones de género?</strong> <?= htmlspecialchars($propertyDto->gender_restriction) ?></li>
                                <li><strong>¿Se permiten mascotas?</strong> <?= htmlspecialchars($propertyDto->pets_allowed ? 'Sí' : 'No') ?></li>
                            <?php elseif ($propertyDto instanceof dtos\StudioDto): ?>
                                <li><strong>¿Tiene balcón o una pequeña terraza?</strong> <?= htmlspecialchars($propertyDto->balcony ? 'Sí' : 'No') ?></li>
                                <li><strong>¿Está amueblado?</strong> <?= htmlspecialchars($propertyDto->furnished ? 'Sí' : 'No') ?></li>
                                <li><strong>¿Tiene aire acondicionado?</strong> <?= htmlspecialchars($propertyDto->air_conditioning ? 'Sí' : 'No') ?></li>
                                <li><strong>¿Se permiten mascotas?</strong> <?= htmlspecialchars($propertyDto->pets_allowed ? 'Sí' : 'No') ?></li>
                            <?php elseif ($propertyDto instanceof dtos\ApartmentDto): ?>
                                <li><strong>Tipo de piso:</strong> <?= htmlspecialchars($propertyDto->apartment_type) ?></li>
                                <li><strong>¿En qué planta está?</strong> <?= htmlspecialchars($propertyDto->floor) ?></li>
                                <li><strong>¿Tiene ascensor?</strong> <?= htmlspecialchars($propertyDto->elevator ? 'Sí' : 'No') ?></li>
                                <li><strong>¿Tiene garaje?</strong> <?= htmlspecialchars($propertyDto->garage ? 'Sí' : 'No') ?></li>
                                <li><strong>Número de habitaciones:</strong> <?= htmlspecialchars($propertyDto->num_rooms) ?></li>
                                <li><strong>Número de baños:</strong> <?= htmlspecialchars($propertyDto->num_bathrooms) ?></li>
                                <li><strong>¿Está amueblado?</strong> <?= htmlspecialchars($propertyDto->furnished ? 'Sí' : 'No') ?></li>
                                <li><strong>¿Tiene balcón o una pequeña terraza?</strong> <?= htmlspecialchars($propertyDto->balcony ? 'Sí' : 'No') ?></li>
                                <li><strong>¿Tiene aire acondicionado?</strong> <?= htmlspecialchars($propertyDto->air_conditioning ? 'Sí' : 'No') ?></li>
                                <li><strong>¿Se permiten mascotas?</strong> <?= htmlspecialchars($propertyDto->pets_allowed ? 'Sí' : 'No') ?></li>
                            <?php elseif ($propertyDto instanceof dtos\HouseDto): ?>
                                <li><strong>Tipo de casa:</strong> <?= htmlspecialchars($propertyDto->house_type) ?></li>
                                <li><strong>Tamaño del jardín:</strong> <?= htmlspecialchars($propertyDto->garden_size) ?> m²</li>
                                <li><strong>Número de plantas:</strong> <?= htmlspecialchars($propertyDto->num_floors) ?></li>
                                <li><strong>Número de habitaciones:</strong> <?= htmlspecialchars($propertyDto->num_rooms) ?></li>
                                <li><strong>Número de baños:</strong> <?= htmlspecialchars($propertyDto->num_bathrooms) ?></li>
                                <li><strong>¿Tiene garaje privado?</strong> <?= htmlspecialchars($propertyDto->private_garage ? 'Sí' : 'No') ?></li>
                                <li><strong>¿Tiene piscina privada?</strong> <?= htmlspecialchars($propertyDto->private_pool ? 'Sí' : 'No') ?></li>
                                <li><strong>¿Tiene trastero?</strong> <?= htmlspecialchars($propertyDto->storage_room ? 'Sí' : 'No') ?></li>
                                <li><strong>¿Está amueblado?</strong> <?= htmlspecialchars($propertyDto->furnished ? 'Sí' : 'No') ?></li>
                                <li><strong>¿Tiene terraza o porche?</strong> <?= htmlspecialchars($propertyDto->terrace ? 'Sí' : 'No') ?></li>
                                <li><strong>¿Tiene aire acondicionado?</strong> <?= htmlspecialchars($propertyDto->air_conditioning ? 'Sí' : 'No') ?></li>
                                <li><strong>¿Se permiten mascotas?</strong> <?= htmlspecialchars($propertyDto->pets_allowed ? 'Sí' : 'No') ?></li>
                            <?php else: ?>
                                No se han especificado características para esta propiedad.
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <!-- Imagen principal y galería en carrusel -->
                <div class="col-12 col-lg-7 mb-4">
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
                                            style="object-fit:cover; min-height:250px; max-height:350px; cursor:pointer;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#imageModal"
                                            onclick="document.getElementById('modalImage').src=this.src;">
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
                        <!-- Miniaturas debajo del carrusel -->
                        <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                            <?php foreach ($propertyDto->images as $idx => $img): ?>
                                <img src="/<?= htmlspecialchars($img) ?>"
                                    class="rounded shadow-sm"
                                    alt="Miniatura propiedad"
                                    style="width: 70px; height: 60px; object-fit:cover; cursor:pointer; border:2px solid #ddd;"
                                    data-bs-target="#propertyImagesCarousel"
                                    data-bs-slide-to="<?= $idx ?>"
                                    <?= $idx === 0 ? 'aria-current="true"' : '' ?>>
                            <?php endforeach; ?>
                        </div>
                    <?php elseif (sizeof($propertyDto->images) == 1): ?>
                        <img src="/<?= htmlspecialchars($propertyDto->main_image) ?>"
                            alt="Imagen principal"
                            class="img-fluid rounded shadow-sm w-100 mb-3"
                            style="object-fit:cover; min-height:250px; max-height:400px;">
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0">
                    <img src="" id="modalImage" class="img-fluid rounded shadow" alt="Imagen ampliada">
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>