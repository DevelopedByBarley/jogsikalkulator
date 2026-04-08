// Kategória konfigurációk betöltése
let categoryConfigs = {};

// Betöltjük a JSON konfigurációt az API végpontból
fetch('/api/categories')
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(configs => {
        categoryConfigs = configs.data;
        // console.log('Category configs loaded:', categoryConfigs);
    })
    .catch(error => console.error('Error loading category configs:', error));


// A kalkulációs adatmodell (később a form mezőkből is frissíthető)
const data = {
    category: 'B', // Alapértelmezett kategória
    activate_prev_categories: [], // Ez határozza meg, hogy mely előző kategóriák legyenek engedélyezve
    prev_category: '', // Alapértelmezett már meglévő kategória

    prev_category_from: null, // Ha szükséges, hogy hány éve van meg az előző kategória (kevesebb mint 2 év, több mint 2 év)
    prev_category_from_more_than_2_years: null,
    /* ------- Orvosi alkalmassági szekció ----------  */
    medical_price: 7500, // Orvosi alkalmassági vizsgálat ára

    /* ------- Elmélet szekció ----------  */

    theoritical: {
        training_price: 20000, // Elméleti képzés díja
        exam_fee: 4600, // Közlekedési alapismeretek vizsgadíj
    },

    /* ------- Gyakorlati szekció ----------  */

    practical: {
        training_basic_hours_price: 5000, // Gyakorlati óradíj - alapóra (Ft/tanóra)
        training_basic_hours: 30, // Kötelező óraszám
        training_extra_hours_price: 5000, // Gyakorlati óradíj - pótóra (Ft/tanóra)
        extra_training_hours_amount: 5, // Kötelezőn felüli gyakorlati órák száma (pótórák)
        practical_exam_fee_price: 11000, // Forgalmi vizsgadíj
        vehicle_handling_price: 0, // Járműkezelés vizsgadíj
    },

    /* ------- Elsősegély szekció ----------  */

    first_aid: {
        training_basic_price: 0, // Elsősegély-tanfolyam díja
        exam_fee: 20900, // Elsősegély vizsga díja
    },

    /* ------- Egyéb szekció ----------  */

    others: {
        administration_fee: 0, // Egyéb autósiskolai adminisztrációs költség
        document_fee: 0, // Okmány elkészítés díja (első jogosítvány)
    },

    /* ------- Eredmény ----------  */

    outcome: 0,
};

function restoreDefaultData() {
    data.category = 'B';
    data.prev_category = 'none';
    data.activate_prev_categories = [];

    data.medical_price = 7500;

    data.theoritical.training_price = 20000;
    data.theoritical.exam_fee = 4600;

    data.practical.training_basic_hours_price = 5000;
    data.practical.training_basic_hours = 30;
    data.practical.training_extra_hours_price = 5000;
    data.practical.extra_training_hours_amount = 5;
    data.practical.practical_exam_fee_price = 11000;
    data.practical.vehicle_handling_price = 0;

    data.first_aid.training_basic_price = 0;
    data.first_aid.exam_fee = 20900;

    data.others.administration_fee = 0;
    data.others.document_fee = 0;

    data.outcome = 0;
}

function activatePrevCategories(category) {
    switch (category) {
        case 'AM':
            data.activate_prev_categories = ['none'];
            break;
        case 'A1':
            data.activate_prev_categories = ['none', 'AM', 'B'];
            break;
        case 'A2':
            data.activate_prev_categories = ['none', 'AM', 'A1', 'B'];
            break;
        case 'A':
            data.activate_prev_categories = ['none', 'AM', 'A1', 'A2'];
            break;
        case 'B':
            data.activate_prev_categories = ['none', 'AM', 'A1', 'A2', 'A'];
            break;
        default:
            data.activate_prev_categories = ['none'];
    }
    setPrevCategoryState(data.activate_prev_categories);
}

