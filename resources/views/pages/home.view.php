

<?php require base_path('resources/views/components/hero.view.php'); ?>

<section class="py-5" style="background: #f1f5f9;">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #0f172a;">Jogosítvány költségkalkulátor</h2>
            <p class="text-secondary">Állítsd be a csúszkákat és azonnal látod a várható költségeket</p>
        </div>

        <form id="category-form">
            <div class="row g-4">

                <!-- Bal oldal: beállítások -->
                <div class="col-lg-7">

                    <!-- Kategória -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header fw-bold bg-white border-bottom">Melyik kategóriát szeretnéd megszerezni?</div>
                        <div class="card-body">
                            <div class="btn-group flex-wrap" role="group">
                                <input type="radio" class="btn-check" name="category" id="cat-am" value="AM">
                                <label class="btn btn-outline-dark" for="cat-am">AM</label>

                                <input type="radio" class="btn-check" name="category" id="cat-a1" value="A1">
                                <label class="btn btn-outline-dark" for="cat-a1">A1</label>

                                <input type="radio" class="btn-check" name="category" id="cat-a2" value="A2">
                                <label class="btn btn-outline-dark" for="cat-a2">A2</label>

                                <input type="radio" class="btn-check" name="category" id="cat-a" value="A">
                                <label class="btn btn-outline-dark" for="cat-a">A</label>

                                <input type="radio" class="btn-check" name="category" id="cat-b" value="B" checked>
                                <label class="btn btn-outline-dark" for="cat-b">B</label>
                            </div>
                        </div>
                    </div>

                    <!-- Előző kategória -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header fw-bold bg-white border-bottom">Van már meglévő jogosítványod?</div>
                        <div class="card-body">
                            <div class="btn-group flex-wrap" role="group">
                                <input type="radio" class="btn-check" name="prev_category" id="prev-none" value="none" checked>
                                <label class="btn btn-outline-dark" for="prev-none">Nincs</label>

                                <input type="radio" class="btn-check" name="prev_category" id="prev-am" value="AM">
                                <label class="btn btn-outline-dark" for="prev-am">AM</label>

                                <input type="radio" class="btn-check" name="prev_category" id="prev-a1" value="A1">
                                <label class="btn btn-outline-dark" for="prev-a1">A1</label>

                                <input type="radio" class="btn-check" name="prev_category" id="prev-a2" value="A2">
                                <label class="btn btn-outline-dark" for="prev-a2">A2</label>

                                <input type="radio" class="btn-check" name="prev_category" id="prev-a" value="A">
                                <label class="btn btn-outline-dark" for="prev-a">A</label>

                                <input type="radio" class="btn-check" name="prev_category" id="prev-b" value="B">
                                <label class="btn btn-outline-dark" for="prev-b">B</label>
                            </div>
                        </div>
                    </div>

                    <!-- Hány éve van jogsija (feltételes) -->
                    <div class="card border-0 shadow-sm mb-4 d-none" id="prev-category-from">
                        <div class="card-header fw-bold bg-white border-bottom">Hány éve van meg a jogosítványod?</div>
                        <div class="card-body">
                            <div class="btn-group flex-wrap" role="group">
                                <input type="radio" class="btn-check" name="prev_category_from_more_than_2_years" id="year-less-2" value="less_2">
                                <label class="btn btn-outline-dark" for="year-less-2">Kevesebb mint 2 éve</label>

                                <input type="radio" class="btn-check" name="prev_category_from_more_than_2_years" id="year-more-2" value="more_2">
                                <label class="btn btn-outline-dark" for="year-more-2">Több mint 2 éve</label>
                            </div>
                            <div id="years-warning" class="alert alert-warning mt-3 d-none" role="alert">
                                Kérjük, jelöld ki, hogy hány éve van meg a jogosítványod a kalkuláció elvégzéséhez.
                            </div>
                        </div>
                    </div>

                    <!-- Orvosi (feltételes, statikus) -->
                    <div class="card border-0 shadow-sm mb-4 d-none" id="medical-row">
                        <div class="card-header fw-bold bg-white border-bottom">Orvosi alkalmassági vizsgálat</div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <span class="text-secondary">Ár (fix)</span>
                                <span class="fw-bold" id="medical_price_display">7 500 Ft</span>
                            </div>
                        </div>
                    </div>

                    <!-- Elmélet -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header fw-bold bg-white border-bottom">Elméleti képzés</div>
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <label class="form-label mb-0">Elméleti képzés díja</label>
                                    <span class="fw-bold text-primary" id="theoretical_training_price_display">20 000 Ft</span>
                                </div>
                                <input type="range" class="form-range" id="theoretical_training_price_slider"
                                    min="0" max="90000" step="500" value="20000">
                                <div class="d-flex justify-content-between">
                                    <small class="text-secondary">0 Ft</small>
                                    <small class="text-secondary">90 000 Ft</small>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-2 border-top">
                                <span class="text-secondary">Közlekedési alapismeretek vizsgadíj (fix)</span>
                                <span class="fw-bold" id="theoretical_exam_fee_display">4 600 Ft</span>
                            </div>
                        </div>
                    </div>

                    <!-- Gyakorlat -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header fw-bold bg-white border-bottom">Gyakorlati képzés</div>
                        <div class="card-body">

                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <label class="form-label mb-0">Gyakorlati óradíj (alapóra)</label>
                                    <span class="fw-bold text-primary" id="practical_basic_price_display">5 000 Ft</span>
                                </div>
                                <input type="range" class="form-range" id="practical_basic_price_slider"
                                    min="5000" max="15000" step="100" value="5000">
                                <div class="d-flex justify-content-between">
                                    <small class="text-secondary">5 000 Ft</small>
                                    <small class="text-secondary" id="practical_basic_price_max_label">15 000 Ft</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-4 pt-2 border-top">
                                <span class="text-secondary">Kötelező óraszám (fix)</span>
                                <span class="fw-bold" id="practical_basic_hours_display">30 óra</span>
                            </div>

                            <div class="mb-2 pt-2 border-top">
                                <div class="d-flex justify-content-between mb-1">
                                    <label class="form-label mb-0">Gyakorlati óradíj (pótóra)</label>
                                    <span class="fw-bold text-primary" id="practical_extra_price_display">5 000 Ft</span>
                                </div>
                                <input type="range" class="form-range" id="practical_extra_price_slider"
                                    min="5000" max="15000" step="100" value="5000">
                                <div class="d-flex justify-content-between">
                                    <small class="text-secondary">5 000 Ft</small>
                                    <small class="text-secondary" id="practical_extra_price_max_label">15 000 Ft</small>
                                </div>
                            </div>
                            <div class="form-check mb-4 px-3 py-2 rounded" style="background:#e8f4ff; border: 1px solid #b6d4fe;">
                                <input class="form-check-input" type="checkbox" id="sync-extra-to-basic" checked>
                                <label class="form-check-label small fw-semibold" for="sync-extra-to-basic" style="color:#1e3a5f;">
                                    gyakorlati pótóra díja megegyezik az alapóra díjával
                                </label>
                            </div>

                            <div class="mb-4 pt-2 border-top">
                                <div class="d-flex justify-content-between mb-1">
                                    <label class="form-label mb-0">Kötelezőn felüli gyakorlati órák (pótórák)</label>
                                    <span class="fw-bold text-primary" id="practical_extra_hours_display">5 óra</span>
                                </div>
                                <input type="range" class="form-range" id="practical_extra_hours_slider"
                                    min="0" max="50" step="1" value="5">
                                <div class="d-flex justify-content-between">
                                    <small class="text-secondary">0 óra</small>
                                    <small class="text-secondary">50 óra</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between pt-2 border-top">
                                <span class="text-secondary">Forgalmi vizsgadíj (fix)</span>
                                <span class="fw-bold" id="practical_exam_fee_display">11 000 Ft</span>
                            </div>

                            <div class="d-flex justify-content-between pt-2 mt-2 border-top d-none" id="vehicle-handling-row">
                                <span class="text-secondary">Járműkezelés vizsgadíj (fix)</span>
                                <span class="fw-bold" id="vehicle_handling_display">0 Ft</span>
                            </div>
                        </div>
                    </div>

                    <!-- Elsősegély -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header fw-bold bg-white border-bottom">Elsősegély</div>
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <label class="form-label mb-0">Elsősegély-tanfolyam díja</label>
                                    <span class="fw-bold text-primary" id="first_aid_training_display">0 Ft</span>
                                </div>
                                <input type="range" class="form-range" id="first_aid_training_slider"
                                    min="0" max="30000" step="100" value="0">
                                <div class="d-flex justify-content-between">
                                    <small class="text-secondary">0 Ft</small>
                                    <small class="text-secondary">30 000 Ft</small>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-2 border-top">
                                <span class="text-secondary">Elsősegély vizsga díja (fix)</span>
                                <span class="fw-bold" id="first_aid_exam_fee_display">20 900 Ft</span>
                            </div>
                        </div>
                    </div>

                    <!-- Egyéb -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header fw-bold bg-white border-bottom">Egyéb költségek</div>
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <label class="form-label mb-0">Autósiskolai adminisztrációs költség</label>
                                    <span class="fw-bold text-primary" id="admin_fee_display">0 Ft</span>
                                </div>
                                <input type="range" class="form-range" id="admin_fee_slider"
                                    min="0" max="60000" step="500" value="0">
                                <div class="d-flex justify-content-between">
                                    <small class="text-secondary">0 Ft</small>
                                    <small class="text-secondary">60 000 Ft</small>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-2 border-top">
                                <span class="text-secondary">Okmány elkészítés díja (fix)</span>
                                <span class="fw-bold" id="document_fee_display">0 Ft</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Jobb oldal: jövőbeli tartalom helye -->
                <div class="col-lg-5">
                </div>

            </div>
        </form>

        <!-- Eredmény kártya alul -->
        <div class="row justify-content-start mt-4 mb-2">
            <div class="col-lg-7">
                <div class="card border-0 shadow" id="result-card">
                    <div class="card-header text-white fw-bold py-3" style="background: linear-gradient(135deg, #0f172a, #1e3a5f);">
                        <span id="result-title">A(z) "B" kategóriás jogosítvány várható költsége</span>
                    </div>
                    <div class="card-body p-0" id="result-card-body">
                        <div class="p-4 text-center border-bottom" style="background: #f8fafc;">
                            <div class="text-secondary small mb-1">Teljes becsült költség</div>
                            <div class="fw-bold" style="font-size: 2rem; color: #0f172a;" id="outcome-total">— Ft</div>
                        </div>
                        <div class="p-3">
                            <div class="d-flex justify-content-between py-2 border-bottom d-none" id="result-medical-row">
                                <span class="text-secondary">Orvosi alkalmassági</span>
                                <span class="fw-semibold" id="result-medical">–</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-secondary">Elmélet</span>
                                <span class="fw-semibold" id="result-theoretical">–</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-secondary">Gyakorlat</span>
                                <span class="fw-semibold" id="result-practical">–</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-secondary">Elsősegély</span>
                                <span class="fw-semibold" id="result-first-aid">–</span>
                            </div>
                            <div class="d-flex justify-content-between py-2">
                                <span class="text-secondary">Egyéb</span>
                                <span class="fw-semibold" id="result-others">–</span>
                            </div>
                        </div>
                    </div>
                    <!-- Korhatárok -->
                    <div class="card-footer bg-white border-top d-none" id="age-requirements-section">
                        <div class="small text-secondary mb-2 fw-semibold">Korhatárok</div>
                        <div class="d-flex justify-content-between small py-1">
                            <span class="text-secondary">Jelentkezés</span>
                            <span id="age-registration">–</span>
                        </div>
                        <div class="d-flex justify-content-between small py-1">
                            <span class="text-secondary">Elméleti vizsga</span>
                            <span id="age-theoretical">–</span>
                        </div>
                        <div class="d-flex justify-content-between small py-1 d-none" id="age-vehicle-handling-row">
                            <span class="text-secondary">Jármukezelés vizsga</span>
                            <span id="age-vehicle-handling">–</span>
                        </div>
                        <div class="d-flex justify-content-between small py-1">
                            <span class="text-secondary">Forgalmi vizsga</span>
                            <span id="age-practical">–</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Akció gombok -->
        <div class="row justify-content-start mt-3 mb-4">
            <div class="col-lg-7">
                <div class="d-flex gap-3">
                    <button type="button" class="btn btn-primary" id="btn-save-calculation"
                        data-bs-toggle="modal" data-bs-target="#saveCalculationModal">
                        Kalkuláció mentése
                    </button>
                    <button type="button" class="btn btn-success" id="btn-add-to-compare">
                        Kiválasztás összehasonlításra
                    </button>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Fixált összesítés gomb -->
