<?php
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

?>

<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>
<main>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <h2 class="logo text-center mt-3">perfil de usuario</h2>
                    <div class="card-body text-center">
                        <?php if ($user): ?>
                            <h4 class="mb-3">¡Bienvenido, <?= htmlspecialchars($user->username ?? $user->email ?? 'Usuario') ?>!</h4>
                        <?php else: ?>
                            <div class="alert alert-warning">No se ha iniciado sesión.</div>
                        <?php endif; ?>

                        <div class="d-grid gap-3">
                            <a href="/my-properties" class="btn btn-secondary btn-lg btn-font">ver mis propiedades</a>
                            <a href="/my-adverts" class="btn btn-secondary btn-lg btn-font">ver mis anuncios</a>
                            <a href="/edit-profile" class="btn btn-secondary btn-lg btn-font">editar mis datos</a>
                            <a href="/delete-account"
                                class="btn btn-danger btn-lg btn-font"
                                onclick="return confirm('¿Seguro que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');">
                                eliminar cuenta
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once __DIR__ . '/partials/footer.php'; ?>