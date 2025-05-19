<?php
require_once 'controllers/productoController.php';
$productoController = new ProductoController();

// Obtener filtros desde GET
$nombre = $_GET['nombre'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$precioMax = $_GET['precio_max'] ?? '';

// Obtener productos y categorías
$productos = $productoController->getProductosFiltrados($nombre, $categoria, $precioMax);
$categorias = $productoController->getCategoriasDisponibles();

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
        <option value="piso">Piso</option>
        <option value="casa">Casa</option>
        <option value="habitacion">Habitación</option>
      </select>

      <label for="precioMax">Precio máximo</label>
      <input type="number" step="0.01" name="precio_max" id="precioMax" placeholder="Ej: 1000" value="<?= htmlspecialchars($_GET['precio_max'] ?? '') ?>">

      <label for="habitaciones">Habitaciones</label>
      <input type="number" name="habitaciones" id="habitaciones" placeholder="Ej: 3" value="<?= htmlspecialchars($_GET['habitaciones'] ?? '') ?>">

      <button type="submit">Aplicar filtros</button>
    </form>
  </aside>

  <!-- Contenido principal -->
  <main class="properties">
    <h2>Propiedades disponibles</h2>
    <div class="properties-grid">
      <!-- Aquí se iteran las propiedades -->
      <?php foreach ($productos as $producto): ?>
        <div class="property-card">
          <img src="<?= htmlspecialchars($producto->getImagen()) ?>" alt="<?= htmlspecialchars($producto->getNombre()) ?>">
          <h3><?= htmlspecialchars($producto->getNombre()) ?></h3>
          <p><?= htmlspecialchars($producto->getDescripcion()) ?></p>
          <p class="price">€<?= htmlspecialchars($producto->getPrecio()) ?></p>
          <a href="/detallePropiedad?id=<?= $producto->getId() ?>" class="btn-detalle">Ver detalles</a>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

  <!-- Anuncios destacados -->
  <aside class="ads">
    <h3>Anuncios destacados</h3>
    <div class="ads-list">
      <!-- Aquí se iteran los anuncios -->
      <?php foreach ($anuncios as $anuncio): ?>
        <div class="ad-card">
          <h4><?= htmlspecialchars($anuncio->getTitulo()) ?></h4>
          <p><?= htmlspecialchars($anuncio->getDescripcion()) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </aside>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
