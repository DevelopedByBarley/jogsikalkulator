export function initTabs() {
    document.querySelectorAll('.row.g-5').forEach(row => {
        const leftCol  = row.querySelector(':scope > .col-lg-5');
        const rightCol = row.querySelector(':scope > .col-lg-7');
        if (!leftCol || !rightCol) return;

        const section   = row.closest('section');
        const leftLabel = (section && section.id === 'eredmeny') ? 'Eredmény' : 'Kalkulátor';

        row.classList.add('calc-tab-row');
        leftCol.classList.add('tab-active');

        const nav = document.createElement('div');
        nav.className = 'calc-tab-nav';
        nav.innerHTML =
            `<button type="button" class="calc-tab-btn active" data-tab="left">${leftLabel}</button>` +
            `<button type="button" class="calc-tab-btn" data-tab="right">Infó</button>`;
        row.insertBefore(nav, row.firstChild);

        nav.querySelectorAll('.calc-tab-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                nav.querySelectorAll('.calc-tab-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const showLeft = this.dataset.tab === 'left';
                leftCol.classList.toggle('tab-active',  showLeft);
                rightCol.classList.toggle('tab-active', !showLeft);
            });
        });
    });
}
