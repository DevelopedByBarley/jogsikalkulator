// UI-hoz kapcsolódó segédfüggvények.

export function initUi() {
    // Jelöljük az oldalon, hogy a JS már betöltött.
    const root = document.documentElement;
    root.classList.add('js-ready');

    // Debug információ: mikor indult el az UI.
    const now = new Date();
    const stamp = now.toLocaleTimeString();
    console.info(`[ui] initialized at ${stamp}`);

    initToasts();
}

export function initToasts() {
    if (typeof window === 'undefined' || !window.bootstrap || !window.bootstrap.Toast) {
        return;
    }

    document.querySelectorAll('.toast.show').forEach((element) => {
        const toast = window.bootstrap.Toast.getOrCreateInstance(element);
        toast.show();
    });
}

export function initCalcNav() {
    const navItems = document.querySelectorAll('.calc-nav-item');
    if (!navItems.length) return;

    navItems.forEach(item => {
        item.addEventListener('click', () => {
            navItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
        });
    });

    // Csak a horgony-linkek mutatnak szekcióra. Az összehasonlítás külön
    // oldalra visz, annak a href-je nem érvényes CSS szelektor.
    const sections = Array.from(navItems)
        .map(item => item.getAttribute('href'))
        .filter(href => href?.startsWith('#'))
        .map(href => document.querySelector(href))
        .filter(Boolean);

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const id = entry.target.id;
            navItems.forEach(item => {
                item.classList.toggle('active', item.getAttribute('href') === `#${id}`);
            });
        });
    }, { rootMargin: '-40% 0px -55% 0px' });

    sections.forEach(section => observer.observe(section));
}

export function onReady(callback) {
    // Ha a DOM még nem kész, várunk a DOMContentLoaded eseményre.
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', callback, { once: true });
        return;
    }

    // Ha már kész a DOM, azonnal futtatjuk a callbacket.
    callback();
}
