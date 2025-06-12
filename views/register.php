<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>

<main class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-sm p-4" style="max-width: 650px; width: 100%;">
        <div class="text-center mb-2">
            <h2 class="mt-2 mb-0 logo">houspecial</h2>
            <h5 class="text-muted mt-3">¡Crea tu cuenta ahora y encuentra la mejor oferta para tu hogar!</h5>
        </div>
        <form action="/controllers/Register.php" method="POST">
            <div class="row">
                <div class="col-12 col-md-6 pe-3">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico *</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="tucorreo@email.com" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña *</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-12 col-md-6 border-start ps-3">
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Nombre *
                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Necesitamos esta información únicamente para crear el nombre de usuario único"></i>
                        </label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">
                            Apellido *
                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Necesitamos esta información únicamente para crear el nombre de usuario único"></i>
                        </label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="¡Sólo el primer apellido!" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-secondary w-100 btn-font mt-4">registrarse</button>
        </form>
        <div class="mt-3">
            <label for="obligatory" class="form-label" style="font-size: 0.8em;">
                *: Todos los campos son obligatorios.
            </label>
            <br>
            <label for="info" class="form-label" style="font-size: 0.8em;">
                Al hacer clic en "registrarse" estás aceptando los
                <a href="/terms-of-use" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" style="font-size: 0.95em;">Términos y condiciones</a>
                y la
                <a href="/privacy-policy" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" style="font-size: 0.95em;">Política de privacidad</a>
                de Houspecial.
            </label>
        </div>
        <div class="text-center mt-3">
            <span class="text-muted">¿Ya tienes una cuenta?</span>
            <a href="/login" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover ms-1">Inicia sesión</a>
        </div>
    </div>
</main>
<script>
    <?php require_once __DIR__ . '/assets/js/register-validation.js'; ?>
</script>
<?php require_once __DIR__ . '/partials/footer.php'; ?>