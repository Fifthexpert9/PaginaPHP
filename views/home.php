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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Houspecial</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="nav">
            <div class="nav-left">
                <h1 class="app-name">Houspecial</h1>
            </div>
            <div class="nav-right">
                <a href="/addAdvert" class="nav-icon" title="Añadir anuncio">+</a>
                <a href="/favorites" class="nav-icon" title="Favoritos">❤️</a>
                <a href="/userMenu" class="nav-icon" title="Menú de usuario">👤</a>
            </div>
        </nav>
    </header>

    <!-- Anuncios -->
    <main class="properties">
        <h2>Propiedades disponibles</h2>
        <div class="properties-grid">
            <?php if (empty($adverts)): ?>
                <p>No se encontraron propiedades disponibles.</p>
            <?php else: ?>
                <?php foreach ($adverts as $advert): ?>
                    <div class="property-card">
                        <h3><?= htmlspecialchars($advert['title']) ?></h3>
                        <p><?= htmlspecialchars($advert['property']->built_size) ?> m²</p>
                        <p class="price">€<?= htmlspecialchars($advert['advert']->price) ?></p>
                        <p><?= htmlspecialchars($advert['property']->status) ?></p>
                        <p><?= htmlspecialchars($advert['advert']->description) ?></p>
                        <div class="card-actions">
                            <button class="btn-favorite" title="Añadir a favoritos">❤️</button>
                            <a href="/detallePropiedad?id=<?= urlencode($advert['id']) ?>" class="btn-detalle">Ver detalles</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>

<?php require_once __DIR__ . '/partials/footer.php'; ?>