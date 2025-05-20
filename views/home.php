<?php

require_once __DIR__ . '/../controllers/PropertyController.php';

use controllers\PropertyController;
use controllers\AdvertController;
use services\AdvertService;

// Instancias
$propertyController = new PropertyController();

// Obtener filtros desde GET
$tipo = $_GET['tipo'] ?? '';
$precioMax = $_GET['precio_max'] ?? '';
$habitaciones = $_GET['habitaciones'] ?? '';

// Obtener propiedades filtradas usando el controller
$propiedades = $propertyController->getFilteredProperties($tipo, $precioMax, $habitaciones);

// Obtener anuncios destacados (opcional)
require_once __DIR__ . '/../controllers/AdvertController.php';
$advertController = new AdvertController();
$anuncios = $advertController->getFeaturedAdverts();

require_once __DIR__ . '/header.php';
?>

<div class="main-layout">
  <!-- Filtros -->
  <aside class="filters">
    <h3>Filtrar propiedades</h3>
    <form method="GET" class="filter-form">
      <label for="tipo">Tipo</label>
      <select name="tipo" id="tipo">
        <option value="">Todos</option>
        <option value="piso" <?= $tipo === 'piso' ? 'selected' : '' ?>>Piso</option>
        <option value="casa" <?= $tipo === 'casa' ? 'selected' : '' ?>>Casa</option>
        <option value="habitacion" <?= $tipo === 'habitacion' ? 'selected' : '' ?>>Habitación</option>
      </select>

      <label for="precioMax">Precio máximo</label>
      <input type="number" step="0.01" name="precio_max" id="precioMax" placeholder="Ej: 1000" value="<?= htmlspecialchars($precioMax) ?>">

      <label for="habitaciones">Habitaciones</label>
      <input type="number" name="habitaciones" id="habitaciones" placeholder="Ej: 3" value="<?= htmlspecialchars($habitaciones) ?>">

      <button type="submit">Aplicar filtros</button>
    </form>
  </aside>

  <!-- Contenido principal -->
  <main class="properties">
    <h2>Propiedades disponibles</h2>
    <div class="properties-grid">
      <?php if (empty($propiedades)): ?>
        <p>No se encontraron propiedades con los filtros seleccionados.</p>
      <?php else: ?>
        <?php foreach ($propiedades as $propiedad): ?>
          <div class="property-card">
            <h3><?= htmlspecialchars($propiedad->getPropertyType()) ?></h3>
            <p>Superficie: <?= htmlspecialchars($propiedad->getBuiltSize()) ?> m²</p>
            <p class="price">€<?= htmlspecialchars($propiedad->getPrice()) ?></p>
            <p>Habitaciones: <?= htmlspecialchars($propiedad->getStatus()) ?></p>
            <a href="/detallePropiedad?id=<?= $propiedad->getId() ?>" class="btn-detalle">Ver detalles</a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>

  <!-- Anuncios destacados -->
  <aside class="ads">
    <h3>Anuncios destacados</h3>
    <div class="ads-list">
      <?php if (empty($anuncios)): ?>
        <p>No hay anuncios destacados en este momento.</p>
      <?php else: ?>
        <?php foreach ($anuncios as $anuncio): ?>
          <div class="ad-card">
            <h4><?= htmlspecialchars($anuncio->getTitulo()) ?></h4>
            <p><?= htmlspecialchars($anuncio->getDescripcion()) ?></p>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </aside>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
