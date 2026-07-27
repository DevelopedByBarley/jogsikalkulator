// Belépési pont.
//
// FONTOS: minden modult a `?v=` cache-busterrel töltünk be.
// A layout csak a main.js URL-jére teszi rá a verziót; ha innen statikus
// `import`-tal húznánk be a többit, azok VERZIÓ NÉLKÜLI URL-re mennének,
// és a böngésző a RÉGI, gyorsítótárazott példányt adná vissza – hiába
// frissült a fájl a szerveren. Ezért dinamikusan, verzióval importálunk.

const _v = new URL(import.meta.url).searchParams.get('v') ?? '';
const load = (name) => import(`./${name}.js?v=${_v}`);

const [
    { initUi, onReady, initCalcNav },
    { validator },
    { cookie },
    { initHome },
    { initTabs },
    { initSchoolMetrics, snapshotSchool },
    { initCompareCounter },
    { initComparePage },
    { initCalcMail },
    { initApp, snapshotCalculation },
] = await Promise.all([
    load('ui'),
    load('validator'),
    load('cookie'),
    load('home'),
    load('tabs'),
    load('school-metrics'),
    load('compare-counter'),
    load('compare-page'),
    load('calc-mail'),
    load('app'),
]);

// Egyszerű app objektum: itt van a belépési pont és az események kötése.
const app = {
    boot() {
        initApp();
        initUi();
        initCalcNav();
        validator();
        cookie();
        initHome();
        initTabs();
        // Az app.js `?v=` cache-busterrel töltődik, ezért a pillanatkép
        // függvényt átadjuk – így biztosan ugyanazt a példányt olvassuk.
        initSchoolMetrics(snapshotCalculation);
        initCompareCounter();
        initComparePage();
        initCalcMail(snapshotCalculation, snapshotSchool);
        // Globális event listener-ek regisztrálása.
        this.bindEvents();
    },

    bindEvents() {
        // Eseménydelegálás: egy helyen figyeljük a kattintásokat.
        document.addEventListener('click', (event) => {
            // Csak akkor reagálunk, ha a cél vagy őse tartalmaz data-action attribútumot.
            const trigger = event.target.closest('[data-action]');
            if (!trigger) {
                return;
            }

            // Itt lehet később action alapú logikát bővíteni.
            console.log(`[app] action: ${trigger.dataset.action}`);
        });
    },
};

// Biztonságos indulás: csak akkor bootolunk, ha a DOM már használható.
onReady(() => {
    try {
        app.boot();
    } catch (error) {
        // Ha induláskor hiba van, legyen látható a konzolban.
        console.error('[app] boot failed', error);
    }
});
