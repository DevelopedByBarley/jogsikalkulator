export function initHome() {
    // Compare badge szinkronizálás
    const navBadge    = document.getElementById('compare-count');
    const bannerBadge = document.getElementById('compare-banner-count');
    if (navBadge && bannerBadge) {
        bannerBadge.textContent = navBadge.textContent;
        new MutationObserver(() => {
            bannerBadge.textContent = navBadge.textContent;
        }).observe(navBadge, { childList: true, characterData: true, subtree: true });
    }

    // Sticky offset dinamikus beállítása
    const navbar  = document.getElementById('mainNavbar');
    const calcNav = document.getElementById('calculator-nav');
    if (navbar && calcNav) {
        const offset = navbar.offsetHeight + calcNav.offsetHeight + 16;
        document.querySelectorAll('.calc-sticky').forEach(el => {
            el.style.top = offset + 'px';
        });
    }


    // Calculator nav active state
    const calcNavItems = document.querySelectorAll('.calc-nav-item');
    if (calcNavItems.length) {
        const setActive = id => {
            calcNavItems.forEach(el => el.classList.remove('active'));
            const match = document.querySelector(`.calc-nav-item[href="#${id}"]`);
            if (match) match.classList.add('active');
        };

        // Kattintásra azonnali frissítés
        calcNavItems.forEach(el => {
            el.addEventListener('click', () => {
                const id = el.getAttribute('href')?.replace('#', '');
                if (id) setActive(id);
            });
        });

        // Scroll alapú követés
        const sections = document.querySelectorAll('section[id]');
        const navHeight = (document.getElementById('mainNavbar')?.offsetHeight ?? 0)
                        + (document.getElementById('calculator-nav')?.offsetHeight ?? 0);

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) setActive(entry.target.id);
            });
        }, {
            rootMargin: `-${navHeight + 10}px 0px -50% 0px`,
            threshold: 0
        });

        sections.forEach(s => observer.observe(s));
    }

    // Gyakorlati pótóra slider szinkronizálás
    let syncing = false;
    const basicSlider  = document.getElementById('practical_basic_price_slider');
    const extraSlider  = document.getElementById('practical_extra_price_slider');
    const syncCheckbox = document.getElementById('sync-extra-to-basic');
    if (basicSlider && extraSlider && syncCheckbox) {
        basicSlider.addEventListener('input', function () {
            if (syncCheckbox.checked && !syncing) {
                syncing = true;
                extraSlider.value = this.value;
                extraSlider.dispatchEvent(new Event('input'));
                syncing = false;
            }
        });
        extraSlider.addEventListener('input', function () {
            if (syncCheckbox.checked && !syncing) {
                syncing = true;
                basicSlider.value = this.value;
                basicSlider.dispatchEvent(new Event('input'));
                syncing = false;
            }
        });
    }
}
