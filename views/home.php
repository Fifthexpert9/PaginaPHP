<?php
require_once 'controllers/productoController.php';
$productoController = new ProductoController();
$productos = $productoController->getProductos();

require_once __DIR__ . '/header.php';
?>

<main>
    <h1>Bienvenido a Tienda Online</h1>
    <p>Encuentra los mejores productos a los mejores precios.</p>

    <br><br>
    
    <div class="container grid">
        <?php foreach($productos as $producto): ?>
            <div class="card">
                <h2><?php echo htmlspecialchars($producto->getNombre()); ?></h2>
                <img src="<?php echo htmlspecialchars($producto->getImagen()); ?>" 
                     alt="<?php echo htmlspecialchars($producto->getNombre()); ?>">
                <?php 
                  if (isset($_SESSION['usuario'])) {
                    echo "<button type='submit'>Añadir al carrito</button>";
                  }else{
                   // echo '<a href="#" class="login-card-btn" onclick="document.getElementById(\'loginBtn\').click();">
                   //         <i class="material-icons">login</i>
                   //         Iniciar Sesión
                   //       </a>';
                  } 
                /* 
                <p><?php echo htmlspecialchars($producto->getDescripcion()); ?></p>
                <p class="precio">€<?php echo htmlspecialchars($producto->getPrecio()); ?></p>
                <a href="producto.php?id=<?php echo $producto->getId(); ?>">Ver más</a>
                */ ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>