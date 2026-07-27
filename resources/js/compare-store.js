// Összehasonlításra kiválasztott iskolák tárolása (localStorage).
//
// Egy tétel = a kiválasztott iskola + a mutatói + az ÉPPEN elvégzett
// kalkuláció pillanatképe. Így az összehasonlítás oldalon ugyanaz az
// összeg jelenik meg, mint amit a kalkulátorban látott a felhasználó.

export const STORAGE_KEY = 'jk_compare';
export const MAX_ITEMS = 4;
export const MIN_TO_COMPARE = 2;

// Ha bármelyik fül módosítja a listát, erről értesítjük a felületet.
export const COMPARE_EVENT = 'jk:compare-changed';

function emitChange() {
    document.dispatchEvent(new CustomEvent(COMPARE_EVENT));
}

/** @returns {Array<object>} a mentett tételek, hibás tárolónál üres lista */
export function getItems() {
    try {
        const raw = localStorage.getItem(STORAGE_KEY);
        if (!raw) return [];
        const parsed = JSON.parse(raw);
        return Array.isArray(parsed) ? parsed : [];
    } catch (error) {
        console.error('[compare] olvasás sikertelen', error);
        return [];
    }
}

function save(items) {
    try {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
        emitChange();
        return true;
    } catch (error) {
        console.error('[compare] mentés sikertelen', error);
        return false;
    }
}

/**
 * Egy tétel azonossága: iskola + kategória + korábbi jogosítvány.
 * Ugyanaz az iskola más kategóriában külön tételként hasonlítható.
 */
export function itemKey(extId, category, prevCategory) {
    return `${extId}|${category}|${prevCategory ?? 'none'}`;
}

export function hasItem(extId, category, prevCategory) {
    const key = itemKey(extId, category, prevCategory);
    return getItems().some((item) => item.key === key);
}

export function count() {
    return getItems().length;
}

export function canCompare() {
    return count() >= MIN_TO_COMPARE;
}

/**
 * @returns {{ok: boolean, reason?: 'duplicate'|'full'|'error'}}
 */
export function addItem({ school, metrics, calculation }) {
    const items = getItems();
    const key = itemKey(school.ext_id, calculation.category, calculation.prev_category);

    if (items.some((item) => item.key === key)) {
        return { ok: false, reason: 'duplicate' };
    }
    if (items.length >= MAX_ITEMS) {
        return { ok: false, reason: 'full' };
    }

    items.push({ key, school, metrics, calculation });
    return save(items) ? { ok: true } : { ok: false, reason: 'error' };
}

export function removeItem(key) {
    save(getItems().filter((item) => item.key !== key));
}

export function clearItems() {
    save([]);
}
