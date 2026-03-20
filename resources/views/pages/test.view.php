<div class="container mt-10">
    <!-- Categories section -->
    <div class="row">
        <div class="col-12">
            <form id="category-form" class="space-y-6">
                <section>
                    <div class="mb-6">
                        <div class="mb-2 fw-bold">Kategória</div>
                        <div class="btn-group" role="group" aria-label="Kategória">
                            <input type="radio" class="btn-check" name="category" id="cat-am" value="AM">
                            <label class="btn btn-outline-dark" for="cat-am">AM</label>

                            <input type="radio" class="btn-check" name="category" id="cat-a1" value="A1">
                            <label class="btn btn-outline-dark" for="cat-a1">A1</label>

                            <input type="radio" class="btn-check" name="category" id="cat-a2" value="A2">
                            <label class="btn btn-outline-dark" for="cat-a2">A2</label>

                            <input type="radio" class="btn-check" name="category" id="cat-a" value="A">
                            <label class="btn btn-outline-dark" for="cat-a">A</label>

                            <input type="radio" class="btn-check" name="category" id="cat-b" value="B"
                                checked>
                            <label class="btn btn-outline-dark" for="cat-b">B</label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="mb-2 fw-bold">Előző kategória</div>
                        <div class="btn-group" role="group" aria-label="Előző kategória">
                            <input type="radio" class="btn-check" name="prev_category" id="prev-am" value="AM">
                            <label class="btn btn-outline-dark" for="prev-am">AM</label>

                            <input type="radio" class="btn-check" name="prev_category" id="prev-a1" value="A1">
                            <label class="btn btn-outline-dark" for="prev-a1">A1</label>

                            <input type="radio" class="btn-check" name="prev_category" id="prev-a2" value="A2">
                            <label class="btn btn-outline-dark" for="prev-a2">A2</label>

                            <input type="radio" class="btn-check" name="prev_category" id="prev-a" value="A">
                            <label class="btn btn-outline-dark" for="prev-a">A</label>

                            <input type="radio" class="btn-check" name="prev_category" id="prev-b" value="B">
                            <label class="btn btn-outline-dark" for="prev-b">B</label>

                            <input type="radio" class="btn-check" name="prev_category" id="prev-none" value="none"
                                checked>
                            <label class="btn btn-outline-dark" for="prev-none">Nincs</label>
                        </div>
                    </div>
                </section>
            </form>
        </div>

        <div class="col-12 d-none" id="prev-category-from">
            <div class="card mb-4">
                <div class="card-header fw-bold">Hány éve van jogosítványa?</div>
                <div class="card-body">
                    <div class="btn-group" role="group" aria-label="Évek száma">
                        <input type="radio" class="btn-check" name="prev_category_from_more_than_2_years" id="year-less-2"
                            value="less_2" checked>
                        <label class="btn btn-outline-dark" for="year-less-2">Kevesebb mint 2 éve</label>

                        <input type="radio" class="btn-check" name="prev_category_from_more_than_2_years" id="year-more-2"
                            value="more_2">
                        <label class="btn btn-outline-dark" for="year-more-2">Több mint 2 éve</label>
                    </div>
                </div>
            </div>
        </div>
        <!-- Medical section -->
        <div class="row d-none" id="medical-row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header fw-bold">Orvosi alkalmassági vizsgálat</div>
                    <div class="card-body">
                        <p>Ár: <span id="medical_price_display">7500</span> Ft</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

