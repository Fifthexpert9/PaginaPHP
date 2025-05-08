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

    <div style="display: flex;">
        <!-- Filtros -->
        <aside style="width: 25%; padding-right: 20px;">
            <h3>Filtrar productos</h3>
            <form method="GET">
                <label>Nombre:</label><br>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>"><br><br>

                <label>Categoría:</label><br>
                <select name="categoria">
                    <option value="">-- Todas --</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat); ?>" <?php if ($cat == $categoria) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($cat); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>

                <label>Precio máximo:</label><br>
                <input type="number" name="precio_max" step="0.01" value="<?php echo htmlspecialchars($precioMax); ?>"><br><br>

                <button type="submit">Aplicar filtros</button>
            </form>
        </aside>

        <!-- Productos -->
        <div style="width: 75%;">
            <div class="container grid">
                <?php if (count($productos) > 0): ?>
                    <?php foreach ($productos as $producto): ?>
                        <div class="card">
                            <h2><?php echo htmlspecialchars($producto->getNombre()); ?></h2>
                            <img src="<?php echo htmlspecialchars($producto->getImagen()); ?>" 
                                 alt="<?php echo htmlspecialchars($producto->getNombre()); ?>">
                            <?php if (isset($_SESSION['usuario'])): ?>
                                <button type='submit'>Añadir al carrito</button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No se encontraron productos con esos filtros.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>
