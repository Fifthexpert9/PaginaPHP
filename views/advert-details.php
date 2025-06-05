<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>

<main>
    <div class="container my-5">
        <?php if (!isset($advertDto) || !$advertDto): ?>
            <div class="alert alert-danger text-center">No se ha encontrado el anuncio solicitado.</div>
        <?php else: ?>
            <div class="row">
                <!-- Título -->
                <h2 class="mb-3"><?= htmlspecialchars($title) ?></h2>

                <!-- Imagen principal y galería en carrusel -->
                <div class="col-12 col-lg-6 mb-4">
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

                <!-- Información principal -->
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-7">
                            <p class="mb-2"><strong>Tipo:</strong> <?= htmlspecialchars($propertyDto->property_type ?? 'No especificado') ?></p>
                            <p class="mb-2"><strong>Ubicación:</strong> <?= htmlspecialchars($propertyDto->address->city ?? 'No especificada') ?>, <?= htmlspecialchars($propertyDto->address->province ?? 'no especificada') ?> (<?= htmlspecialchars($propertyDto->address->country ?? 'no especificado') ?>)</p>
                            <p class="mb-2"><strong>Estado:</strong> <?= htmlspecialchars($propertyDto->status ?? 'No especificado') ?></p>
                            <p><strong>Disponibilidad:</strong> <?= htmlspecialchars($propertyDto->immediate_availability ? 'Inmediata' : 'Tendrás que esperar un poco ^^U') ?></p>
                        </div>
                        <div class="col-5 d-flex flex-column align-items-baseline">
                            <span class="fw-bold mb-1">Precio:</span>
                            <div class="border px-3 py-2 rounded bg-light fs-3 w-100">
                                <?= htmlspecialchars($advertDto->price) ?>
                                <?= $advertDto->action === 'Alquiler' ? '€/mes' : '€' ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 border bg-body-tertiary rounded px-4 pb-4">
                            <h4 class="spec-font mt-3">te interesa este anuncio?</h4>
                            <?php if (isset($_SESSION['user']) && $_SESSION['user']->id !== $advertDto->user_id): ?>
                                <p class="mb-1">El propietario recibirá un email con tu dirección de correo electrónico, ¡para que te contacte si le interesa tu oferta!</p>
                                <form action="send_message" method="post">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <p>De:</p>
                                            <p class="ms-2 spec-font-small"><?= $_SESSION['user']->username ?></p>
                                        </div>
                                        <div class="d-flex align-items-center" style="margin-top: -1em;">
                                            <p>Para:</p>
                                            <p class="ms-2 spec-font-small"><?= htmlspecialchars($propietaryUsername) ?></p>
                                        </div>
                                        <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                                    </div>
                                    <input type="hidden" name="advert_id" value="<?= htmlspecialchars($advertDto->id) ?>">
                                    <button type="submit" class="btn btn-secondary btn-font">enviar mensaje</button>
                                </form>
                            <?php elseif (isset($_SESSION['user']) && $_SESSION['user']->id === $advertDto->user_id): ?>
                                <p>
                                    Este es tu anuncio, <span class="spec-font-small"><?= htmlspecialchars($_SESSION['user']->username) ?></span>. Si quieres editarlo o borrarlo, puedes hacerlo desde tu perfil.
                                </p>
                                <div class="d-flex justify-content-center mt-4">
                                    <a href="/my-adverts" class="btn btn-secondary btn-font">ir a mis anuncios</a>
                                </div>
                            <?php else: ?>
                                <p>
                                    El envío de mensajes es una funcionalidad exclusiva de los usuarios de Houspecial. Si quieres contactar con <span class="spec-font-small"><?= htmlspecialchars($propietaryUsername) ?></span>, que es quien ha publicado el anuncio, primero debes iniciar sesión. Si no tienes una cuenta todavía, ¡puedes registrate ahora y empezar a buscar tu nuevo hogar!
                                </p>
                                <div class="d-flex justify-content-center gap-3 mt-4">
                                    <a href="/login" class="btn btn-secondary btn-font w-50">iniciar sesion</a>
                                    <a href="/register" class="btn btn-secondary btn-font w-50">registrarse</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-5">
                        <h4>Características de la vivienda</h4>
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
                                <?php if ($advertDto->action === 'Alquiler'): ?>
                                    <li><strong>¿Se permiten mascotas?</strong> <?= htmlspecialchars($propertyDto->pets_allowed ? 'Sí' : 'No') ?></li>
                                <?php endif; ?>
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
                                <?php if ($advertDto->action === 'Alquiler'): ?>
                                    <li><strong>¿Se permiten mascotas?</strong> <?= htmlspecialchars($propertyDto->pets_allowed ? 'Sí' : 'No') ?></li>
                                <?php endif; ?>
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
                                <?php if ($advertDto->action === 'Alquiler'): ?>
                                    <li><strong>¿Se permiten mascotas?</strong> <?= htmlspecialchars($propertyDto->pets_allowed ? 'Sí' : 'No') ?></li>
                                <?php endif; ?>
                            <?php else: ?>
                                No se han especificado características para esta propiedad.
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="col-lg-7">
                        <h4>Descripción</h4>
                        <br>
                        <?= nl2br(htmlspecialchars($advertDto->description ?? '')) ?>
                        </p>
                    </div>

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