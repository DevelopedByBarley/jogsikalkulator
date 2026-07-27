// Összehasonlítás oldal: a mentett iskolák egymás mellett.

import { getItems, removeItem, clearItems, COMPARE_EVENT, MIN_TO_COMPARE } from './compare-store.js';
import { renderBreakdown, renderMetrics, renderAgeRequirements, fmtFt } from './calc-breakdown.js';

const PREV_LABELS = {
    none: 'NINCS',
    AM: 'AM',
    A1: 'A1',
    A2: 'A2',
    A: 'A',
    B: 'B',
};

function esc(value) {
    const div = document.createElement('div');
    div.textContent = value ?? '';
    return div.innerHTML;
}

function renderCard(item, isCheapest) {
    const calc = item.calculation;
    const prev = PREV_LABELS[calc.prev_category] ?? calc.prev_category;

    return `
        <article class="cmp-card${isCheapest ? ' cmp-card--best' : ''}">

            <header class="cmp-card-head">
                <div class="cmp-card-cat">
                    "${esc(calc.category)}" kategória
                    <span class="cmp-card-prev">Jelenlegi jogosítvány: ${esc(prev)}</span>
                </div>
                <h2 class="cmp-card-school">${esc(item.school.name)}</h2>
            </header>

            ${renderMetrics(item.metrics)}
            ${renderAgeRequirements(calc.age_requirements)}

            <div class="cmp-card-body">
                ${renderBreakdown(calc)}
            </div>

            <footer class="cmp-card-foot">
                <button type="button" class="btn btn-outline-danger btn-sm w-100"
                        data-remove="${esc(item.key)}">
                    Törlés
                </button>
            </footer>
        </article>`;
}

function render() {
    const grid = document.getElementById('compare-grid');
    const empty = document.getElementById('compare-empty');
    const toolbar = document.getElementById('compare-toolbar');
    if (!grid) return;

    const items = getItems();

    if (items.length < MIN_TO_COMPARE) {
        grid.innerHTML = '';
        grid.classList.add('d-none');
        toolbar?.classList.add('d-none');
        if (empty) {
            empty.classList.remove('d-none');
            empty.querySelector('[data-empty-text]').textContent = items.length === 0
                ? 'Még nem választottál ki iskolát az összehasonlításhoz.'
                : `Az összehasonlításhoz legalább ${MIN_TO_COMPARE} iskola kell – jelenleg ${items.length} van kiválasztva.`;
        }
        return;
    }

    empty?.classList.add('d-none');
    toolbar?.classList.remove('d-none');
    grid.classList.remove('d-none');

    // A legolcsóbb ajánlatot kiemeljük
    const cheapest = Math.min(...items.map((item) => item.calculation.outcome));

    grid.style.setProperty('--cmp-cols', String(items.length));
    grid.innerHTML = items
        .map((item) => renderCard(item, item.calculation.outcome === cheapest))
        .join('');

    const summary = document.getElementById('compare-summary');
    if (summary) {
        const spread = Math.max(...items.map((i) => i.calculation.outcome)) - cheapest;
        summary.textContent = spread > 0
            ? `${items.length} iskola összehasonlítva – a legdrágább és a legolcsóbb között ${fmtFt(spread)} a különbség.`
            : `${items.length} iskola összehasonlítva.`;
    }
}

export function initComparePage() {
    const grid = document.getElementById('compare-grid');
    if (!grid) return;

    grid.addEventListener('click', (event) => {
        const button = event.target.closest('[data-remove]');
        if (button) removeItem(button.dataset.remove);
    });

    document.getElementById('compare-clear')?.addEventListener('click', () => {
        if (confirm('Biztosan törlöd az összes kiválasztott iskolát?')) {
            clearItems();
        }
    });

    document.addEventListener(COMPARE_EVENT, render);
    window.addEventListener('storage', render);
    render();
}
