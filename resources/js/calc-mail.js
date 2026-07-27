// "Kalkuláció mentése" modal: a kalkuláció kiküldése emailben.
//
// A kalkuláció pillanatképét az app.js adja. Azért kapjuk paraméterként
// és NEM importáljuk, mert a main.js az app.js-t `?v=` cache-busterrel
// tölti be: a statikus import egy MÁSIK példányt hozna létre, aminek az
// alapértelmezett (nem a felhasználó által beállított) árai lennének.
let snapshotCalculation = () => null;

// Az éppen kiválasztott iskola + mutatói (a school-metrics.js adja),
// hogy a levélben is ott legyen, amit a képernyőn lát.
let snapshotSchool = () => null;

const ENDPOINT = '/api/kalkulacio/kuldes';

function el(id) {
    return document.getElementById(id);
}

function setStatus(message, tone) {
    const box = el('save-calc-status');
    if (!box) return;

    if (!message) {
        box.classList.add('d-none');
        box.textContent = '';
        return;
    }

    box.textContent = message;
    box.className = tone === 'error'
        ? 'small mt-3 mb-0 text-danger'
        : 'small mt-3 mb-0 text-success';
}

/** A gomb csak akkor aktív, ha van email és el van fogadva a GDPR. */
function syncSubmitButton() {
    const button = el('save-calc-submit');
    if (!button) return;

    const email = el('save-calc-email')?.value.trim() ?? '';
    const gdpr = el('save-calc-gdpr')?.checked ?? false;

    button.disabled = email === '' || !gdpr;
}

async function onSubmit() {
    const button = el('save-calc-submit');
    const email = el('save-calc-email')?.value.trim() ?? '';
    const gdpr = el('save-calc-gdpr')?.checked ?? false;

    if (!email || !gdpr) return;

    const calculation = snapshotCalculation();
    if (!calculation) {
        setStatus('Nincs kiszámolt kalkuláció.', 'error');
        return;
    }

    button.disabled = true;
    const originalText = button.textContent;
    button.textContent = 'KÜLDÉS…';
    setStatus('');

    try {
        const res = await fetch(ENDPOINT, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                email,
                gdpr,
                calculation,
                school: snapshotSchool(),
            }),
        });
        const json = await res.json();

        if (!json.success) {
            setStatus(json.message ?? 'Nem sikerült elküldeni a levelet.', 'error');
            return;
        }

        setStatus(json.message, 'success');
        // Sikeres küldés után a mezőt ürítjük, hogy ne menjen ki kétszer.
        el('save-calc-email').value = '';
        el('save-calc-gdpr').checked = false;
    } catch (error) {
        console.error('[calc-mail] küldés sikertelen', error);
        setStatus('Nem sikerült elküldeni a levelet. Ellenőrizd a kapcsolatot.', 'error');
    } finally {
        button.textContent = originalText;
        syncSubmitButton();
    }
}

export function initCalcMail(snapshotFn, schoolFn) {
    if (typeof snapshotFn === 'function') {
        snapshotCalculation = snapshotFn;
    }
    if (typeof schoolFn === 'function') {
        snapshotSchool = schoolFn;
    }

    const modal = el('saveCalculationModal');
    if (!modal) return;

    el('save-calc-email')?.addEventListener('input', syncSubmitButton);
    el('save-calc-gdpr')?.addEventListener('change', syncSubmitButton);
    el('save-calc-submit')?.addEventListener('click', onSubmit);

    // Újranyitáskor ne a korábbi küldés üzenete fogadja a felhasználót.
    modal.addEventListener('show.bs.modal', () => setStatus(''));

    syncSubmitButton();
}
