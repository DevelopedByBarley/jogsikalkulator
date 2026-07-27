// Autósiskola mutatói (VSM / ÁKÓ) a kalkulátor eredmény blokkjában.
//
// A negyedévet SOHA nem írjuk be kézzel: a szerver mindig a DB-ben lévő
// legfrissebb negyedévet adja vissza, a felirat abból épül.

import { addItem, hasItem, MAX_ITEMS } from './compare-store.js';

const MIN_CHARS = 2;
const DEBOUNCE_MS = 250;

// A kalkuláció pillanatképét az app.js adja. Azért kapjuk paraméterként
// és NEM importáljuk, mert a main.js az app.js-t `?v=` cache-busterrel
// tölti be: a statikus import egy MÁSIK példányt hozna létre, aminek az
// alapértelmezett (nem a felhasználó által beállított) árai lennének.
let snapshotCalculation = () => null;

// Az éppen kiválasztott iskola; kategóriaváltáskor ezzel töltünk újra.
let selectedSchool = null;

// A legutóbb betöltött mutatók – ezt mentjük az összehasonlításhoz,
// hogy ne kelljen újra lekérni a szervertől.
let currentMetrics = null;

function el(id) {
    return document.getElementById(id);
}

function fmtPercent(cell) {
    // cell: { value: number|null, note: string|null }
    if (!cell) return '–';
    if (cell.value === null || cell.value === undefined) {
        return cell.note ?? '–';
    }
    return cell.value.toLocaleString('hu-HU', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }) + '%';
}

function currentCategory() {
    const checked = document.querySelector('input[name="category"]:checked');
    return checked?.value || 'B';
}

function showMessage(text) {
    const box = el('school-metrics-message');
    if (!box) return;
    box.textContent = text;
    box.classList.remove('d-none');
    el('school-metrics-result')?.classList.add('d-none');
    el('school-metrics-empty')?.classList.add('d-none');
}

function hideMessage() {
    el('school-metrics-message')?.classList.add('d-none');
}

function clearSuggestions() {
    const box = el('school-suggestions');
    if (!box) return;
    box.innerHTML = '';
    box.classList.add('d-none');
}

function renderSuggestions(schools) {
    const box = el('school-suggestions');
    if (!box) return;

    if (!schools.length) {
        clearSuggestions();
        return;
    }

    box.innerHTML = '';
    schools.forEach((school) => {
        const item = document.createElement('button');
        item.type = 'button';
        item.className = 'list-group-item list-group-item-action text-start';
        item.textContent = school.name;
        item.addEventListener('click', () => {
            el('school-search').value = school.name;
            selectedSchool = school;
            clearSuggestions();
            loadMetrics();
        });
        box.appendChild(item);
    });
    box.classList.remove('d-none');
}

async function searchSchools(term) {
    try {
        const res = await fetch('/api/iskolak/kereses?q=' + encodeURIComponent(term));
        const json = await res.json();
        renderSuggestions(json.data ?? []);
    } catch (error) {
        console.error('[school-metrics] search failed', error);
        clearSuggestions();
    }
}

async function loadMetrics() {
    if (!selectedSchool) return;

    const params = new URLSearchParams({
        ext_id: selectedSchool.ext_id ?? '',
        category: currentCategory(),
    });

    try {
        const res = await fetch('/api/iskolak/mutatok?' + params.toString());
        const json = await res.json();

        if (!json.success || !json.data) {
            currentMetrics = null;
            showMessage(json.message ?? 'Ehhez az iskolához nincs elérhető adat.');
            syncCompareButton();
            return;
        }

        const d = json.data;
        currentMetrics = d;
        hideMessage();
        el('school-metrics-empty')?.classList.add('d-none');
        el('school-metrics-result')?.classList.remove('d-none');

        // A negyedév felirat a szervertől jön, nem hardcode-olt
        const title = el('school-metrics-title');
        if (title) {
            title.textContent =
                `Autósiskola mutatói a választott kategóriában - ${d.period.label}`;
        }

        el('metric-vsm-theory').textContent = fmtPercent(d.vsm_theory);
        el('metric-vsm-traffic').textContent = fmtPercent(d.vsm_traffic);
        el('metric-ako-practical').textContent = fmtPercent(d.ako_practical);
        syncCompareButton();
    } catch (error) {
        console.error('[school-metrics] load failed', error);
        currentMetrics = null;
        showMessage('Nem sikerült betölteni a mutatókat.');
        syncCompareButton();
    }
}

