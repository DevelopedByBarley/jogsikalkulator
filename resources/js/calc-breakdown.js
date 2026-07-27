// Egy kalkuláció költségbontása -> HTML.
//
// A pillanatkép (app.js `data`) alapján számol, NEM a DOM-ból olvas,
// így az összehasonlítás oldalon is pontosan ugyanaz jön ki.

export function fmtFt(n) {
    return (parseInt(n) || 0).toLocaleString('hu-HU') + ' Ft';
}

export function fmtPercent(cell) {
    if (!cell) return '–';
    if (cell.value === null || cell.value === undefined) {
        return cell.note ?? '–';
    }
    return cell.value.toLocaleString('hu-HU', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }) + '%';
}

function esc(value) {
    const div = document.createElement('div');
    div.textContent = value ?? '';
    return div.innerHTML;
}

/** Csoportok ugyanabban a sorrendben, ahogy a kalkulátor mutatja. */
export function buildGroups(calc) {
    const p = calc.practical;
    const medical = parseInt(calc.medical_price) || 0;

    const groups = [];

    groups.push({
        title: 'ORVOSI ALKALMASSÁG',
        total: medical,
        rows: [{ label: 'Orvosi alkalmassági vizsgálat díja', value: fmtFt(medical) }],
    });

    groups.push({
        title: 'ELMÉLET',
        total: calc.theoritical.training_price + calc.theoritical.exam_fee,
        rows: [
            { label: 'Elméleti képzés díja', value: fmtFt(calc.theoritical.training_price) },
            { label: 'Közlekedési alapismeretek vizsgadíj', value: fmtFt(calc.theoritical.exam_fee) },
        ],
    });

    const practicalRows = [
        {
            label: 'Gyakorlati képzés díja (alap)',
            hint: `${fmtFt(p.training_basic_hours_price)} * ${p.training_basic_hours} tanóra`,
            value: fmtFt(p.training_basic_hours_price * p.training_basic_hours),
        },
        {
            label: 'Gyakorlati képzés díja (pótórák)',
            hint: `${fmtFt(p.training_extra_hours_price)} * ${p.extra_training_hours_amount} tanóra`,
            value: fmtFt(p.training_extra_hours_price * p.extra_training_hours_amount),
        },
    ];
    if (p.vehicle_handling_price > 0) {
        practicalRows.push({
            label: 'Járműkezelési vizsgadíj',
            value: fmtFt(p.vehicle_handling_price),
        });
    }
    practicalRows.push({
        label: 'Forgalmi vizsgadíj',
        value: fmtFt(p.practical_exam_fee_price),
    });

    groups.push({
        title: 'GYAKORLAT',
        total: (p.training_basic_hours_price * p.training_basic_hours)
             + (p.training_extra_hours_price * p.extra_training_hours_amount)
             + p.practical_exam_fee_price
             + p.vehicle_handling_price,
        rows: practicalRows,
    });

    groups.push({
        title: 'ELSŐSEGÉLY',
        total: calc.first_aid.training_basic_price + calc.first_aid.exam_fee,
        rows: [
            { label: 'Elsősegély-tanfolyam díja', value: fmtFt(calc.first_aid.training_basic_price) },
            { label: 'Elsősegély vizsga díja', value: fmtFt(calc.first_aid.exam_fee) },
        ],
    });

    groups.push({
        title: 'EGYÉB',
        total: calc.others.administration_fee + calc.others.document_fee,
        rows: [
            { label: 'Egyéb autósiskolai adminisztrációs költség', value: fmtFt(calc.others.administration_fee) },
            { label: 'Okmány elkészítés díja (első jogosítvány)', value: fmtFt(calc.others.document_fee) },
        ],
    });

    return groups;
}

function renderRow(row) {
    const hint = row.hint
        ? `<div class="cmp-row-hint">${esc(row.hint)}</div>`
        : '';
    return `
        <div class="cmp-row">
            <div class="cmp-row-label">
                ${esc(row.label)}
                ${hint}
            </div>
            <div class="cmp-row-value">${esc(row.value)}</div>
        </div>`;
}

export function renderBreakdown(calc) {
    const groups = buildGroups(calc).map((group) => `
        <div class="cmp-group">
            <div class="cmp-group-head">
                <span>${esc(group.title)}</span>
                <span>${esc(fmtFt(group.total))}</span>
            </div>
            ${group.rows.map(renderRow).join('')}
        </div>`).join('');

    return `
        ${groups}
        <div class="cmp-total">
            <span>ÖSSZESEN</span>
            <span>${esc(fmtFt(calc.outcome))}</span>
        </div>`;
}

export function renderMetrics(metrics) {
    if (!metrics) return '';

    const rows = [
        ['Vizsga Sikerességi Mutató (VSM) - Elmélet', metrics.vsm_theory],
        ['Vizsga Sikerességi Mutató (VSM) - Forgalom', metrics.vsm_traffic],
        ['Átlagos Képzési Óraszám (ÁKÓ) - Gyakorlat', metrics.ako_practical],
    ].map(([label, cell]) => `
        <div class="cmp-metric-row">
            <span>${esc(label)}</span>
            <span class="cmp-metric-value">${esc(fmtPercent(cell))}</span>
        </div>`).join('');

    return `
        <div class="cmp-metrics">
            <div class="cmp-metrics-title">
                Autósiskola mutatói a választott kategóriában - ${esc(metrics.period?.label ?? '')}
            </div>
            ${rows}
        </div>`;
}

export function renderAgeRequirements(age) {
    if (!age) return '';

    const rows = [
        ['Jelentkezés', age.registration],
        ['Elméleti', age.theoretical_exam],
        ['Járműkezelés', age.vehicle_handling_exam],
        ['Forgalmi', age.practical_exam],
    ].filter(([, value]) => value)
     .map(([label, value]) => `
        <div class="cmp-age-row">
            <span class="text-secondary">${esc(label)}</span>
            <span>${esc(value)}</span>
        </div>`).join('');

    return `
        <div class="cmp-age">
            <div class="cmp-age-title">Életkori feltételek</div>
            ${rows}
        </div>`;
}
