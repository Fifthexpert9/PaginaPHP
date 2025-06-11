<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>

<main class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-sm p-3" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-4">
            <h2 class="mt-2 mb-0 logo">houspecial</h2>
            <?php if (!empty($_SESSION['message'])): ?>
                <div class="alert alert-secondary mt-3">
                    <?= $_SESSION['message'];
                    unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>
            <div>
                <?php if (isset($_SESSION['logged'])): ?>
                    <?php if (!$_SESSION['logged']): ?>
                        <button id="goBack" class="btn btn-secondary mt-4 btn-font">volver a intentarlo</button>
                    <?php elseif ($_SESSION['logged']): ?>
                        <button id="goHome" class="btn btn-secondary mt-4 btn-font">ir a la pagina principal</button>
                    <?php endif; ?>
                <?php elseif (isset($_SESSION['user_edited']) || isset($_SESSION['registered'])): ?>
                    <?php if (isset($_SESSION['user_edited']) && $_SESSION['user_edited']): ?>
                        <?php unset($_SESSION['user_edited']); ?>
                    <?php elseif (isset($_SESSION['registered']) && $_SESSION['registered']): ?>
                        <?php unset($_SESSION['registered']); ?>
                    <?php endif; ?>
                    <button id="goBack" class="btn btn-secondary mt-4 btn-font">iniciar sesion</button>
                <?php else: ?>
                    <button id="goHome" class="btn btn-secondary mt-4 btn-font">ir a la pagina principal</button>
                <?php endif; ?>
            </div>
            <p class="text-muted mt-4" style="font-size: 0.95em;">Serás redirigido automáticamente a la página principal en unos segundos...</p>
        </div>
    </div>
</main>

<script>
    <?php require_once __DIR__ . '/assets/js/message.js'; ?>
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>