<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>

<main>
    <div class="container my-5">
        <?php if (!isset($advertAux) || !$advertAux): ?>
            <div class="alert alert-danger text-center">No se ha encontrado el anuncio solicitado.</div>
        <?php else: ?>
            <div class="row">
                <!-- Imagen principal y galería -->
                <div class="col-12 col-md-5 mb-4">
                    <img src="/<?= htmlspecialchars($advertAux['advert']->main_image) ?>"
                         alt="Imagen principal"
                         class="img-fluid rounded shadow-sm w-100 mb-3"
                         style="object-fit:cover; min-height:250px; max-height:350px;">
                    <?php if (!empty($advertAux['images']) && count($advertAux['images']) > 1): ?>
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($advertAux['images'] as $img): ?>
                                <img src="/<?= htmlspecialchars($img->imagePath) ?>"
                                     alt="Imagen propiedad"
                                     class="img-thumbnail"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Información principal -->
                <div class="col-12 col-md-7">
                    <h2 class="mb-3"><?= htmlspecialchars($advertAux['title']) ?></h2>
                    <p>
                        <strong>Tipo:</strong>
                        <?= htmlspecialchars($advertAux['property']->property_type ?? 'No especificado') ?>
                    </p>
                    <p>
                        <strong>Ciudad:</strong>
                        <?= htmlspecialchars($advertAux['address']->city ?? 'No especificada') ?>
                    </p>
                    <p>
                        <strong>Precio:</strong>
                        <?= htmlspecialchars($advertAux['advert']->price) ?>
                        <?= $advertAux['advert']->action === 'Alquiler' ? '€/mes' : '€' ?>
                    </p>
                    <p>
                        <strong>Estado:</strong>
                        <?= htmlspecialchars($advertAux['property']->status ?? 'No especificado') ?>
                    </p>
                    <p>
                        <strong>Descripción:</strong><br>
                        <?= nl2br(htmlspecialchars($advertAux['advert']->description ?? '')) ?>
                    </p>
                    <!-- Puedes añadir más campos aquí según tu DTO -->
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>