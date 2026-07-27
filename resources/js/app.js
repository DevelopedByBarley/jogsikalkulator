let categoryConfigs = {};

const PAIRS_REQUIRING_YEARS = new Set(['A2-A1', 'A-A1', 'A-A2']);

const data = {
    category: 'B',
    prev_category: 'none',
    medical_price: 7500,
    theoritical: { training_price: 20000, exam_fee: 4600 },
    practical: {
        training_basic_hours_price: 5000,
        training_basic_hours: 30,
        training_extra_hours_price: 5000,
        extra_training_hours_amount: 5,
        practical_exam_fee_price: 11000,
        vehicle_handling_price: 0,
    },
    first_aid: { training_basic_price: 0, exam_fee: 20900 },
    others: { administration_fee: 0, document_fee: 0 },
    age_requirements: null,
    outcome: 0,
};

function fmtFt(n) {
    n = parseInt(n) || 0;
    return n.toLocaleString('hu-HU') + ' Ft';
}

function setText(id, value) {
    const el = document.getElementById(id);
    if (el) el.textContent = value;
}

function show(id) {
    const el = document.getElementById(id);
    if (el) el.classList.remove('d-none');
}

function hide(id) {
    const el = document.getElementById(id);
    if (el) el.classList.add('d-none');
}

function applyConfig(config) {
    data.medical_price                              = config.medical_price;
    data.theoritical.training_price                 = config.theoritical.training_price;
    data.theoritical.exam_fee                       = config.theoritical.exam_fee;
    data.practical.training_basic_hours_price       = config.practical.training_basic_hours_price;
    data.practical.training_basic_hours             = config.practical.training_basic_hours;
    data.practical.training_extra_hours_price       = config.practical.training_extra_hours_price;
    data.practical.extra_training_hours_amount      = config.practical.extra_training_hours_amount;
    data.practical.practical_exam_fee_price         = config.practical.practical_exam_fee_price;
    data.practical.vehicle_handling_price           = config.practical.vehicle_handling_price;
    data.first_aid.training_basic_price             = config.first_aid.training_basic_price;
    data.first_aid.exam_fee                         = config.first_aid.exam_fee;
    data.others.administration_fee                  = config.others.administration_fee;
    data.others.document_fee                        = config.others.document_fee;
    data.age_requirements                           = config.age_requirements || null;

    function setSlider(id, value) {
        const el = document.getElementById(id);
        if (el) el.value = value;
    }
    setSlider('theoretical_training_price_slider', config.theoritical.training_price);
    setSlider('practical_basic_price_slider',       config.practical.training_basic_hours_price);
    setSlider('practical_extra_price_slider',        config.practical.training_extra_hours_price);
    setSlider('practical_extra_hours_slider',        config.practical.extra_training_hours_amount);
    setSlider('first_aid_training_slider',           config.first_aid.training_basic_price);
    setSlider('admin_fee_slider',                    config.others.administration_fee);
}

function calculate() {
    let total = 0;
    const med = parseInt(data.medical_price);
    if (!isNaN(med) && med > 0) total += med;
    total += data.theoritical.training_price + data.theoritical.exam_fee;
    total += (data.practical.training_basic_hours_price * data.practical.training_basic_hours)
           + (data.practical.training_extra_hours_price * data.practical.extra_training_hours_amount)
           + data.practical.practical_exam_fee_price
           + data.practical.vehicle_handling_price;
    total += data.first_aid.training_basic_price + data.first_aid.exam_fee;
    total += data.others.administration_fee + data.others.document_fee;
    data.outcome = total;
}

