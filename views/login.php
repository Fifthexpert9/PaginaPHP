<?php
$old = $_SESSION['login_old'] ?? [];
$errors = $_SESSION['login_errors'] ?? [];
unset($_SESSION['login_old'], $_SESSION['login_errors']);

// Función para mostrar error específico
function field_error($field, $errors) {
    foreach ($errors as $err) {
        if (stripos($err, $field) !== false) {
            return '<div class="invalid-feedback" style="display:block;">' . htmlspecialchars($err) . '</div>';
        }
    }
    return '';
}
?>
<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>

<main class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-2">
            <h2 class="mt-2 mb-0 logo">houspecial</h2>
            <h5 class="text-muted mt-3">¡Inicia sesión y publica ahora tus anuncios!</p>
        </div>
        <form id="loginForm" action="/controllers/Login.php" method="POST" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control<?= field_error('email', $errors) ? ' is-invalid' : '' ?>" id="email" name="email" placeholder="tucorreo@email.com" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                <div id="emailError" class="invalid-feedback" style="display:none;"></div>
                <?= field_error('email', $errors) ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control<?= field_error('contraseña', $errors) ? ' is-invalid' : '' ?>" id="password" name="password" placeholder="Contraseña" required>
                <div id="passwordError" class="invalid-feedback" style="display:none;"></div>
                <?= field_error('contraseña', $errors) ?>
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
<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    let valid = true;

    // Limpiar mensajes anteriores
    ['email','password'].forEach(function(id) {
        document.getElementById(id + 'Error').style.display = 'none';
        document.getElementById(id).classList.remove('is-invalid');
    });

    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    if (!email) {
        document.getElementById('emailError').textContent = 'El correo es obligatorio.';
        document.getElementById('emailError').style.display = 'block';
        document.getElementById('email').classList.add('is-invalid');
        valid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        document.getElementById('emailError').textContent = 'Introduce un email válido.';
        document.getElementById('emailError').style.display = 'block';
        document.getElementById('email').classList.add('is-invalid');
        valid = false;
    }

    if (!password) {
        document.getElementById('passwordError').textContent = 'La contraseña es obligatoria.';
        document.getElementById('passwordError').style.display = 'block';
        document.getElementById('password').classList.add('is-invalid');
        valid = false;
    }

    if (!valid) e.preventDefault();
});
</script>