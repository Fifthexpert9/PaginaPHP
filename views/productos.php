<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario'])) {
    header('Location: /login');
    exit();
}

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../controllers/ProductoController.php';

$productoController = new ProductoController();
$productos = $productoController->getProductos();
?>

<div class="container">
    <h1>Gestión de Productos</h1>
    <a href="/agregarProducto" class="btn-agregar">Agregar Nuevo Producto</a>
    
    <table class="tabla-productos">
        <thead>
            <tr>
                <?php /* <th>ID</th> */ ?>
                <th>Imagen</th>
                <th>Nombre</th>
                <?php /* <th>Descripción</th>
                <th>Precio</th> */ ?>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
            <tr>
                <?php /* <td><?php echo htmlspecialchars($producto->getId()); ?></td> */ ?>
                <td><img src="<?php echo htmlspecialchars($producto->getImagen()); ?>" 
                         alt="<?php echo htmlspecialchars($producto->getNombre()); ?>" 
                         class="producto-miniatura"></td>
                <td><?php echo htmlspecialchars($producto->getNombre()); ?></td>
                <?php /* 
                <td><?php echo htmlspecialchars($producto->getDescripcion()); ?></td>
                <td>€<?php echo htmlspecialchars($producto->getPrecio()); ?></td>
                */ ?>
                <td>
                    <a href="/editarProducto?id=<?php echo $producto->getId(); ?>" class="btn-editar">Editar</a>
                    <form action='../controllers/eliminarProducto.php' method='POST' style='display: inline;'>
                        <input type="hidden" name="id" value="<?php echo $producto->getId(); ?>">
                        <button type="submit" class="btn-eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
    .container {
        padding: 2rem;
    }
    
    .tabla-productos {
        width: 100%;
        border-collapse: collapse;
        margin-top: 2rem;
    }
    
    .tabla-productos th,
    .tabla-productos td {
        padding: 1rem;
        border: 1px solid #ddd;
        text-align: left;
    }
    
    .tabla-productos th {
        background-color: #333;
        color: white;
    }
    
    .producto-miniatura {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }
    
    .btn-agregar {
        display: block;  /* Cambiar a block para poder centrarlo */
        width: fit-content;  /* Ajustar el ancho al contenido */
        padding: 0.5rem 1rem;
        background-color: #28a745;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        margin: 2rem auto;  /* Centrar usando margin auto y añadir margen superior */
        transition: background-color 0.3s ease;  /* Añadir transición suave */
    }
    
    .btn-agregar:hover {
        background-color: #218838;  /* Color más oscuro al hover */
    }
    
    .btn-editar,
    .btn-eliminar {
        display: inline-block;
        width: 100px; /* Ancho fijo para ambos botones */
        padding: 0.5rem 0;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        margin: 0.3rem;  /* Espacio uniforme alrededor de los botones */
        color: white;
        text-decoration: none;
        text-align: center; /* Centrar el texto */
        font-size: 0.9rem; /* Tamaño de fuente uniforme */
    }
    
    .btn-editar {
        background-color: #ffc107;
    }
    
    .btn-eliminar {
        background-color: #dc3545;
    }

    .btn-editar:hover {
        background-color: #e0a800;
    }

    .btn-eliminar:hover {
        background-color: #c82333;
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 1rem;
    }
</style>

<?php require_once __DIR__ . '/footer.php'; ?>