function render() {
    // Orvosi
    const med = parseInt(data.medical_price);
    if (!isNaN(med) && data.medical_price !== null) {
        show('orvosi');
        show('medical-row');
        setText('medical_price_display', fmtFt(med));
        show('result-medical-row');
        setText('result-medical', fmtFt(med));
    } else {
        hide('orvosi');
        hide('medical-row');
        show('result-medical-row');
        setText('result-medical', fmtFt(0));
    }

    // Elmélet
    setText('theoretical_training_price_display', fmtFt(data.theoritical.training_price));
    setText('theoretical_exam_fee_display', fmtFt(data.theoritical.exam_fee));

    // Ha nincs elméleti képzési díj (pl. motoros előélet miatti felmentés),
    // a képzési díj csúszkát letiltjuk, hogy ne lehessen "varázsból" díjat felhúzni.
    const theoryPriceSlider = document.getElementById('theoretical_training_price_slider');
    if (theoryPriceSlider) {
        theoryPriceSlider.disabled = (parseInt(data.theoritical.training_price) || 0) === 0;
    }

    // Gyakorlat
    setText('practical_basic_price_display', fmtFt(data.practical.training_basic_hours_price));
    setText('practical_basic_hours_display', data.practical.training_basic_hours + ' óra');
    setText('practical_extra_price_display', fmtFt(data.practical.training_extra_hours_price));
    setText('practical_extra_hours_display', data.practical.extra_training_hours_amount + ' óra');
    setText('practical_exam_fee_display', fmtFt(data.practical.practical_exam_fee_price));

    if (data.practical.vehicle_handling_price > 0) {
        show('vehicle-handling-row');
        setText('vehicle_handling_display', fmtFt(data.practical.vehicle_handling_price));
    } else {
        hide('vehicle-handling-row');
    }

    // Elsősegély
    setText('first_aid_training_display', fmtFt(data.first_aid.training_basic_price));
    setText('first_aid_exam_fee_display', fmtFt(data.first_aid.exam_fee));

    // Egyéb
    setText('admin_fee_display', fmtFt(data.others.administration_fee));
    setText('document_fee_display', fmtFt(data.others.document_fee));

    // Eredmény kártya
    setText('result-title', 'A(z) "' + data.category + '" kategóriás jogosítvány várható költsége');
    setText('outcome-total', fmtFt(data.outcome));

    const theoreticalTotal = data.theoritical.training_price + data.theoritical.exam_fee;
    setText('result-theoretical', fmtFt(theoreticalTotal));

    const practicalTotal = (data.practical.training_basic_hours_price * data.practical.training_basic_hours)
                         + (data.practical.training_extra_hours_price * data.practical.extra_training_hours_amount)
                         + data.practical.practical_exam_fee_price
                         + data.practical.vehicle_handling_price;
    setText('result-practical', fmtFt(practicalTotal));

    const firstAidTotal = data.first_aid.training_basic_price + data.first_aid.exam_fee;
    setText('result-first-aid', fmtFt(firstAidTotal));

    const othersTotal = data.others.administration_fee + data.others.document_fee;
    setText('result-others', fmtFt(othersTotal));

    // Korhatárok
    if (data.age_requirements) {
        show('age-requirements-section');
        setText('age-registration', data.age_requirements.registration);
        setText('age-theoretical', data.age_requirements.theoretical_exam);
        if (data.age_requirements.vehicle_handling_exam) {
            show('age-vehicle-handling-row');
            setText('age-vehicle-handling', data.age_requirements.vehicle_handling_exam);
        } else {
            hide('age-vehicle-handling-row');
        }
        setText('age-practical', data.age_requirements.practical_exam);
    } else {
        hide('age-requirements-section');
    }
}

/**
 * Az aktuális kalkuláció pillanatképe az összehasonlításhoz.
 *
 * Mély másolatot adunk vissza, hogy a mentett tétel ne változzon,
 * ha a felhasználó utána még tekergeti a csúszkákat.
 */
export function snapshotCalculation() {
    return JSON.parse(JSON.stringify(data));
}

