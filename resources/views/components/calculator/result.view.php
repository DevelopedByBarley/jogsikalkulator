<!-- ── EREDMÉNY ── -->
<section id="eredmeny" class="py-5" style="background: #f1f5f9;">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-5 calc-sticky">
                <div class="cat-card" id="result-card">
                    <div class="cat-header">Eredmény</div>
                    <div id="result-card-body">
                        <div class="px-4 py-2 border-bottom" style="background: #edf7ed;">
                            <small class="text-secondary" id="result-title">A(z) "B" kategóriás jogosítvány várható költsége</small>
                        </div>
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
                    <div class="p-3 border-top d-none" id="age-requirements-section">
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

            <div class="col-lg-7 calc-content">

                <div class="calc-info-block">
                    <div class="calc-info-banner" style="background-image: url('/public/assets/depositphotos_203803070_xl.jpg')">
                        <h3 class="calc-info-title">A vizsgák és a jogosítvány</h3>
                    </div>
                    <p>Vizsgára jelentkezés: ezt általában az autósiskola, gyakorlati vizsga esetén esetleg maga az oktatód végzi. Ha úgy alakulna, hogy nem sikerül az elméleti vizsgád, akkor az elméleti pótvizsgá(k)ra önállóan is jelentkezhetsz, általában rögtön a vizsga helyszínén működő ügyfélszolgálaton.</p>
                    <p>A jogosítványod kiállítását bármely okmányirodában igényelheted, azt követően, hogy minden előírt vizsgádat sikeresen letetted. A közlekedési tárgyú vizsgáid eredményeiről az okmányirodában már tudni fognak, az elsősegélynyújtási vizsgáról kapott bizonyítványod viszont feltétlenül vidd magaddal. Az első jogosítványod kiállításáért még fizetned sem kell.</p>
                </div>

                <div class="calc-info-block">
                    <div class="calc-info-banner" style="background: url('/public/assets/depositphotos_21086287_xl.jpg') center 15%/cover">
                        <h3 class="calc-info-title">KK = Képzési Költség</h3>
                    </div>
                    <p>Azt mutatja meg Neked, hogy a képzés teljes időtartama alatt átlagosan összesen mennyit fizet egy tanuló. Fontos, hogy ebbe bizonyos költségeket nem számítanak bele (pl. az autósiskola által felszámított adminisztrációs vagy kezelési költséget, az esetleges pótvizsgák díját, az orvosi alkalmassági vizsgálat díját, az elsősegélynyújtási tanfolyam és vizsga díját, a vezetői engedély kiállításának esetleges díját). Ezt érdemes mind az autósiskolák összehasonlításánál, mind a jogosítványszerzés várható teljes költéségének meghatározásánál figyelembe venni.</p>
                    <p><strong>A várható teljes költség kiszámolásához és az iskolák összehasonlításához használd jogsikalkulátorunkat!</strong></p>
                </div>

                <div class="calc-info-block">
                    <div class="calc-info-banner" style="background: url('/public/assets/depositphotos_144796631_xl.jpg') center 100%/cover">
                        <h3 class="calc-info-title">VSM, ÁKÓ és KK – Sokatmondó mérőszámok</h3>
                    </div>
                    <p>A tanulók könnyebb tájékozódása érdekében a közlekedési hatóság 2014 óta kötelezi az autósiskolákat arra, hogy minden lezárt negyedév végén három fontos mérőszámot közzétegyenek. Ezeket az autósiskolák honlapján találod „képzési mutatók", „fogyasztóvédelmi mutatók" vagy „mérőszámok" címszó alatt.</p>
                    <p>A Vizsga Sikerességi Mutatót (VSM) és az Átlagos Képzési Óraszámot (ÁKÓ) a közlekedési hatóság hivatalosan is közzéteszi negyedévente. Az autósiskolának pedig mindhárom számot – tehát az általa kiszámított Képzési Költséget (KK) is – fel kell tüntetnie a honlapján, illetve reklámjaiban.</p>
                    <p>Ha az adott autósiskolánál a mutatószámok elavultak vagy meg sem találod azokat, esetleg az iskolának honlapja sincs, az már önmagában erős figyelmeztető jel.</p>
                    <p><a href="#" class="fw-semibold text-success">Autósiskolák hivatalos jegyzéke (ÁKÓ - VSM) &rsaquo;&rsaquo;</a></p>
                </div>

                <div class="calc-info-block">
                    <div class="calc-info-banner" style="background: url('/public/assets/depositphotos_13453254_xl.jpg') center 60%/cover">
                        <h3 class="calc-info-title">VSM = Vizsga Sikerességi Mutató</h3>
                    </div>
                    <p>Azt mutatja meg, hogy egy autósiskolánál a vizsgára jelentett tanulók hány százaléka tett sikeres vizsgát. Tehát az iskola tanulóinak átlagos vizsgasikerességét megmutatja. Százalékos mutató, külön számolják a fontosabb kategóriákra, azon belül az elméleti és gyakorlati vizsgákra, minden negyedévben. Értelemszerűen minél közelebb van az értéke a 100%-hoz, annál sikeresebben vizsgáznak az ott vezetni tanulók.</p>
                    <p><a href="#" class="fw-semibold text-success">Autósiskolák hivatalos jegyzéke (VSM) &rsaquo;&rsaquo;</a></p>
                </div>

                <div class="calc-info-block">
                    <div class="calc-info-banner" style="background-image: url('/public/assets/depositphotos_315565696_xl.jpg')">
                        <h3 class="calc-info-title">ÁKÓ = Átlagos Képzési Óraszám</h3>
                    </div>
                    <p>A kötelezően előírt gyakorlati vezetési órák száma (például „B" kategória esetén a 29 óra) csak azt a minimumot jelenti, ami alatt elvileg meg lehet szerezni a szükséges képességeket. Az ÁKÓ ezzel szemben azt mutatja meg Neked, hogy az iskolában ténylegesen mennyi gyakorlati órát vesznek a tanulók, amíg sikeres vizsgát nem tesznek.</p>
                    <p>Tehát ha pl. azt látod, hogy egy autósiskola „B" kategóriás ÁKÓ-ja 126%, az azt jelenti, hogy az ott tanulók átlagosan a kötelezően előírt gyakorlati vezetési órák 1,26-szorosát vezetik le, amíg sikeres vizsgát nem tesznek.</p>
                    <p class="mb-1"><strong>Mire figyelj:</strong></p>
                    <ul>
                        <li>Jogosítványod megszerzésének költsége és időtartama szempontjából elsődleges jelentősége van az összesen szükséges vezetési óraszámnak. Ezért figyelmeztető jel lehet, ha az ÁKÓ lényegesen magasabb, mint 100%.</li>
                        <li>Érdemes több helyi autósiskolát is összehasonlítani, mert regionális eltérések is lehetnek.</li>
                        <li>A folyamatosan 100%-os vagy azt nagyon megközelítő értéket érdemes némi fenntartással kezelni, különösen akkor, ha a gyakorlati vizsgasikerességi mutató (VSM) lényegesen elmarad a 100%-tól.</li>
                    </ul>
                    <p><a href="#" class="fw-semibold text-success">Autósiskolák hivatalos jegyzéke (ÁKÓ) &rsaquo;&rsaquo;</a></p>
                </div>

            </div>
        </div>
    </div>
</section>
