<?php require base_path('resources/views/components/hero.view.php'); ?>
<?php require base_path('resources/views/components/calculator-nav.view.php'); ?>


<form id="category-form">

    <!-- ── KATEGÓRIÁK ── -->
    <section id="kategoria" class="calc-section py-5">
        <div class="container">
            <div class="row g-5 align-items-start">

                <div class="col-lg-5 calc-sticky">
                    

                    <div class="cat-card">
                        <div class="cat-header">Kategóriák</div>
                        <div class="p-4">

                            <p class="cat-question">Milyen kategóriás jogosítványt szeretnél?</p>
                            <div class="vehicle-grid mb-4">
                                <input type="radio" class="btn-check" name="category" id="cat-am" value="AM">
                                <label class="vehicle-label" for="cat-am">
                                    <svg width="38" height="28" viewBox="0 0 64 40" fill="white"><ellipse cx="12" cy="34" rx="8" ry="6"/><ellipse cx="52" cy="34" rx="8" ry="6"/><path d="M20,34 Q20,20 30,18 L42,16 L54,20 L54,34"/><path d="M28,18 L28,10 Q34,8 38,12 L40,16"/><rect x="24" y="6" width="12" height="6" rx="2"/></svg>
                                    AM
                                </label>
                                <input type="radio" class="btn-check" name="category" id="cat-a1" value="A1">
                                <label class="vehicle-label" for="cat-a1">
                                    <svg width="40" height="28" viewBox="0 0 68 42" fill="white"><ellipse cx="12" cy="35" rx="8" ry="6"/><ellipse cx="56" cy="35" rx="8" ry="6"/><path d="M20,35 L20,22 Q22,14 32,12 L44,12 L56,16 L56,35"/><path d="M32,12 L32,4 L40,4 L42,12"/><path d="M22,20 L44,18"/></svg>
                                    A1
                                </label>
                                <input type="radio" class="btn-check" name="category" id="cat-a2" value="A2">
                                <label class="vehicle-label" for="cat-a2">
                                    <svg width="42" height="28" viewBox="0 0 70 42" fill="white"><ellipse cx="12" cy="35" rx="8" ry="6"/><ellipse cx="58" cy="35" rx="8" ry="6"/><path d="M20,35 L20,20 Q24,10 36,10 L48,10 L58,16 L58,35"/><path d="M34,10 L34,2 L44,2 L46,10"/><path d="M20,22 L46,20"/><path d="M24,14 Q30,8 40,8"/></svg>
                                    A2
                                </label>
                                <input type="radio" class="btn-check" name="category" id="cat-a" value="A">
                                <label class="vehicle-label" for="cat-a">
                                    <svg width="44" height="28" viewBox="0 0 72 42" fill="white"><ellipse cx="12" cy="35" rx="8" ry="6"/><ellipse cx="60" cy="35" rx="8" ry="6"/><path d="M20,35 L18,24 Q20,12 34,10 L50,10 L60,18 L60,35"/><path d="M32,10 L30,2 L46,2 L48,10"/><path d="M18,26 L50,22"/><path d="M22,16 Q32,6 48,8"/></svg>
                                    A
                                </label>
                                <input type="radio" class="btn-check" name="category" id="cat-b" value="B" checked>
                                <label class="vehicle-label" for="cat-b">
                                    <svg width="48" height="28" viewBox="0 0 76 44" fill="white"><ellipse cx="16" cy="36" rx="8" ry="6"/><ellipse cx="60" cy="36" rx="8" ry="6"/><path d="M8,36 L8,26 L14,14 L28,8 L50,8 L64,16 L68,26 L68,36"/><path d="M14,14 L28,10 L50,10 L62,18"/><rect x="16" y="12" width="16" height="10" rx="1"/><rect x="36" y="12" width="18" height="10" rx="1"/></svg>
                                    B
                                </label>
                            </div>

                            <p class="cat-question">Van érvényes jogosítványod?<br>Ha van, milyen kategóriából?</p>
                            <div class="vehicle-grid mb-3">
                                <input type="radio" class="btn-check" name="prev_category" id="prev-am" value="AM">
                                <label class="vehicle-label" for="prev-am">
                                    <svg width="38" height="28" viewBox="0 0 64 40" fill="white"><ellipse cx="12" cy="34" rx="8" ry="6"/><ellipse cx="52" cy="34" rx="8" ry="6"/><path d="M20,34 Q20,20 30,18 L42,16 L54,20 L54,34"/><path d="M28,18 L28,10 Q34,8 38,12 L40,16"/><rect x="24" y="6" width="12" height="6" rx="2"/></svg>
                                    AM
                                </label>
                                <input type="radio" class="btn-check" name="prev_category" id="prev-a1" value="A1">
                                <label class="vehicle-label" for="prev-a1">
                                    <svg width="40" height="28" viewBox="0 0 68 42" fill="white"><ellipse cx="12" cy="35" rx="8" ry="6"/><ellipse cx="56" cy="35" rx="8" ry="6"/><path d="M20,35 L20,22 Q22,14 32,12 L44,12 L56,16 L56,35"/><path d="M32,12 L32,4 L40,4 L42,12"/><path d="M22,20 L44,18"/></svg>
                                    A1
                                </label>
                                <input type="radio" class="btn-check" name="prev_category" id="prev-a2" value="A2">
                                <label class="vehicle-label" for="prev-a2">
                                    <svg width="42" height="28" viewBox="0 0 70 42" fill="white"><ellipse cx="12" cy="35" rx="8" ry="6"/><ellipse cx="58" cy="35" rx="8" ry="6"/><path d="M20,35 L20,20 Q24,10 36,10 L48,10 L58,16 L58,35"/><path d="M34,10 L34,2 L44,2 L46,10"/><path d="M20,22 L46,20"/></svg>
                                    A2
                                </label>
                                <input type="radio" class="btn-check" name="prev_category" id="prev-a" value="A">
                                <label class="vehicle-label" for="prev-a">
                                    <svg width="44" height="28" viewBox="0 0 72 42" fill="white"><ellipse cx="12" cy="35" rx="8" ry="6"/><ellipse cx="60" cy="35" rx="8" ry="6"/><path d="M20,35 L18,24 Q20,12 34,10 L50,10 L60,18 L60,35"/><path d="M32,10 L30,2 L46,2 L48,10"/><path d="M18,26 L50,22"/></svg>
                                    A
                                </label>
                                <input type="radio" class="btn-check" name="prev_category" id="prev-b" value="B">
                                <label class="vehicle-label" for="prev-b">
                                    <svg width="48" height="28" viewBox="0 0 76 44" fill="white"><ellipse cx="16" cy="36" rx="8" ry="6"/><ellipse cx="60" cy="36" rx="8" ry="6"/><path d="M8,36 L8,26 L14,14 L28,8 L50,8 L64,16 L68,26 L68,36"/><rect x="16" y="12" width="16" height="10" rx="1"/><rect x="36" y="12" width="18" height="10" rx="1"/></svg>
                                    B
                                </label>
                                <input type="radio" class="btn-check" name="prev_category" id="prev-none" value="none" checked>
                                <label class="vehicle-label" for="prev-none">
                                    <svg width="32" height="32" viewBox="0 0 40 40" fill="none" stroke="white" stroke-width="3"><circle cx="20" cy="20" r="16"/><line x1="8" y1="8" x2="32" y2="32"/></svg>
                                    NINCS
                                </label>
                            </div>

                            <div class="card border-0 bg-white bg-opacity-50 d-none" id="prev-category-from">
                                <div class="card-body">
                                    <p class="cat-question mb-2" style="font-size:1rem;">Hány éve van meg a jogosítványod?</p>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <input type="radio" class="btn-check" name="prev_category_from_more_than_2_years" id="year-less-2" value="less_2">
                                        <label class="btn btn-outline-secondary" for="year-less-2">Kevesebb mint 2 éve</label>
                                        <input type="radio" class="btn-check" name="prev_category_from_more_than_2_years" id="year-more-2" value="more_2">
                                        <label class="btn btn-outline-secondary" for="year-more-2">Több mint 2 éve</label>
                                    </div>
                                    <div id="years-warning" class="alert alert-warning mt-3 d-none">
                                        Kérjük, jelöld ki, hogy hány éve van meg a jogosítványod.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quos harum id adipisci. Et, nobis. Doloribus blanditiis repellat corrupti perferendis velit quod aliquam optio repudiandae commodi pariatur, possimus fuga sapiente maiores.

                </div>
            </div>
        </div>
    </section>

    <!-- ── ORVOSI ── -->
    <section id="orvosi" class="calc-section py-5 d-none" id="orvosi-section">
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-5 calc-sticky">
                    <div class="card border-0 shadow-sm" id="medical-row">
                        <div class="card-header fw-bold bg-white border-bottom">Orvosi alkalmassági vizsgálat</div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <span class="text-secondary">Ár (fix)</span>
                                <span class="fw-bold" id="medical_price_display">7 500 Ft</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <!-- TARTALOM HELYE -->
                </div>
            </div>
        </div>
    </section>

    <!-- ── ELMÉLET ── -->
    <section id="elmelet" class="calc-section py-5">
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-5 calc-sticky">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header fw-bold bg-white border-bottom">Elméleti képzés</div>
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <label class="form-label mb-0">Elméleti képzés díja</label>
                                    <span class="fw-bold text-primary" id="theoretical_training_price_display">20 000 Ft</span>
                                </div>
                                <input type="range" class="form-range" id="theoretical_training_price_slider" min="0" max="90000" step="500" value="20000">
                                <div class="d-flex justify-content-between">
                                    <small class="text-secondary">0 Ft</small>
                                    <small class="text-secondary">90 000 Ft</small>
                                </div>
                                <div class="d-flex justify-content-between pt-2 border-top">
                                    <span class="text-secondary">Közlekedési alapismeretek vizsgadíj (fix)</span>
                                    <span class="fw-bold" id="theoretical_exam_fee_display">4 600 Ft</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <!-- TARTALOM HELYE -->
                </div>
            </div>
        </div>
    </section>

    <!-- ── GYAKORLAT ── -->
    <section id="gyakorlat" class="calc-section py-5">
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-5 calc-sticky">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header fw-bold bg-white border-bottom">Gyakorlati képzés</div>
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <label class="form-label mb-0">Gyakorlati óradíj (alapóra)</label>
                                    <span class="fw-bold text-primary" id="practical_basic_price_display">5 000 Ft</span>
                                </div>
                                <input type="range" class="form-range" id="practical_basic_price_slider" min="5000" max="15000" step="100" value="5000">
                                <div class="d-flex justify-content-between">
                                    <small class="text-secondary">5 000 Ft</small>
                                    <small class="text-secondary" id="practical_basic_price_max_label">15 000 Ft</small>
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
                                    <input type="range" class="form-range" id="practical_extra_price_slider" min="5000" max="15000" step="100" value="5000">
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
                                    <input type="range" class="form-range" id="practical_extra_hours_slider" min="0" max="50" step="1" value="5">
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
                    </div>
                </div>
                <div class="col-lg-7">
                    <!-- TARTALOM HELYE -->
                </div>
            </div>
        </div>
    </section>

    <!-- ── ELSŐSEGÉLY ── -->
    <section id="elsosegely" class="calc-section py-5">
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-5 calc-sticky">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header fw-bold bg-white border-bottom">Elsősegély</div>
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <label class="form-label mb-0">Elsősegély-tanfolyam díja</label>
                                    <span class="fw-bold text-primary" id="first_aid_training_display">0 Ft</span>
                                </div>
                                <input type="range" class="form-range" id="first_aid_training_slider" min="0" max="30000" step="100" value="0">
                                <div class="d-flex justify-content-between">
                                    <small class="text-secondary">0 Ft</small>
                                    <small class="text-secondary">30 000 Ft</small>
                                </div>
                                <div class="d-flex justify-content-between pt-2 border-top">
                                    <span class="text-secondary">Elsősegély vizsga díja (fix)</span>
                                    <span class="fw-bold" id="first_aid_exam_fee_display">20 900 Ft</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <!-- TARTALOM HELYE -->
                </div>
            </div>
        </div>
    </section>

    <!-- ── EGYÉB ── -->
    <section id="egyeb" class="calc-section py-5">
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-5 calc-sticky">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header fw-bold bg-white border-bottom">Egyéb költségek</div>
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <label class="form-label mb-0">Autósiskolai adminisztrációs költség</label>
                                    <span class="fw-bold text-primary" id="admin_fee_display">0 Ft</span>
                                </div>
                                <input type="range" class="form-range" id="admin_fee_slider" min="0" max="60000" step="500" value="0">
                                <div class="d-flex justify-content-between">
                                    <small class="text-secondary">0 Ft</small>
                                    <small class="text-secondary">60 000 Ft</small>
                                </div>
                                <div class="d-flex justify-content-between pt-2 border-top">
                                    <span class="text-secondary">Okmány elkészítés díja (fix)</span>
                                    <span class="fw-bold" id="document_fee_display">0 Ft</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <!-- TARTALOM HELYE -->
                </div>
            </div>
        </div>
    </section>

</form>

<!-- ── EREDMÉNY ── -->
<section id="eredmeny" class="py-5" style="background: #f1f5f9;">
    <div class="container">
        <div class="row justify-content-start">
            <div class="col-lg-5 calc-sticky">
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

                <div class="d-flex gap-3 mt-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#saveCalculationModal">
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