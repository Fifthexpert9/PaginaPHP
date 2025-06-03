<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>

<main class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-4">
            <h2 class="mt-2 mb-0 logo">houspecial</h2>
            <?php if (!empty($_SESSION['message'])): ?>
                <div class="alert alert-secondary mt-3">
                    <?= htmlspecialchars($_SESSION['message']);
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
                <?php else: ?>
                    <button id="goHome" class="btn btn-secondary mt-4 btn-font">ir a la pagina principal</button>
                <?php endif; ?>
            </div>
            <p class="text-muted mt-4" style="font-size: 0.95em;">Serás redirigido automáticamente a la página principal en unos segundos...</p>
        </div>
    </div>
</main>

<script>
    /*setTimeout(function() {
        window.location.href = '/';
    }, 10000);*/

    document.addEventListener('DOMContentLoaded', function() {
        var goBack = document.getElementById('goBack');
        if (goBack) {
            goBack.addEventListener('click', function() {
                window.location.href = '/login';
            });
        }
        var goHome = document.getElementById('goHome');
        if (goHome) {
            goHome.addEventListener('click', function() {
                window.location.href = '/';
            });
        }
    });
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>