    <!-- ── GYAKORLAT ── -->
    <section id="gyakorlat" class="calc-section py-5">
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-5 calc-sticky">
                    <div class="cat-card--blue">
                        <div class="cat-header--blue">Gyakorlati képzés</div>
                        <div class="p-4">
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
                                <div class="form-check mb-4 px-3 py-2 rounded" style="background:#e8f4ff; border: 1px solid #b6d4fe;">
                                    <input class="form-check-input" type="checkbox" id="sync-extra-to-basic" checked>
                                    <label class="form-check-label small fw-semibold" for="sync-extra-to-basic" style="color:#1e3a5f;">
                                        gyakorlati pótóra díja megegyezik az alapóra díjával
                                    </label>
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
                <div class="col-lg-7 calc-content">

                    <div class="calc-info-block">
                        <div class="calc-info-banner" style="background-image: url('/public/assets/depositphotos_310926564_xl.jpg')">
                            <h3 class="calc-info-title">Vezetési karton</h3>
                        </div>
                        <p>A gyakorlati oktatás legfontosabb dokumentuma a vezetési karton, melyen neked, mint tanulónak a gyakorlati vezetési óra elején és végén is aláírásoddal kell igazolni az oktatás tényét. Ez azért is fontos, mert a jogszabályok szerint ez alatt az idő alatt a szakoktatód az oktató jármű felelős vezetője.</p>
                        <p>A megfelelően kitöltött vezetési karton hiányában mindketten szabálysértést követtek el: Te jogosulatlanul vezetsz, szakoktatód pedig jogosulatlanul átengedte neked a jármű vezetését, és baleset esetén a jármű biztosítása sem nyújt fedezetet az esetlegesen okozott károkra.</p>
                    </div>

                    <div class="calc-info-block">
                        <div class="calc-info-banner" style="background-image: url('/public/assets/depositphotos_278094076_xl.jpg')">
                            <h3 class="calc-info-title">Kedvezményes gyakorlati óradíj vagy mégsem?</h3>
                        </div>
                        <p>Sok autósiskola szereti felkelteni a tanulók érdeklődését kedvezményes gyakorlati óradíjakkal.</p>
                        <p class="mb-1"><strong>Mire figyelj:</strong></p>
                        <ul>
                            <li>Ha az ár olyan alacsony, hogy megkérdőjelezhető az oktatási óra önköltségének fedezése is, akkor jobb, ha számítasz rá, keveset fog járni a motor. Ennek pedig egyenes következménye lehet a pótórák vétele, nagy valószínűséggel már nem a kedvezményes árszinten.</li>
                            <li>A másik meglepetést az okozhatja, ha a kedvezményes díjak csak adott napszakokban érvényesek, amikor Te éppen nem érsz rá.</li>
                            <li>Előfordulhat, hogy a kedvezményes óradíj csak ritka (pl. heti egy) vezetési alkalmakkal, esetleg hosszú kocsira jutási idővel kombinálva érvényes.</li>
                        </ul>
                        <p><strong>Mindig pontosan tájékozódj, hogy milyen feltételhez kötik a kedvezményes díj érvényesítését, és mennyi lesz ehhez képest a valós óradíj!</strong></p>
                    </div>

                    <div class="calc-info-block">
                        <div class="calc-info-banner" style="background: url('/public/assets/depositphotos_393408270_xl.jpg') center 30% / cover">
                            <h3 class="calc-info-title">Mennyit fogsz vezetni?</h3>
                        </div>
                        <p>A gyakorlati képzés minimális óraszáma hatóságilag megállapított, és a megszerezni kívánt jogosítvány kategóriája szerint változik. A gyakorlati vezetési órák előírt időtartama 50 perc. Mindig ragaszkodj tehát a vezetési karton és az 50 perc kitöltéséhez is!</p>
                        <p>Képességtől és rutintól függetlenül a kötelező óraszámot mindenkinek le kell vezetnie, a tapasztalatok viszont azt mutatják, különösen a legelső jogosítvány kategória megszerzésénél, hogy a legtöbb tanulónak általában több időre van szüksége ahhoz, hogy elsajátítsa a közösségre és saját magára nézve is biztonságos közlekedés alapjait.</p>
                        <p>Nemcsak a gyakorlati vezetési órák számának, de a levezetett kilométereknek is nagy jelentősége van. A vizsgára bocsátáshoz ugyanis „B" kategória esetén a kötelező minimum 29 óra gyakorlás mellett még egy feltételnek teljesülnie kell: legalább 580 km-t le kell vezetned, egyebek mellett országúton és éjszaka (sötétedés után) is.</p>
                    </div>

                    <div class="calc-info-block">
                        <div class="calc-info-banner" style="background-image: url('/public/assets/depositphotos_396424460_xl.jpg')">
                            <h3 class="calc-info-title">Hol fogsz vezetni?</h3>
                        </div>
                        <p>A gyakorlati oktatás – és főleg a vizsgáztatás – helyszíne nem tetszőleges: a szükséges forgalmi infrastruktúra, forgalomsűrűség és forgalmi helyzetek miatt a nagyobb városokra koncentrálódik. A B kategóriás képzés egy részében az oktatód gyakorolhat veled rutinpályán is, de ez nem kötelező. A motoros kategóriáknál viszont – a járműkezelési vizsga és az arra történő felkészülés érdekében – mindenképpen megfordulsz majd rajta.</p>
                    </div>

                    <div class="calc-info-block">
                        <div class="calc-info-banner" style="background: url('/public/assets/depositphotos_89998860_xl.jpg') center 60% / cover">
                            <h3 class="calc-info-title">Óradíj</h3>
                        </div>
                        <p>A gyakorlati óradíjnak nincs hatóságilag megállapított egységes ára, sőt, egy iskolán belül is alkalmazhatnak különböző óradíjakat az oktató személyétől, az oktatójármű fajtájától (pl. kézi váltós vagy automata), típusától vagy az oktatás időpontjától (pl. hétköznap vagy hétvége) függően. Ez tehát az autósiskola döntése. Fontos viszont az átláthatóság, vagyis hogy pontosan tudd – mégpedig előre – hogy milyen szolgáltatást kapsz és annak mi az ára.</p>
                    </div>

                </div>
            </div>
        </div>
    </section>