<?php
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use dtos\UserDto;

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

?>

<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>
<main>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h2 class="mb-0">Perfil de usuario</h2>
                    </div>
                    <div class="card-body text-center">
                        <?php if ($user): ?>
                            <h4 class="mb-3"><?= htmlspecialchars($user->name ?? $user->email ?? 'Usuario') ?></h4>
                            <p class="mb-4"><?= htmlspecialchars($user->email ?? '') ?></p>
                        <?php else: ?>
                            <div class="alert alert-warning">No se ha iniciado sesión.</div>
                        <?php endif; ?>

                        <div class="d-grid gap-3">
                            <a href="/mis-propiedades.php" class="btn btn-outline-primary btn-lg">Ver mis propiedades</a>
                            <a href="/mis-anuncios.php" class="btn btn-outline-secondary btn-lg">Ver mis anuncios</a>
                            <a href="/editar-usuario.php" class="btn btn-outline-success btn-lg">Editar mis datos</a>
                            <form action="/eliminar-cuenta.php" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');">
                                <button type="submit" class="btn btn-outline-danger btn-lg w-100">Eliminar cuenta</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once __DIR__ . '/partials/footer.php'; ?>