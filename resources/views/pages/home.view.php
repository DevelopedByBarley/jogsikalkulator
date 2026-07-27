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
                <p class="text-secondary small mb-3">Add meg e-mail címed és elküldjük a kalkulációdat, hogy később is kéznél legyen.</p>
                <div class="mb-3">
                    <label for="save-calc-email" class="form-label fw-semibold">E-mail:</label>
                    <input type="email" class="form-control" id="save-calc-email" autocomplete="email">
                </div>
                <div class="mb-3 d-flex align-items-center gap-2">
                    <input type="checkbox" class="form-check-input mt-0 flex-shrink-0" id="save-calc-gdpr" style="margin-left:0;">
                    <label class="form-check-label small mb-0" for="save-calc-gdpr">
                        Az <a href="/public/basic/adatkezelesi_nyilatkozat.pdf" target="_blank" rel="noopener" class="text-success fw-semibold">adatkezelési nyilatkozatot</a> elfogadom!
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

                <p id="save-calc-status" class="small mt-3 mb-0 d-none" role="status" aria-live="polite"></p>
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">BEZÁR</button>
                <button type="button" class="btn btn-primary" id="save-calc-submit" disabled>MENTÉS</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var btn = document.querySelector('[data-bs-target="#calculationModal"]');
    if (btn) {
        btn.addEventListener('click', function () {
            var src = document.getElementById('result-card-body');
            var dst = document.getElementById('modal-result-body');
            if (src && dst) dst.innerHTML = src.innerHTML;
        });
    }
});
</script>

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

