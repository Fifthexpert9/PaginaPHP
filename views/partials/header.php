<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary py-1">
        <div class="container d-flex align-items-center">
            <a class="navbar-brand logo" href="/">houspecial</a>
            <ul class="navbar-nav mb-2 mb-lg-0 flex-row gap-4">
                <li class="nav-item">
                    <a class="nav-link text-black" href="#"><i class="bi bi-plus-lg icon"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-black" href="#"><i class="bi bi-house-heart icon"></i></a>
                </li>
                <?php if (!empty($_SESSION['logged']) && $_SESSION['logged']): ?>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="/user-menu"><i class="bi bi-person-circle icon"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="/logout"><i class="bi bi-box-arrow-right icon"></i></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="/login"><i class="bi bi-door-open-fill icon"></i></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>