<?php
    /** @var int $totalRows */
    /** @var \Illuminate\Support\Collection $existing */
    /** @var array|null $preview */
?>

<!-- Page Header -->
<div class="tw-bg-[linear-gradient(135deg,#0f172a_0%,#1e293b_50%,#450a0a_100%)] tw-py-10 tw-relative tw-overflow-hidden">
    <div class="tw-absolute tw-top-[-60px] tw-right-[-60px] tw-w-[300px] tw-h-[300px] tw-rounded-full tw-pointer-events-none tw-bg-[radial-gradient(circle,rgba(239,68,68,0.12)_0%,transparent_70%)]"></div>
    <div class="tw-absolute tw-bottom-[-80px] tw-left-[-40px] tw-w-[350px] tw-h-[350px] tw-rounded-full tw-pointer-events-none tw-bg-[radial-gradient(circle,rgba(220,38,38,0.08)_0%,transparent_70%)]"></div>
    <div class="container tw-relative tw-z-10">
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge px-3 py-1 fw-semibold tw-bg-[rgba(239,68,68,0.18)] tw-text-red-300 tw-border tw-border-[rgba(239,68,68,0.3)] tw-rounded-full tw-text-[0.75rem] tw-tracking-[0.05em]">
                ✦ Adatimport
            </span>
        </div>
        <h1 class="fw-bold mb-1 tw-text-slate-50 tw-text-[1.75rem]">Iskola mutatók (VSM / ÁKÓ)</h1>
        <p class="mb-0 small tw-text-slate-500">A teljes negyedéves VSM és ÁKÓ táblázat feltöltése — minden kategória és negyedév egyszerre</p>
    </div>
</div>

