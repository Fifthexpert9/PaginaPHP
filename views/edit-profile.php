<?php
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user']->id)) {
    $_SESSION['message'] = 'Debes iniciar sesión para acceder a esta funcionalidad.';
    header('Location: /message');
    exit();
}

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

?>

<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>
<main>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <h2 class="logo text-center mt-3">editar perfil</h2>
                    <div class="card-body">
                        <?php if ($user): ?>
                            <form action="/controllers/EditProfile.php" method="POST">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="<?= htmlspecialchars($user->name ?? '') ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                           value="<?= htmlspecialchars($user->last_name ?? '') ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="<?= htmlspecialchars($user->email ?? '') ?>" required>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-lg btn-font">guardar cambios</button>
                                    <a href="/user-menu" class="btn btn-secondary btn-lg btn-font" title="Volver atrás">cancelar</a>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-warning">No se ha iniciado sesión.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once __DIR__ . '/partials/footer.php'; ?>