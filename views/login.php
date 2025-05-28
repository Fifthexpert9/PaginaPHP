<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>

<main class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-2">
            <h2 class="mt-2 mb-0 logo">houspecial</h2>
            <h5 class="text-muted mt-3">¡Inicia sesión y publica ahora tus anuncios!</p>
        </div>
        <form action="/controllers/Login.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="tucorreo@email.com" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-secondary w-100 btn-font mt-4">iniciar sesion</button>
        </form>
        <div class="text-center mt-3">
            <span class="text-muted">¿No tienes cuenta?</span>
            <a href="/register" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover ms-1">Regístrate</a>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>