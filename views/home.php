<?php
require_once 'controllers/productoController.php';
$productoController = new ProductoController();
$productos = $productoController->getProductos();

// Obtener filtros del formulario
$nombre = $_GET['nombre'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$precioMax = $_GET['precio_max'] ?? '';

// Obtener productos filtrados
$productos = $productoController->getProductosFiltrados($nombre, $categoria, $precioMax);

require_once __DIR__ . '/header.php';
?>

<main>
    <h1>Bienvenido a Tienda Online</h1>
    <p>Encuentra los mejores productos a los mejores precios.</p>

    <div style="display: flex;">
        <!-- Columna de filtros -->
        <aside style="width: 25%; padding-right: 20px;">
            <h3>Filtrar productos</h3>
            <form method="GET">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>"><br><br>

                <label>Categoría:</label>
                <input type="text" name="categoria" value="<?php echo htmlspecialchars($categoria); ?>"><br><br>

                <label>Precio máximo:</label>
                <input type="number" name="precio_max" step="0.01" value="<?php echo htmlspecialchars($precioMax); ?>"><br><br>

                <button type="submit">Aplicar filtros</button>
            </form>
        </aside>

        <!-- Columna de productos -->
        <div style="width: 75%;">
            <div class="container grid">
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
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>