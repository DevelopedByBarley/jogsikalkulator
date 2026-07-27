<!-- Page header -->
<div class="about-hero">
    <div class="about-hero-overlay"></div>
    <div class="container about-hero-content">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="about-hero-title">Összehasonlítás</h1>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">

    <!-- Üres / kevés tétel -->
    <div id="compare-empty" class="text-center py-5 d-none">
        <p class="lead text-secondary" data-empty-text></p>
        <p class="text-secondary">
            Válassz ki egy autósiskolát a kalkulátor eredménye alatt, majd kattints a
            <strong>„Kiválasztás összehasonlításra"</strong> gombra.
        </p>
        <a href="/" class="btn btn-success mt-2">Vissza a kalkulátorhoz</a>
    </div>

    <!-- Fejléc sáv -->
    <div id="compare-toolbar" class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4 d-none">
        <p class="mb-0 text-secondary" id="compare-summary"></p>
        <div class="d-flex gap-2">
            <a href="/" class="btn btn-outline-secondary btn-sm">További iskola hozzáadása</a>
            <button type="button" class="btn btn-outline-danger btn-sm" id="compare-clear">Összes törlése</button>
        </div>
    </div>

    <!-- Kártyák egymás mellett -->
    <div id="compare-grid" class="cmp-grid d-none"></div>

</div>
