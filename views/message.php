<?php require_once __DIR__ . '/partials/head.php'; ?>
<?php require_once __DIR__ . '/partials/header.php'; ?>

<main class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-4">
            <h2 class="mt-2 mb-0 logo">houspecial</h2>
            <?php if (!empty($_SESSION['message'])): ?>
                <div class="alert alert-secondary mt-3">
                    <?= htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>
            <button id="goHome" class="btn btn-secondary mt-4 btn-font">ir a la pagina principal</button>
            <p class="text-muted mt-4" style="font-size: 0.95em;">Serás redirigido automáticamente en unos segundos...</p>
        </div>
    </div>
</main>

<script>
    setTimeout(function() {
        window.location.href = '/';
    }, 10000);

    document.getElementById('goHome').addEventListener('click', function() {
        window.location.href = '/';
    });
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>