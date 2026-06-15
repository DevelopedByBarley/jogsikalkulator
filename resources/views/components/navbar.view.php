

<nav class="navbar navbar-expand-lg" id="mainNavbar">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand" href="/">
            jogsikalkulator<span class="accent">.hu</span>
        </a>

        <!-- Mobile toggler -->
        <button class="navbar-toggler border-0 shadow-none" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNavbarCollapse"
                aria-controls="mainNavbarCollapse" aria-expanded="false" aria-label="Menü">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav items -->
        <div class="collapse navbar-collapse" id="mainNavbarCollapse">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/rolunk">Rólunk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/alapkovetelmenyek">Alapkövetelmények</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/kepzes-menete">Képzés menete</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/hasznos-tippek">Hasznos tippek</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/">Jogsikalkulátor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/iskolavalasztas">Iskolaválasztás</a>
                </li>
            </ul>

            <!-- Right side icons + logout -->
            <div class="d-flex align-items-center gap-1">
                <a href="/" class="nav-icon" title="Főoldal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
                        <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
                    </svg>
                </a>
                <a href="/contact" class="nav-icon" title="Kapcsolat">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                    </svg>
                </a>
                <?php if (checkAuth('user')): ?>
                    <span class="text-secondary small ms-2 d-none d-lg-inline">
                        Üdv, <strong><?= htmlspecialchars($_SESSION['user']['name'] ?? 'Felhasználó', ENT_QUOTES, 'UTF-8') ?></strong>
                    </span>
                    <form method="POST" action="/user/logout" class="m-0 ms-1">
                        <?php if (function_exists('csrf_field')) echo csrf_field(); ?>
                        <button type="submit" class="btn btn-sm btn-outline-secondary" style="font-size:0.72rem; padding: 3px 12px;">
                            Kilépés
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Scroll shadow
        const navbar = document.getElementById('mainNavbar');
        window.addEventListener('scroll', function () {
            navbar.classList.toggle('shadow-sm', window.scrollY > 10);
        });

        // Active link
        const currentPath = window.location.pathname;
        document.querySelectorAll('#mainNavbar .nav-link').forEach(function (link) {
            const href = link.getAttribute('href');
            if (href === currentPath || (href !== '/' && currentPath.startsWith(href))) {
                link.classList.add('active');
            }
        });
    });
</script>
