<?php
require_once 'controllers/productoController.php';
$productoController = new ProductoController();
$producto = $productoController->getOneProduct($_GET['id']);

require_once __DIR__ . '/header.php';
?>

<div class="main-container">
    <h2>Editar Producto</h2>
    <form action="/editarProductoControl" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto->getId()); ?>">
        
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($producto->getNombre()); ?>" required>
        </div>

        <div class="form-group">
            <label for="imagen">Imagen (URL)</label>
            <input type="text" name="imagen" id="imagen" value="<?php echo htmlspecialchars($producto->getImagen()); ?>" required>
        </div>


        <button type="submit">Guardar Cambios</button>
    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>


