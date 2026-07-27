<footer class="site-footer">

    <div class="container py-5">
        <div class="row g-5 align-items-start">

            <!-- Brand / Szervezet -->
            <div class="col-lg-5 col-md-6">
                <div class="footer-brand mb-3">
                    <span class="footer-brand-dot footer-brand-dot--blue"></span>
                    <span class="footer-brand-dot footer-brand-dot--green"></span>
                    <span class="footer-brand-name">jogsikalkulator.hu</span>
                </div>
                <p class="footer-org">Szakoktatók Országos Érdekképviseleti Egyesülete</p>
                <p class="footer-meta">Elnök: <strong>Baranyai Dávid</strong></p>
                <a href="mailto:info@jogsikalkulator.hu" class="footer-email">info@jogsikalkulator.hu</a>
            </div>

            <!-- Navigáció -->
            <div class="col-lg-3 col-md-6 col-6">
                <h6 class="footer-heading">Kalkulátor</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="#kategoria" class="footer-link">Kategóriák</a></li>
                    <li class="mb-2"><a href="#elmelet" class="footer-link">Elméleti képzés</a></li>
                    <li class="mb-2"><a href="#gyakorlat" class="footer-link">Gyakorlati képzés</a></li>
                    <li class="mb-2"><a href="#elsosegely" class="footer-link">Elsősegély</a></li>
                    <li class="mb-2"><a href="#eredmeny" class="footer-link">Eredmény</a></li>
                </ul>
            </div>

            <!-- Jogi -->
            <div class="col-lg-4 col-md-6 col-6">
                <h6 class="footer-heading">Információ</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="/public/basic/adatkezelesi_nyilatkozat.pdf" target="_blank" rel="noopener" class="footer-link">Adatvédelmi nyilatkozat</a></li>
                    <li class="mb-2"><a href="#" class="footer-link" data-bs-toggle="modal" data-bs-target="#impresszumModal">Impresszum</a></li>
                </ul>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <span class="footer-copy">&copy; 2018–<?= date('Y') ?> SZAKOE. Minden jog fenntartva.</span>
                <span class="footer-copy">Szakoktatók Országos Érdekképviseleti Egyesülete</span>
            </div>
        </div>
    </div>

    <!-- Impresszum modal -->
    <div class="modal fade" id="impresszumModal" tabindex="-1" aria-labelledby="impresszumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold" id="impresszumModalLabel">Impresszum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bezárás"></button>
                </div>
                <div class="modal-body">
                    <h6 class="fw-bold mb-2">A weboldal üzemeltetője</h6>
                    <p class="mb-1"><strong>Szervezet neve:</strong> Szakoktatók Országos Érdekképviseleti Egyesülete (SZAKOE)</p>
                    <p class="mb-1"><strong>Székhely:</strong> 1119 Budapest, Fejér Lipót utca 70.</p>
                    <p class="mb-1"><strong>Adószám:</strong> 18726352-1-43</p>
                    <p class="mb-1"><strong>Nyilvántartási szám:</strong> 13-02-0005648</p>
                    <p class="mb-1"><strong>E-mail:</strong> <a href="mailto:info@szakoe.hu">info@szakoe.hu</a></p>
                    <p class="mb-0"><strong>Weboldal:</strong> <a href="https://szakoe.hu" target="_blank" rel="noopener">szakoe.hu</a></p>

                    <hr class="my-3">

                    <h6 class="fw-bold mb-2">Tárhely szolgáltató</h6>
                    <p class="mb-1"><strong>Cégnév:</strong> Rufusz Computer Informatika Zrt.</p>
                    <p class="mb-1"><strong>Székhely:</strong> 1111 Budapest, Budafoki út. 59.</p>
                    <p class="mb-1"><strong>Telefon:</strong> <a href="tel:+3612094743">+36 1 209 4743</a></p>
                    <p class="mb-0"><strong>E-mail:</strong> <a href="mailto:info@rufusz.hu">info@rufusz.hu</a></p>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
                </div>
            </div>
        </div>
    </div>

</footer>
