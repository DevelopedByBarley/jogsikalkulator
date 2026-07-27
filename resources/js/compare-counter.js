// Összehasonlítás számlálók + belépési pontok.
//
// Három helyen jelenik meg ugyanaz az állapot: a navbarban, a kalkulátor
// navigációjában (header alatt) és az oldal alján lévő banneren.
// Az összehasonlítás oldalra csak legalább MIN_TO_COMPARE iskolával lehet
// átlépni, addig a linkek tiltott állapotban maradnak.

import { COMPARE_EVENT, count, canCompare, MIN_TO_COMPARE } from './compare-store.js';

const COMPARE_URL = '/osszehasonlitas';

// Minden badge, ami a kiválasztott iskolák számát mutatja
const BADGE_IDS = ['compare-nav-count', 'compare-count', 'compare-banner-count'];

// Minden elem, ami az összehasonlítás oldalra visz
const TRIGGER_IDS = ['compare-nav-link', 'compare-calcnav-link', 'btn-go-compare'];

function els(ids) {
    return ids.map((id) => document.getElementById(id)).filter(Boolean);
}

function render() {
    const total = count();
    const ready = canCompare();

    els(BADGE_IDS).forEach((badge) => {
        badge.textContent = String(total);
        badge.classList.toggle('d-none', total === 0);
    });

    els(TRIGGER_IDS).forEach((trigger) => {
        trigger.classList.toggle('is-disabled', !ready);
        trigger.setAttribute('aria-disabled', ready ? 'false' : 'true');
        trigger.title = ready
            ? 'Kiválasztott iskolák összehasonlítása'
            : `Legalább ${MIN_TO_COMPARE} iskola kell az összehasonlításhoz (jelenleg: ${total})`;
    });
}

export function initCompareCounter() {
    const triggers = els(TRIGGER_IDS);
    if (!triggers.length) return;

    triggers.forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
            if (!canCompare()) {
                event.preventDefault();
                return;
            }
            // A banner <button>, nem link – neki kézzel navigálunk.
            if (trigger.tagName === 'BUTTON') {
                window.location.href = COMPARE_URL;
            }
        });
    });

    document.addEventListener(COMPARE_EVENT, render);
    // Másik fülön történt változás is látszódjon
    window.addEventListener('storage', render);
    render();
}
