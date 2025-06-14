<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary py-1">
        <div class="container d-flex align-items-center">
            <a class="navbar-brand logo" href="/">houspecial</a>
            <ul class="navbar-nav mb-2 mb-lg-0 flex-row gap-4 align-items-center">
                <li class="nav-item">
                    <button id="open-translate" class="nav-link text-black icon-hover me-5" title="Traducir página" style="background:none;border:none;padding:0;">
                        <i class="bi bi-translate icon"></i>
                    </button>
                </li>
                <?php if (!empty($_SESSION['logged']) && $_SESSION['logged']): ?>
                    <li class="nav-item">
                        <a class="nav-link text-black icon-hover" href="/manager" title="Crear propiedad/anuncio"><i class="bi bi-plus-circle icon"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black icon-hover" href="/favorites" title="Lista de favoritos"><i class="bi bi-house-heart icon"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black icon-hover" href="/user-menu" title="Menú de usuario"><i class="bi bi-person icon"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black icon-hover" href="/logout" title="Logout"><i class="bi bi-door-open icon"></i></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-black icon-hover" href="/login" title="Regístrate o inicia sesión para crear anuncios"><i class="bi bi-plus-circle icon"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black icon-hover" href="/login" title="Regístrate o inicia sesión para tener favoritos"><i class="bi bi-house-heart icon"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black icon-hover" href="/login" title="Regístrate o inicia sesión"><i class="bi bi-person icon"></i></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>

<div id="google_translate_element" style="display:none;"></div>
<script src="/views/assets/js/header-translator.js"></script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>