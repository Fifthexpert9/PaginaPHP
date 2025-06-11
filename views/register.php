<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>

<?php
$old = $_SESSION['register_old'] ?? [];
$errors = $_SESSION['register_errors'] ?? [];
unset($_SESSION['register_old'], $_SESSION['register_errors']);

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

<main class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-sm p-4" style="max-width: 650px; width: 100%;">
        <div class="text-center mb-2">
            <h2 class="mt-2 mb-0 logo">houspecial</h2>
            <h5 class="text-muted mt-3">¡Crea tu cuenta ahora y encuentra la mejor oferta para tu hogar!</h5>
        </div>
        <form id="registerForm" action="/controllers/Register.php" method="POST" novalidate>
            <div class="row">
                <div class="col-12 col-md-6 pe-3">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico *</label>
                        <input type="email" class="form-control<?= field_error('email', $errors) ? ' is-invalid' : '' ?>" id="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                        <div id="emailError" class="invalid-feedback" style="display:none;"></div>
                        <?= field_error('email', $errors) ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña *</label>
                        <input type="password" class="form-control<?= field_error('contraseña', $errors) ? ' is-invalid' : '' ?>" id="password" name="password" required>
                        <div id="passwordError" class="invalid-feedback" style="display:none;"></div>
                        <?= field_error('contraseña', $errors) ?>
                    </div>
                </div>
                <div class="col-12 col-md-6 border-start ps-3">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre *</label>
                        <input type="text" class="form-control<?= field_error('nombre', $errors) ? ' is-invalid' : '' ?>" id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
                        <div id="nameError" class="invalid-feedback" style="display:none;"></div>
                        <?= field_error('nombre', $errors) ?>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Apellido *</label>
                        <input type="text" class="form-control<?= field_error('apellido', $errors) ? ' is-invalid' : '' ?>" id="last_name" name="last_name" value="<?= htmlspecialchars($old['last_name'] ?? '') ?>" required>
                        <div id="lastNameError" class="invalid-feedback" style="display:none;"></div>
                        <?= field_error('apellido', $errors) ?>
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

<?php require_once __DIR__ . '/partials/footer.php'; ?>
<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    let valid = true;

    // Limpiar mensajes anteriores
    ['email','name','last_name','password'].forEach(function(id) {
        document.getElementById(id + 'Error').style.display = 'none';
        document.getElementById(id).classList.remove('is-invalid');
    });

    // Validaciones
    const email = document.getElementById('email').value.trim();
    const name = document.getElementById('name').value.trim();
    const lastName = document.getElementById('last_name').value.trim();
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

    if (!name) {
        document.getElementById('nameError').textContent = 'El nombre es obligatorio.';
        document.getElementById('nameError').style.display = 'block';
        document.getElementById('name').classList.add('is-invalid');
        valid = false;
    }

    if (!lastName) {
        document.getElementById('lastNameError').textContent = 'El apellido es obligatorio.';
        document.getElementById('lastNameError').style.display = 'block';
        document.getElementById('last_name').classList.add('is-invalid');
        valid = false;
    }

    if (!password) {
        document.getElementById('passwordError').textContent = 'La contraseña es obligatoria.';
        document.getElementById('passwordError').style.display = 'block';
        document.getElementById('password').classList.add('is-invalid');
        valid = false;
    } else if (password.length < 6) {
        document.getElementById('passwordError').textContent = 'La contraseña debe tener al menos 6 caracteres.';
        document.getElementById('passwordError').style.display = 'block';
        document.getElementById('password').classList.add('is-invalid');
        valid = false;
    }

    if (!valid) e.preventDefault();
});
</script>