// A kategória + előző kategória párosítás szabályai
function pairCategories(category, prev_category = 'none') {
    const key = `${category}-${prev_category}`;
    const config = categoryConfigs[key];

    console.log(config);
    
    if (config) {

        
        // Alkalmazzuk a konfigurációt
        data.category = category;
        data.prev_category = prev_category;
        
        // Hány éve van meg az előző kategória (ha van)
        data.prev_category_from = config.prev_category_from;
        data.prev_category_from_more_than_2_years = config.prev_category_from_more_than_2_years;
        
        console.log(data.prev_category_from, data.prev_category_from_more_than_2_years);
        // Medical
        data.medical_price = config.medical_price;
        
        // Theoritical
        data.theoritical.training_price = config.theoritical.training_price;
        data.theoritical.exam_fee = config.theoritical.exam_fee;
        
        // Practical
        data.practical.training_basic_hours_price = config.practical.training_basic_hours_price;
        data.practical.training_basic_hours = config.practical.training_basic_hours;
        data.practical.training_extra_hours_price = config.practical.training_extra_hours_price;
        data.practical.extra_training_hours_amount = config.practical.extra_training_hours_amount;
        data.practical.practical_exam_fee_price = config.practical.practical_exam_fee_price;
        data.practical.vehicle_handling_price = config.practical.vehicle_handling_price;
        
        // First aid
        data.first_aid.training_basic_price = config.first_aid.training_basic_price;
        data.first_aid.exam_fee = config.first_aid.exam_fee;
        
        // Others
        data.others.administration_fee = config.others.administration_fee;
        data.others.document_fee = config.others.document_fee;
        
       // console.log(`Set data for ${key}`, data);
    } else {
        // Ha nincs specifikus konfiguráció, használjuk az alapértelmezettet
        restoreDefaultData();
       // console.log(`No specific config for ${key}, using defaults`, data);
    }
}

function showMedicalSection(value) {
    if (!isNaN(value) && value !== null) {
        document.getElementById('medical-row').classList.remove('d-none');
    } else {
        document.getElementById('medical-row').classList.add('d-none');
    }
}

function showPrevCategoryFromSection(value) {
    if (value === true) {
        document.getElementById('prev-category-from').classList.remove('d-none');
    } else {
        document.getElementById('prev-category-from').classList.add('d-none');
    }
}

// Előző kategória rádiók engedélyezése/tiltása
function setPrevCategoryState(allowedPrevCategories = []) {
    const inputs = document.querySelectorAll('input[name="prev_category"]');
    const allowed = new Set(['none', ...allowedPrevCategories]);
    let hasCheckedAllowed = false;

    inputs.forEach((input) => {
        if (allowed.has(input.value)) {
            input.disabled = false;
            if (input.checked) {
                hasCheckedAllowed = true;
            }
        } else {
            input.disabled = true;
            input.checked = false;
        }
    });

    if (!hasCheckedAllowed) {
        const noneInput = document.querySelector('input[name="prev_category"][value="none"]');
        if (noneInput && !noneInput.disabled) {
            noneInput.checked = true;
        }
    }
}

// Külső hívható helper: ezek az előző kategóriák legyenek aktívak
function activate_prev_categories(categories = []) {
    setPrevCategoryState(categories);
}

// Végösszeg számítás (későbbi bővítés)
function calculateOutcome(data) {
    let total = 0;

    // Orvosi alkalmassági vizsgálat
    if (data.medical_price !== null && data.medical_price !== undefined) {
        total += data.medical_price;
    }
    // Elméleti képzés és vizsgadíj
    total += data.theoritical.training_price;
    total += data.theoritical.exam_fee;

    // Gyakorlati képzés és vizsgadíj
    total += data.practical.training_basic_hours_price * data.practical.training_basic_hours;
    total += data.practical.training_extra_hours_price * data.practical.extra_training_hours_amount;
    total += data.practical.practical_exam_fee_price;
    total += data.practical.vehicle_handling_price;

    // Elsősegély tanfolyam és vizsgadíj
    total += data.first_aid.training_basic_price;
    total += data.first_aid.exam_fee;

    // Egyéb költségek
    total += data.others.administration_fee;
    total += data.others.document_fee;

    data.outcome = total;
}

export function initApp() {
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('category-form');
        if (!form) {
            return;
        }

        // Aktuális választások beolvasása és szabályok futtatása
        const run = () => {
            const category = form.querySelector('input[name="category"]:checked')?.value || '';
            activatePrevCategories(category);
            const prevCategory = form.querySelector('input[name="prev_category"]:checked')?.value || 'none';
            pairCategories(category, prevCategory);
            showMedicalSection(data.medical_price);
            showPrevCategoryFromSection(data.prev_category_from);
            calculateOutcome(data);
        };

        // Alapból csak a "none" engedélyezett
        setPrevCategoryState([]);
        form.addEventListener('change', run);
        run();
    });
}
