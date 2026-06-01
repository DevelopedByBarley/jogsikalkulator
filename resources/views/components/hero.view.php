<style>
    #hero {
        position: relative;
        min-height: 100vh;
        background-image: url('/public/assets/main-image.jpg');
        background-size: cover;
        background-position: center;
    }

    #hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            rgba(0,0,0,0.45) 0%,
            rgba(0,0,0,0.25) 50%,
            rgba(0,0,0,0.72) 100%
        );
        pointer-events: none;
    }

    #hero .hero-link {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.18);
        color: #fff;
        text-decoration: none;
        transition: background 0.2s, border-color 0.2s, transform 0.15s;
    }

    #hero .hero-link:hover {
        background: rgba(255,255,255,0.2);
        border-color: rgba(255,255,255,0.35);
        transform: translateX(4px);
        color: #fff;
    }

    #hero .hero-link .arrow {
        flex-shrink: 0;
        opacity: 0;
        transform: translateX(-4px);
        transition: opacity 0.2s, transform 0.2s;
    }

    #hero .hero-link:hover .arrow {
        opacity: 1;
        transform: translateX(0);
    }
</style>

<section id="hero" class="d-flex align-items-center">
    <div class="container position-relative" style="z-index:1">
        <div class="row align-items-center g-5 py-5">

            <!-- Bal: főcím -->
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="fw-bold text-white lh-sm mb-3" style="font-size: clamp(2rem, 3.5vw, 3rem); letter-spacing: -0.02em;">
                    Jogosítvány szerzés<br>egyszerűen, átláthatóan.
                </h1>
                <p class="text-white-50 mb-4" style="font-size: 1.05rem; line-height: 1.65;">
                    Segítünk kiszámolni a várható költségeket, megérteni a képzési folyamatot és megtalálni a legjobb autósiskolát.
                </p>
                <a href="/#category-form" class="btn btn-success d-inline-flex align-items-center gap-2 fw-semibold px-4 py-2">
                    Kalkulátor indítása
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                    </svg>
                </a>
            </div>

            <!-- Jobb: linkek -->
            <div class="col-lg-6 d-none d-lg-block">
                <span class="badge mb-3 px-3 py-2 fs-6 fw-semibold" style="background:#16a34a;">
                    Miben segít neked a jogsikalkulator.hu?
                </span>
                <div class="d-flex flex-column gap-2">
                    <a href="/about" class="hero-link d-flex align-items-center justify-content-between gap-3 rounded-3 px-3 py-3 fs-6">
                        <span>Eligazít a jogosítványszerzés bonyolult rendszerében</span>
                        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                        </svg>
                    </a>
                    <a href="/kepzes-menete" class="hero-link d-flex align-items-center justify-content-between gap-3 rounded-3 px-3 py-3 fs-6">
                        <span>Bemutatja, milyen képzéseken és vizsgákon keresztül juthatsz el a jogosítványhoz</span>
                        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                        </svg>
                    </a>
                    <a href="/posts" class="hero-link d-flex align-items-center justify-content-between gap-3 rounded-3 px-3 py-3 fs-6">
                        <span>Tippeket ad, milyen csábítási trükköknek ne dőlj be</span>
                        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                        </svg>
                    </a>
                    <a href="/#category-form" class="hero-link d-flex align-items-center justify-content-between gap-3 rounded-3 px-3 py-3 fs-6">
                        <span>Segít kiszámolni, mennyibe kerül majd a jogosítványod</span>
                        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                        </svg>
                    </a>
                    <a href="/iskolavalasztas" class="hero-link d-flex align-items-center justify-content-between gap-3 rounded-3 px-3 py-3 fs-6">
                        <span>Megmutatja, hogyan érdemes választani az iskolák közül</span>
                        <svg class="arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
