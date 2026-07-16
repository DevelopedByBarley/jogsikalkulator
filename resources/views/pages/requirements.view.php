<!-- Page header -->
<div class="about-hero">
    <div class="about-hero-overlay"></div>
    <div class="container about-hero-content">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="about-hero-title">Alapkövetelmények</h1>
            </div>
        </div>
    </div>
</div>

<!-- Content -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Kötelező iskolai végzettség -->
            <div class="about-block">
                <div class="calc-info-banner mb-4" style="background: url('/public/assets/depositphotos_551388246_xl.jpg') center 75%/cover;">
                    <h2 class="calc-info-title">Kötelező iskolai végzettség</h2>
                </div>
                <p>Az „AM" kategória (segédmotoros kerékpár) kivételével előírás, hogy legalább alapfokú iskolai végzettséggel kell rendelkezned, amit a legújabb előírások szerint az első (általában elméleti) vizsgádon kell a megfelelő (általános iskolai vagy magasabb szintű) bizonyítvánnyal igazolnod.</p>
            </div>

            <!-- Életkor -->
            <div class="about-block">
                <div class="calc-info-banner mb-4">
                    <h2 class="calc-info-title">Életkor</h2>
                </div>
                <p>Az egyes jogosítványkategóriák megszerzésének eltérő életkori feltételei vannak.</p>
                <p>B kategóriás jogosítvány megszerzésébe (beiratkozás az elméleti tanfolyamra) csak akkor vághatsz bele, ha már betöltötted a 16 és fél éves életkort. Elméleti vizsgát legkorábban 16 év 9 hónapos korban tehetsz, forgalmi vizsgát pedig csak a 17. születésnapodat követően.</p>
                <p>Viszonylag bonyolult rendszere van a motoros (A1, A2, A) jogosítványok megszerzésének. Az A1 és A2 kategóriákat fiatalabb korban meg lehet szerezni, mint a korlátozás nélküli A kategóriát. Ezek azonban teljesítményben és lökettérfogatban meghatározott korlátozást jelentenek a vezethető motorkerékpárok tekintetében.</p>
                <p>Ha valaki fokozatosan „araszol" felfelé a motoros kategóriákban, akkor annak hatása lehet a jogosítvány megszerzésének időtartamára és költségére is (pl. egyes esetekben mentesülhetsz az elméleti tanfolyam és vizsga alól, illetve csökkenhetnek a kötelező vezetési óraszámaid is). Ezeket a hatásokat mind igyekeztünk figyelembe venni a jogsikalkulátor működésében.</p>
            </div>

            <!-- Egészségügyi alkalmasság -->
            <div class="about-block">
                <div class="calc-info-banner mb-4" style="background: url('/public/assets/depositphotos_324649242_xl.jpg') center 40% /cover;">
                    <h2 class="calc-info-title">Egészségügyi alkalmasság</h2>
                </div>
                <p>Az AM kategória kivételével a vezetői engedély megszerzésének feltétele az egészségügyi alkalmasság igazolása is. Az A1, A2, A és B kategóriás jogosítványokhoz úgynevezett 1. alkalmassági csoport szerinti igazolást kell beszerezned a házi- vagy üzemorvostól. Ezt legkésőbb az elméleti vizsgára történő jelentkezésedig kell megszerezned.</p>
                <p>Ha már van érvényes jogosítványod és a megszerezni kívánt új kategória egészségügyi alkalmassági követelménye nem magasabb a korábbiaknál, akkor arra is van lehetőséged, hogy – sikeres vizsgáidat követően – a meglévő érvényességi időre, újabb orvosi vizsgálat nélkül állítsák ki majd a részedre az új kategória vezetésére is jogosító vezetői engedélyt.</p>
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