function updatePracticalSliderMax(category) {
    const highMaxCategories = new Set(['A1', 'A2', 'A', 'B']);
    const max = highMaxCategories.has(category) ? 25000 : 15000;
    const label = max.toLocaleString('hu-HU') + ' Ft';

    ['practical_basic_price_slider', 'practical_extra_price_slider'].forEach(id => {
        const slider = document.getElementById(id);
        if (!slider) return;
        slider.max = max;
        if (parseInt(slider.value) > max) {
            slider.value = max;
        }
    });
    setText('practical_basic_price_max_label', label);
    setText('practical_extra_price_max_label', label);
}

function setPrevCategoryState(allowed) {
    const allowedSet = new Set(['none', ...allowed]);
    let hasChecked = false;
    document.querySelectorAll('input[name="prev_category"]').forEach(input => {
        if (allowedSet.has(input.value)) {
            input.disabled = false;
            if (input.checked) hasChecked = true;
        } else {
            input.disabled = true;
            input.checked = false;
        }
    });
    if (!hasChecked) {
        const none = document.querySelector('input[name="prev_category"][value="none"]');
        if (none) none.checked = true;
    }
}

function activatePrevCategories(category) {
    const map = {
        AM: ['none'],
        A1: ['none', 'AM', 'B'],
        A2: ['none', 'AM', 'A1', 'B'],
        A:  ['none', 'AM', 'A1', 'A2', 'B'],
        B:  ['none', 'AM', 'A1', 'A2', 'A'],
    };
    setPrevCategoryState(map[category] || ['none']);
}


export function initApp() {
    const form = document.getElementById('category-form');
    if (!form) return;

    // Azonnal renderelünk az alapértékekkel (API nélkül is látható)
    calculate();
    render();
    updatePracticalSliderMax('B');

    // Rádió változás kezelő
    function onRadioChange() {
        const category = form.querySelector('input[name="category"]:checked')?.value || 'B';
        activatePrevCategories(category);
        const prevCategory = form.querySelector('input[name="prev_category"]:checked')?.value || 'none';

        const baseKey = category + '-' + prevCategory;
        const requiresYears = PAIRS_REQUIRING_YEARS.has(baseKey);

        if (requiresYears) {
            show('prev-category-from');
        } else {
            hide('prev-category-from');
            hide('years-warning');
            document.querySelectorAll('input[name="prev_category_from_more_than_2_years"]')
                .forEach(r => r.checked = false);
        }

        const yearsValue = form.querySelector('input[name="prev_category_from_more_than_2_years"]:checked')?.value || null;
        if (requiresYears && !yearsValue) {
            show('years-warning');
            hide('result-card');
            return;
        }
        hide('years-warning');
        show('result-card');

        const key = yearsValue ? baseKey + '-' + yearsValue : baseKey;
        const config = categoryConfigs[key];

        if (config) {
            data.category = category;
            data.prev_category = prevCategory;
            applyConfig(config);
        }

        updatePracticalSliderMax(category);
        calculate();
        render();
    }

    // Rádió gombok figyelése
    form.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', onRadioChange);
    });

    // Slider listenerek – NEM a form change, hanem direktben az inputon
    function bindSlider(id, setter) {
        const slider = document.getElementById(id);
        if (!slider) return;
        slider.addEventListener('input', function () {
            setter(parseInt(this.value));
            calculate();
            render();
        });
    }

    bindSlider('theoretical_training_price_slider', v => data.theoritical.training_price = v);
    bindSlider('practical_basic_price_slider',       v => data.practical.training_basic_hours_price = v);
    bindSlider('practical_extra_price_slider',        v => data.practical.training_extra_hours_price = v);
    bindSlider('practical_extra_hours_slider',        v => data.practical.extra_training_hours_amount = v);
    bindSlider('first_aid_training_slider',           v => data.first_aid.training_basic_price = v);
    bindSlider('admin_fee_slider',                    v => data.others.administration_fee = v);

    // API betöltés – ha megvan, újrafuttatjuk a rádió logikát
    fetch('/api/categories')
        .then(r => r.json())
        .then(json => {
            categoryConfigs = json.data;
            onRadioChange();
        })
        .catch(e => console.error('[app] config load failed', e));

    setPrevCategoryState([]);
}