<button type="button"
    class="btn btn-dark shadow-lg"
    data-bs-toggle="modal"
    data-bs-target="#calculationModal"
    style="position: fixed; bottom: 2rem; right: 2rem; z-index: 1040; border-radius: 50px; padding: 0.75rem 1.5rem; font-weight: 600;">
    &#9776; Összesítés
</button>

<!-- Kalkuláció mentése modal -->
<div class="modal fade" id="saveCalculationModal" tabindex="-1" aria-labelledby="saveCalculationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="saveCalculationModalLabel">Kalkuláció mentése</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bezárás"></button>
            </div>
            <div class="modal-body">
                <p class="text-secondary small mb-3">Add meg e-mail címed és elküldjük a kalkuláció linkjét, ahol a jövőben elérheted.</p>
                <div class="mb-3">
                    <label for="save-calc-email" class="form-label fw-semibold">E-mail:</label>
                    <input type="email" class="form-control" id="save-calc-email" placeholder="">
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
                <button type="button" class="btn btn-primary" id="btn-save-calc-submit">MENTÉS</button>
            </div>
        </div>
    </div>
</div>

<!-- Kalkuláció modal -->
<div class="modal fade" id="calculationModal" tabindex="-1" aria-labelledby="calculationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white border-0 py-3" style="background: linear-gradient(135deg, #0f172a, #1e3a5f);">
                <h5 class="modal-title fw-bold" id="calculationModalLabel">Kalkuláció összesítő</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Bezárás"></button>
            </div>
            <div class="modal-body p-0" id="modal-result-body">
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('calculationModal').addEventListener('show.bs.modal', function () {
        var src = document.getElementById('result-card-body');
        var dst = document.getElementById('modal-result-body');
        if (src && dst) {
            dst.innerHTML = src.innerHTML;
        }
    });
</script>

<script>
    (function () {
        var syncing = false;

        function initSliderSync() {
            var basicSlider = document.getElementById('practical_basic_price_slider');
            var extraSlider = document.getElementById('practical_extra_price_slider');
            var syncCheckbox = document.getElementById('sync-extra-to-basic');

            if (!basicSlider || !extraSlider || !syncCheckbox) return;

            basicSlider.addEventListener('input', function () {
                if (syncCheckbox.checked && !syncing) {
                    syncing = true;
                    extraSlider.value = this.value;
                    extraSlider.dispatchEvent(new Event('input'));
                    syncing = false;
                }
            });

            extraSlider.addEventListener('input', function () {
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