/**
 * Az "összehasonlításra" gomb állapota: iskola nélkül nincs mit menteni,
 * és ugyanazt a kombinációt nem vesszük fel kétszer.
 */
function syncCompareButton() {
    const button = el('btn-add-to-compare');
    if (!button) return;

    if (!selectedSchool || !currentMetrics) {
        button.disabled = true;
        button.textContent = 'Kiválasztás összehasonlításra';
        return;
    }

    const calc = snapshotCalculation();
    if (!calc) {
        button.disabled = true;
        return;
    }

    const already = hasItem(selectedSchool.ext_id, calc.category, calc.prev_category);

    button.disabled = already;
    button.textContent = already
        ? 'Már az összehasonlításban'
        : 'Kiválasztás összehasonlításra';
}

function onAddToCompare() {
    if (!selectedSchool || !currentMetrics) return;

    const calculation = snapshotCalculation();
    if (!calculation) return;

    const result = addItem({
        school: { ext_id: selectedSchool.ext_id, name: currentMetrics.school_name },
        metrics: {
            period: currentMetrics.period,
            vsm_theory: currentMetrics.vsm_theory,
            vsm_traffic: currentMetrics.vsm_traffic,
            ako_practical: currentMetrics.ako_practical,
        },
        calculation,
    });

    if (!result.ok) {
        if (result.reason === 'full') {
            showMessage(`Legfeljebb ${MAX_ITEMS} iskolát tudsz egyszerre összehasonlítani.`);
        } else if (result.reason === 'error') {
            showMessage('Nem sikerült menteni. Engedélyezve van a böngészőben a tárolás?');
        }
        return;
    }

    syncCompareButton();
}

/**
 * A kiválasztott iskola + mutatói, vagy null, ha nincs betöltve.
 * A kalkuláció emailben küldéséhez kell (calc-mail.js).
 */
export function snapshotSchool() {
    if (!selectedSchool || !currentMetrics) return null;

    return {
        name: currentMetrics.school_name,
        metrics: {
            period: currentMetrics.period,
            vsm_theory: currentMetrics.vsm_theory,
            vsm_traffic: currentMetrics.vsm_traffic,
            ako_practical: currentMetrics.ako_practical,
        },
    };
}

export function initSchoolMetrics(snapshotFn) {
    if (typeof snapshotFn === 'function') {
        snapshotCalculation = snapshotFn;
    }

    const input = el('school-search');
    if (!input) return;

    let timer = null;

    input.addEventListener('input', () => {
        const term = input.value.trim();

        // Ha átírja a nevet, a korábbi találat már nem érvényes
        selectedSchool = null;
        currentMetrics = null;
        el('school-metrics-result')?.classList.add('d-none');
        el('school-metrics-empty')?.classList.remove('d-none');
        hideMessage();
        syncCompareButton();

        clearTimeout(timer);
        if (term.length < MIN_CHARS) {
            clearSuggestions();
            return;
        }
        // Debounce: ne küldjünk kérést minden leütésre
        timer = setTimeout(() => searchSchools(term), DEBOUNCE_MS);
    });

    // Kattintás a listán kívülre -> javaslatok bezárása
    document.addEventListener('click', (event) => {
        if (!event.target.closest('#school-metrics-card')) {
            clearSuggestions();
        }
    });

    // Kategóriaváltáskor ugyanarra az iskolára újratöltjük a mutatókat
    document.querySelectorAll('input[name="category"]').forEach((radio) => {
        radio.addEventListener('change', () => {
            if (selectedSchool) loadMetrics();
        });
    });

    // A tétel kulcsa a korábbi jogosítványt is tartalmazza, ezért erre is
    // frissítjük a gomb feliratát (a mutatók viszont nem változnak tőle).
    document.querySelectorAll('input[name="prev_category"], input[name="prev_category_from_more_than_2_years"]')
        .forEach((radio) => radio.addEventListener('change', syncCompareButton));

    el('btn-add-to-compare')?.addEventListener('click', onAddToCompare);
    syncCompareButton();
}
