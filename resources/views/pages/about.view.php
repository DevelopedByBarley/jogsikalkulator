<!-- Page header -->
<div class="about-hero">
    <div class="about-hero-overlay"></div>
    <div class="container about-hero-content">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="about-hero-title">Rólunk</h1>
            </div>
        </div>
    </div>
</div>

<!-- Content -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Szekció 1 -->
            <div class="about-block">
                <div class="calc-info-banner mb-4">
                    <h2 class="calc-info-title">Miért készítettük a jogsikalkulator.hu oldalt?</h2>
                </div>
                <p>A Szakoktatók Országos Érdekképviseleti Egyesületének (SZAKOE) célja, hogy hozzájáruljon a hazai járművezető-képzés színvonalának emeléséhez, ezért feladatunknak tekintjük a leendő tanulók minél pontosabb tájékoztatását is.</p>
                <p>Munkánkkal kapcsolatban többször felmerült az igény egy olyan fórumra, ahol lehetőség van megismerni a jogosítványszerzéshez kapcsolódó tudnivalókat, hiszen a képzés, a vizsgák, az egyéb követelmények (orvosi alkalmasság, elsősegély vizsga) és nem utolsó sorban a költségek számos előfeltétel és körülmény függvényében alakulnak.</p>
                <p>Pártatlan, non-profit alapon működő oldalunkkal abban próbálunk Neked segítséget nyújtani, hogy jobban eligazodj ebben az első látásra bonyolultnak tűnő világban, megalapozott döntéssel válassz autósiskolát és ne csak jogosítványt szerezz, hanem biztos vezetői tudást is!</p>
            </div>

            <!-- Szekció 2 -->
            <div class="about-block">
                <div class="calc-info-banner mb-4" style="background: url('/public/assets/depositphotos_275759776_xl.jpg') center 50%/cover">
                    <h2 class="calc-info-title">Miben segít neked a jogsikalkulator.hu?</h2>
                </div>
                <p>Az autósiskola kiválasztása nem egyszerű feladat, hiszen nagy döntésről van szó, amit ráadásul a legtöbb ember csak egyszer tesz meg életében. Komoly pénzösszeg kiadásáról határozol, de ennél is fontosabb az, hogy a képzésen milyen elméleti és gyakorlati tudást kapsz ahhoz, hogy a jogosítványod megszerzését követően valóban biztonságosan tudj vezetni.</p>
                <p>Honlapunkon megmutatjuk Neked, hogy mit érdemes megnézni a képzés elkezdését megelőzően, hogyan tudsz pontosabb képet kapni az iskola szolgáltatásairól és árairól, és hogy milyen teljesítménymutatókkal rendelkezik egy-egy iskola.</p>
                <p class="fw-bolder">Jogsikalkulátorunk kitöltése során meg kell adnod, milyen képzésre jelentkezel és hogy van-e már jogosítványod. Ezt követően az általad választott autósiskola aktuális áraira (elmélet, gyakorlat, adminisztrációs díjak) vagyis néhány számra van csak szükséged. Ezeket az iskola honlapjáról vagy a tőlük kapott ajánlat alapján tudod megadni. Ezek alapján kalkulátorunk megmutatja, hogyan alakul majd várhatóan a teljes költség a képzés végére. Ezen kívül hasznos tippeket kaphatsz az oktatás egyes fázisainak menetéről, sőt, még a leggyakoribb tanulócsábítási trükköket is bemutatjuk.</p>
                <p class="fw-bolder">Ha pedig több iskola közül szeretnél választani, az autósiskolák összehasonlítását is elvégezheted, majd mindezeket az információkat elmentheted magadnak.</p>
            </div>

            <!-- Lapozó navigáció -->
            <?php if (!empty($navigation)): ?>
            <nav class="about-page-nav">
                <div class="about-page-nav-prev">
                    <?php if (!empty($navigation['previous']['url'])): ?>
                    <a href="<?= htmlspecialchars($navigation['previous']['url']) ?>" class="about-nav-btn about-nav-btn--prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                        </svg>
                        <span><?= htmlspecialchars($navigation['previous']['name']) ?></span>
                    </a>
                    <?php endif; ?>
                </div>
                <div class="about-page-nav-next">
                    <?php if (!empty($navigation['next']['url'])): ?>
                    <a href="<?= htmlspecialchars($navigation['next']['url']) ?>" class="about-nav-btn about-nav-btn--next">
                        <span><?= htmlspecialchars($navigation['next']['name']) ?></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                </div>
            </nav>
            <?php endif; ?>

        </div>
    </div>
</div>
