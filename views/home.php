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

<main>
    <h1>Bienvenido a Tienda Online</h1>
    <p>Encuentra los mejores productos a los mejores precios.</p>
    <br><br>

    <div class="shop-layout">
        <form method="GET" class="filter-form">
            <h3>Filtrar productos</h3>

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>">

            <label for="categoria">Categoría</label>
            <select name="categoria" id="categoria">
                <option value="">Todas</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>" <?= (($_GET['categoria'] ?? '') === $cat) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="precioMax">Precio máximo</label>
            <input type="number" step="0.01" name="precio_max" id="precioMax" value="<?= htmlspecialchars($_GET['precioMax'] ?? '') ?>">

            <button type="submit">Aplicar filtros</button>
        </form>

        <div class="productos-grid grid">
            <?php if (empty($productos)): ?>
                <p>No se encontraron productos.</p>
            <?php endif; ?>
            <?php foreach($productos as $producto):?>
                <div class="card">
                    <h2><?= htmlspecialchars($producto->getNombre()) ?></h2>
                    <img src="<?= htmlspecialchars($producto->getImagen()) ?>" alt="<?= htmlspecialchars($producto->getNombre()) ?>">
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <button type="submit">Añadir al carrito</button>
                    <?php else: ?>
                        <!-- <a href="#" class="login-card-btn" onclick="document.getElementById('loginBtn').click();">
                            <i class="material-icons">login</i> Iniciar Sesión
                        </a> -->
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>


<?php require_once __DIR__ . '/footer.php'; ?>
