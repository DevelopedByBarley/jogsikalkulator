<?php require base_path('resources/views/components/hero.view.php'); ?>
<?php require base_path('resources/views/components/calculator-nav.view.php'); ?>


<form id="category-form">

    <?php require component('calculator/categories'); ?>

    <?php require component('calculator/medical'); ?>

    <?php require component('calculator/education'); ?>

    <?php require component('calculator/practical'); ?>

    <?php require component('calculator/first-aid'); ?>

    <?php require component('calculator/other'); ?>
</form>

<?php require component('calculator/result'); ?>

<?php require component('calculator/compare-banner'); ?>

<!-- Fixált összesítés gomb -->
<button type="button" class="btn btn-dark shadow-lg" data-bs-toggle="modal" data-bs-target="#calculationModal"
    style="position: fixed; bottom: 2rem; right: 2rem; z-index: 1040; border-radius: 50px; padding: 0.75rem 1.5rem; font-weight: 600;">
    &#9776; Összesítés
</button>

<!-- Kalkuláció mentése modal -->
<div class="modal fade" id="saveCalculationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold">Kalkuláció mentése</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-secondary small mb-3">Add meg e-mail címed és elküldjük a kalkuláció linkjét, ahol a jövőben elérheted.</p>
                <div class="mb-3">
                    <label for="save-calc-email" class="form-label fw-semibold">E-mail:</label>
                    <input type="email" class="form-control" id="save-calc-email">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="save-calc-gdpr">
                    <label class="form-check-label small" for="save-calc-gdpr">
                        Az <a href="#" class="text-success fw-semibold">adatkezelési nyilatkozatot</a> elfogadom!
                    </label>
                </div>
                <div class="border rounded p-3 d-flex align-items-center gap-3" style="background:#f9f9f9; width: fit-content;">
                    <input type="checkbox" id="save-calc-recaptcha" class="form-check-input" style="width:1.5rem; height:1.5rem;">
                    <span class="small">Nem vagyok robot</span>
                    <div class="ms-3 text-center" style="font-size:0.6rem; color:#888; line-height:1.2;">
                        <div style="font-size:1.5rem;">&#9851;</div>
                        reCAPTCHA
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">BEZÁR</button>
                <button type="button" class="btn btn-primary">MENTÉS</button>
            </div>
        </div>
    </div>
</div>

<!-- Kalkuláció összesítő modal -->
<div class="modal fade" id="calculationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white border-0 py-3" style="background: linear-gradient(135deg, #0f172a, #1e3a5f);">
                <h5 class="modal-title fw-bold">Kalkuláció összesítő</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" id="modal-result-body"></div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Banner badge szinkronizálás a nav compare-count-tal
        var navBadge = document.getElementById('compare-count');
        var bannerBadge = document.getElementById('compare-banner-count');
        if (navBadge && bannerBadge) {
            bannerBadge.textContent = navBadge.textContent;
            new MutationObserver(function() {
                bannerBadge.textContent = navBadge.textContent;
            }).observe(navBadge, { childList: true, characterData: true, subtree: true });
        }

        // Sticky top dinamikus beállítása
        var navbar = document.getElementById('mainNavbar');
        var calcNav = document.getElementById('calculator-nav');
        if (navbar && calcNav) {
            var offset = navbar.offsetHeight + calcNav.offsetHeight + 16;
            document.querySelectorAll('.calc-sticky').forEach(function(el) {
                el.style.top = offset + 'px';
            });
        }
    });

    document.getElementById('calculationModal').addEventListener('show.bs.modal', function() {
        var src = document.getElementById('result-card-body');
        var dst = document.getElementById('modal-result-body');
        if (src && dst) dst.innerHTML = src.innerHTML;
    });
</script>

<script>
    (function() {
        var syncing = false;

        function initSliderSync() {
            var basicSlider = document.getElementById('practical_basic_price_slider');
            var extraSlider = document.getElementById('practical_extra_price_slider');
            var syncCheckbox = document.getElementById('sync-extra-to-basic');
            if (!basicSlider || !extraSlider || !syncCheckbox) return;
            basicSlider.addEventListener('input', function() {
                if (syncCheckbox.checked && !syncing) {
                    syncing = true;
                    extraSlider.value = this.value;
                    extraSlider.dispatchEvent(new Event('input'));
                    syncing = false;
                }
            });
            extraSlider.addEventListener('input', function() {
                if (syncCheckbox.checked && !syncing) {
                    syncing = true;
                    basicSlider.value = this.value;
                    basicSlider.dispatchEvent(new Event('input'));
                    syncing = false;
                }
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSliderSync);
        } else {
            initSliderSync();
        }
    })();
</script>