<div class="container py-4">
    <div class="row g-3">

        <!-- Feltöltő űrlap -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm tw-rounded-2xl mb-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="tw-w-8 tw-h-8 tw-rounded-lg d-flex align-items-center justify-content-center tw-bg-[linear-gradient(135deg,rgba(239,68,68,0.15),rgba(220,38,38,0.15))]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="#ef4444" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                            </svg>
                        </div>
                        <span class="fw-semibold tw-text-[var(--text-main)] tw-text-[0.95rem]">Új adat feltöltése</span>
                    </div>
                    <p class="small tw-text-[var(--text-muted)] mb-4">
                        Mentéskor a <strong>teljes korábbi adat lecserélődik</strong> az új fájlok tartalmára.
                        A fájl minden kategóriája (AM, A, B, C…) és minden negyedéve bekerül.
                    </p>

                    <form method="POST" action="/admin/iskola-mutatok/elonezet" enctype="multipart/form-data">
                        <?= csrf() ?>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium small tw-text-[var(--text-muted)]">
                                    VSM fájl <span class="tw-text-red-500">*</span>
                                </label>
                                <input type="file" name="vsm_file" class="form-control" accept=".xlsx,.csv" required>
                                <div class="form-text small">Vizsga Sikerességi Mutató (Elmélet, Forgalom)</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium small tw-text-[var(--text-muted)]">
                                    ÁKÓ fájl <span class="tw-text-red-500">*</span>
                                </label>
                                <input type="file" name="ako_file" class="form-control" accept=".xlsx,.csv" required>
                                <div class="form-text small">Átlagos Képzési Óraszám (Gyakorlat)</div>
                            </div>
                        </div>

                        <button type="submit"
                                class="btn btn-sm fw-semibold tw-bg-[linear-gradient(135deg,#ef4444,#dc2626)] tw-text-white tw-border-0 tw-rounded-[10px] tw-px-4 tw-py-2 tw-shadow-[0_2px_10px_rgba(239,68,68,0.3)] tw-transition-all tw-duration-200 hover:tw--translate-y-px">
                            Előnézet megtekintése
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Aktuális állapot -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm tw-rounded-2xl h-100">
                <div class="card-body p-4">
                    <h6 class="fw-semibold mb-3 tw-text-[var(--text-main)] tw-text-[0.85rem] text-uppercase tw-tracking-[0.06em]">
                        Jelenlegi adatbázis
                    </h6>
                    <div class="fw-bold mb-3 tw-text-[1.75rem] tw-leading-none tw-text-[var(--text-main)]">
                        <?= number_format((int) $totalRows) ?>
                        <span class="fw-medium tw-text-[0.8rem] tw-text-[var(--text-muted)]">sor</span>
                    </div>
                    <?php if ($existing->count() > 0): ?>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2 tw-max-h-[260px] tw-overflow-auto">
                            <?php foreach ($existing as $e): ?>
                                <li class="d-flex align-items-center justify-content-between px-3 py-2 tw-rounded-lg tw-bg-[var(--bg-body)] tw-border tw-border-[var(--border)]">
                                    <span class="fw-medium small tw-text-[var(--text-main)]">
                                        <?= (int) $e->year ?>.<?= (int) $e->quarter ?>.n.év
                                        <span class="tw-text-[var(--text-muted)]">· <?= htmlspecialchars($e->category ?: '—', ENT_QUOTES, 'UTF-8') ?></span>
                                    </span>
                                    <span class="badge tw-bg-[rgba(239,68,68,0.1)] tw-text-red-500 tw-rounded-[8px] tw-text-[0.7rem]">
                                        <?= number_format((int) $e->cnt) ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="small mb-0 tw-text-[var(--text-muted)]">Még nincs feltöltött adat.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($preview)): ?>
        <?php
            $rows = $preview['rows'];
            $warnings = $preview['warnings'];
            $matchedCount = count(array_filter($rows, static fn($r) => $r['matched']));
            $totalCount = count($rows);
            $displayLimit = 300;

            $renderCell = static function (?float $num, ?string $raw): string {
                if ($num !== null) {
                    return number_format($num, 2) . '%';
                }
                if ($raw === 'X') {
                    return '<span class="tw-text-slate-400" title="Nem indult képzés">X</span>';
                }
                if ($raw === '-') {
                    return '<span class="tw-text-slate-400" title="Nincs elég vizsga az adatközléshez">–</span>';
                }
                return '<span class="tw-text-slate-400">—</span>';
            };
        ?>

        <!-- Előnézet -->
        <div class="card border-0 shadow-sm tw-rounded-2xl mt-3">
            <div class="card-body p-0">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 px-4 py-3 tw-border-b tw-border-[var(--border)]">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="fw-semibold tw-text-[var(--text-main)] tw-text-[0.95rem]">Előnézet</span>
                        <span class="badge tw-bg-[rgba(59,130,246,0.12)] tw-text-blue-500 tw-rounded-[8px] tw-text-[0.72rem] fw-semibold">
                            <?= number_format($totalCount) ?> sor
                        </span>
                        <span class="badge tw-bg-[rgba(16,185,129,0.12)] tw-text-emerald-500 tw-rounded-[8px] tw-text-[0.72rem] fw-semibold">
                            <?= $matchedCount ?> párosítva
                        </span>
                        <span class="badge tw-bg-[rgba(148,163,184,0.15)] tw-text-slate-400 tw-rounded-[8px] tw-text-[0.72rem] fw-semibold">
                            Kategóriák: <?= htmlspecialchars(implode(', ', $preview['categories']), ENT_QUOTES, 'UTF-8') ?>
                        </span>
                        <span class="badge tw-bg-[rgba(148,163,184,0.15)] tw-text-slate-400 tw-rounded-[8px] tw-text-[0.72rem] fw-semibold">
                            Időszakok: <?= htmlspecialchars(implode(', ', $preview['periods']), ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </div>

                    <form method="POST" action="/admin/iskola-mutatok" class="m-0"
                          onsubmit="return confirm('Biztosan mented? A TELJES korábbi adat lecserélődik erre a(z) <?= number_format($totalCount) ?> sorra.');">
                        <?= csrf() ?>
                        <button type="submit"
                                class="btn btn-sm fw-semibold tw-bg-[linear-gradient(135deg,#10b981,#059669)] tw-text-white tw-border-0 tw-rounded-[10px] tw-px-4 tw-py-2 tw-shadow-[0_2px_10px_rgba(16,185,129,0.3)] tw-transition-all tw-duration-200 hover:tw--translate-y-px">
                            ✓ Mentés az adatbázisba
                        </button>
                    </form>
                </div>

                <?php if (!empty($warnings)): ?>
                    <div class="px-4 pt-3">
                        <div class="alert alert-warning tw-rounded-xl small mb-0">
                            <?php foreach ($warnings as $w): ?>
                                <div><?= htmlspecialchars($w, ENT_QUOTES, 'UTF-8') ?></div>
                            <?php endforeach; ?>
                            <div class="mt-1 tw-text-[var(--text-muted)]">A hiányzó mutatók üresen kerülnek mentésre.</div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Szűrő (kliens oldali) -->
                <div class="px-4 pt-3 pb-1 d-flex flex-wrap gap-2 align-items-center">
                    <input type="text" id="smSearch" class="form-control form-control-sm tw-max-w-[280px]"
                           placeholder="Iskola keresése az előnézetben…">
                    <select id="smCategory" class="form-select form-select-sm tw-max-w-[220px]">
                        <option value="">Összes kategória</option>
                        <?php foreach ($preview['categories'] as $cat): ?>
                            <option value="<?= htmlspecialchars($cat, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($cat, ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select id="smPeriod" class="form-select form-select-sm tw-max-w-[160px]">
                        <option value="">Összes időszak</option>
                        <?php foreach ($preview['periods'] as $p): ?>
                            <option value="<?= htmlspecialchars($p, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($p, ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="small tw-text-[var(--text-muted)] ms-auto">
                        Előnézetben az első <?= $displayLimit ?> sor jelenik meg; mentésre mind a <?= number_format($totalCount) ?> kerül.
                    </span>
                </div>

                <div class="table-responsive mt-1">
                    <table class="table table-hover align-middle mb-0 tw-text-sm" id="smTable">
                        <thead>
                            <tr class="tw-bg-[var(--bg-body)]">
                                <th class="px-4 py-3 fw-semibold border-0 tw-text-[var(--text-muted)] tw-text-[0.72rem] text-uppercase tw-tracking-[0.05em]">Iskola</th>
                                <th class="px-2 py-3 fw-semibold border-0 tw-text-[var(--text-muted)] tw-text-[0.72rem] text-uppercase tw-tracking-[0.05em]">Azon.</th>
                                <th class="px-2 py-3 fw-semibold border-0 tw-text-[var(--text-muted)] tw-text-[0.72rem] text-uppercase tw-tracking-[0.05em]">Kat.</th>
                                <th class="px-2 py-3 fw-semibold border-0 tw-text-[var(--text-muted)] tw-text-[0.72rem] text-uppercase tw-tracking-[0.05em]">Időszak</th>
                                <th class="px-2 py-3 fw-semibold border-0 tw-text-[var(--text-muted)] tw-text-[0.72rem] text-uppercase tw-tracking-[0.05em] text-end">Elmélet</th>
                                <th class="px-2 py-3 fw-semibold border-0 tw-text-[var(--text-muted)] tw-text-[0.72rem] text-uppercase tw-tracking-[0.05em] text-end">Forgalom</th>
                                <th class="px-2 py-3 fw-semibold border-0 tw-text-[var(--text-muted)] tw-text-[0.72rem] text-uppercase tw-tracking-[0.05em] text-end">ÁKÓ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($rows, 0, $displayLimit) as $r): ?>
                                <tr class="sm-row"
                                    data-name="<?= htmlspecialchars(mb_strtolower($r['school_name']), ENT_QUOTES, 'UTF-8') ?>"
                                    data-category="<?= htmlspecialchars($r['category'], ENT_QUOTES, 'UTF-8') ?>"
                                    data-period="<?= htmlspecialchars($r['period'], ENT_QUOTES, 'UTF-8') ?>">
                                    <td class="px-4 py-2 border-0 fw-medium tw-text-[var(--text-main)]">
                                        <?= htmlspecialchars($r['school_name'], ENT_QUOTES, 'UTF-8') ?>
                                    </td>
                                    <td class="px-2 py-2 border-0 tw-text-[var(--text-muted)] small">
                                        <?= htmlspecialchars($r['school_ext_id'] ?: '—', ENT_QUOTES, 'UTF-8') ?>
                                    </td>
                                    <td class="px-2 py-2 border-0 tw-text-[var(--text-muted)] small">
                                        <?= htmlspecialchars($r['category'], ENT_QUOTES, 'UTF-8') ?>
                                    </td>
                                    <td class="px-2 py-2 border-0 tw-text-[var(--text-muted)] small">
                                        <?= htmlspecialchars($r['period'], ENT_QUOTES, 'UTF-8') ?>
                                    </td>
                                    <td class="px-2 py-2 border-0 text-end tw-text-[var(--text-main)]"><?= $renderCell($r['vsm_theory'], $r['vsm_theory_raw']) ?></td>
                                    <td class="px-2 py-2 border-0 text-end tw-text-[var(--text-main)]"><?= $renderCell($r['vsm_traffic'], $r['vsm_traffic_raw']) ?></td>
                                    <td class="px-2 py-2 border-0 text-end tw-text-[var(--text-main)]"><?= $renderCell($r['ako_practical'], $r['ako_practical_raw']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            (function () {
                const search = document.getElementById('smSearch');
                const catSel = document.getElementById('smCategory');
                const perSel = document.getElementById('smPeriod');
                const rows = Array.prototype.slice.call(document.querySelectorAll('#smTable .sm-row'));

                function apply() {
                    const q = (search.value || '').toLowerCase().trim();
                    const cat = catSel.value;
                    const per = perSel.value;
                    rows.forEach(function (tr) {
                        const okName = !q || tr.dataset.name.indexOf(q) !== -1;
                        const okCat = !cat || tr.dataset.category === cat;
                        const okPer = !per || tr.dataset.period === per;
                        tr.style.display = (okName && okCat && okPer) ? '' : 'none';
                    });
                }
                [search, catSel, perSel].forEach(function (el) {
                    el.addEventListener('input', apply);
                    el.addEventListener('change', apply);
                });
            })();
        </script>
    <?php endif; ?>

</div>
