<?php
    /** @var \Illuminate\Pagination\LengthAwarePaginator $metrics */
    /** @var array $filters */
    /** @var array $availableCategories */
    /** @var \Illuminate\Support\Collection $availablePeriods */
    /** @var int $totalRows */

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

<!-- Page Header -->
<div class="tw-bg-[linear-gradient(135deg,#0f172a_0%,#1e293b_50%,#450a0a_100%)] tw-py-10 tw-relative tw-overflow-hidden">
    <div class="tw-absolute tw-top-[-60px] tw-right-[-60px] tw-w-[300px] tw-h-[300px] tw-rounded-full tw-pointer-events-none tw-bg-[radial-gradient(circle,rgba(239,68,68,0.12)_0%,transparent_70%)]"></div>
    <div class="tw-absolute tw-bottom-[-80px] tw-left-[-40px] tw-w-[350px] tw-h-[350px] tw-rounded-full tw-pointer-events-none tw-bg-[radial-gradient(circle,rgba(220,38,38,0.08)_0%,transparent_70%)]"></div>
    <div class="container tw-relative tw-z-10">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge px-3 py-1 fw-semibold tw-bg-[rgba(239,68,68,0.18)] tw-text-red-300 tw-border tw-border-[rgba(239,68,68,0.3)] tw-rounded-full tw-text-[0.75rem] tw-tracking-[0.05em]">
                        ✦ Adatbázis
                    </span>
                </div>
                <h1 class="fw-bold mb-1 tw-text-slate-50 tw-text-[1.75rem]">Felvitt mutatók böngészése</h1>
                <p class="mb-0 small tw-text-slate-500"><?= number_format((int) $totalRows) ?> sor összesen</p>
            </div>
            <a href="/admin/iskola-mutatok"
               class="btn btn-sm fw-semibold tw-bg-white/[0.06] tw-text-slate-200 tw-border tw-border-white/[0.12] tw-rounded-[10px] tw-transition-all tw-duration-200 hover:tw-bg-white/10 text-decoration-none">
                ← Új feltöltés
            </a>
        </div>
    </div>
</div>

<div class="container py-4">

    <!-- Szűrők (szerver oldali, GET) -->
    <div class="card border-0 shadow-sm tw-rounded-2xl mb-3">
        <div class="card-body p-4">
            <form method="GET" action="/admin/iskola-mutatok/bongeszes" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-medium small tw-text-[var(--text-muted)]">Keresés (név vagy azonosító)</label>
                    <input type="text" name="q" class="form-control"
                           value="<?= htmlspecialchars((string) $filters['q'], ENT_QUOTES, 'UTF-8') ?>"
                           placeholder="pl. 18 MK vagy 0674">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-medium small tw-text-[var(--text-muted)]">Kategória</label>
                    <select name="category" class="form-select">
                        <option value="">Összes</option>
                        <?php foreach ($availableCategories as $cat): ?>
                            <option value="<?= htmlspecialchars((string) $cat, ENT_QUOTES, 'UTF-8') ?>"
                                <?= (string) $filters['category'] === (string) $cat ? 'selected' : '' ?>>
                                <?= htmlspecialchars((string) $cat, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-medium small tw-text-[var(--text-muted)]">Időszak</label>
                    <select name="period" class="form-select" id="periodSelect"
                            onchange="var v=this.value.split('-');document.getElementById('yearInput').value=v[0]||'';document.getElementById('quarterInput').value=v[1]||'';">
                        <option value="">Összes</option>
                        <?php foreach ($availablePeriods as $p): ?>
                            <?php $val = $p->year . '-' . $p->quarter; ?>
                            <option value="<?= $val ?>"
                                <?= ((int) $filters['year'] === (int) $p->year && (int) $filters['quarter'] === (int) $p->quarter) ? 'selected' : '' ?>>
                                <?= (int) $p->year ?>. év <?= (int) $p->quarter ?>. n.év
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="year" id="yearInput" value="<?= (int) $filters['year'] ?: '' ?>">
                    <input type="hidden" name="quarter" id="quarterInput" value="<?= (int) $filters['quarter'] ?: '' ?>">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit"
                            class="btn btn-sm fw-semibold tw-bg-[linear-gradient(135deg,#ef4444,#dc2626)] tw-text-white tw-border-0 tw-rounded-[10px] tw-px-3 tw-py-2 tw-flex-1 text-nowrap">
                        Szűrés
                    </button>
                    <a href="/admin/iskola-mutatok/bongeszes"
                       class="btn btn-sm fw-semibold tw-bg-[var(--bg-body)] tw-text-[var(--text-muted)] tw-border tw-border-[var(--border)] tw-rounded-[10px] tw-px-3 tw-py-2 text-decoration-none d-flex align-items-center">
                        ✕
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Táblázat -->
    <div class="card border-0 shadow-sm tw-rounded-2xl">
        <div class="card-body p-0">
            <?php if ($metrics->total() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 tw-text-sm">
                        <thead>
                            <tr class="tw-bg-[var(--bg-body)]">
                                <th class="px-4 py-3 fw-semibold border-0 tw-text-[var(--text-muted)] tw-text-[0.72rem] text-uppercase tw-tracking-[0.05em]">Iskola</th>
                                <th class="px-2 py-3 fw-semibold border-0 tw-text-[var(--text-muted)] tw-text-[0.72rem] text-uppercase tw-tracking-[0.05em]">Azon.</th>
                                <th class="px-2 py-3 fw-semibold border-0 tw-text-[var(--text-muted)] tw-text-[0.72rem] text-uppercase tw-tracking-[0.05em]">Kat.</th>
                                <th class="px-2 py-3 fw-semibold border-0 tw-text-[var(--text-muted)] tw-text-[0.72rem] text-uppercase tw-tracking-[0.05em]">Időszak</th>
                                <th class="px-2 py-3 fw-semibold border-0 tw-text-[var(--text-muted)] tw-text-[0.72rem] text-uppercase tw-tracking-[0.05em] text-end">Elmélet</th>
                                <th class="px-2 py-3 fw-semibold border-0 tw-text-[var(--text-muted)] tw-text-[0.72rem] text-uppercase tw-tracking-[0.05em] text-end">Forgalom</th>
                                <th class="px-3 py-3 fw-semibold border-0 tw-text-[var(--text-muted)] tw-text-[0.72rem] text-uppercase tw-tracking-[0.05em] text-end">ÁKÓ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($metrics as $m): ?>
                                <tr>
                                    <td class="px-4 py-2 border-0 fw-medium tw-text-[var(--text-main)]">
                                        <?= htmlspecialchars((string) $m->school_name, ENT_QUOTES, 'UTF-8') ?>
                                    </td>
                                    <td class="px-2 py-2 border-0 tw-text-[var(--text-muted)] small">
                                        <?= htmlspecialchars((string) ($m->school_ext_id ?? '—'), ENT_QUOTES, 'UTF-8') ?>
                                    </td>
                                    <td class="px-2 py-2 border-0 tw-text-[var(--text-muted)] small">
                                        <?= htmlspecialchars((string) $m->category, ENT_QUOTES, 'UTF-8') ?>
                                    </td>
                                    <td class="px-2 py-2 border-0 tw-text-[var(--text-muted)] small text-nowrap">
                                        <?= (int) $m->year ?>.<?= (int) $m->quarter ?>
                                    </td>
                                    <td class="px-2 py-2 border-0 text-end tw-text-[var(--text-main)]"><?= $renderCell($m->vsm_theory, $m->vsm_theory_raw) ?></td>
                                    <td class="px-2 py-2 border-0 text-end tw-text-[var(--text-main)]"><?= $renderCell($m->vsm_traffic, $m->vsm_traffic_raw) ?></td>
                                    <td class="px-3 py-2 border-0 text-end tw-text-[var(--text-main)]"><?= $renderCell($m->ako_practical, $m->ako_practical_raw) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3">
                    <?php paginate($metrics); ?>
                </div>
            <?php else: ?>
                <div class="d-flex flex-column align-items-center justify-content-center py-5 tw-text-[var(--text-muted)]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="mb-3 opacity-50" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                    <p class="small mb-0">
                        <?= (int) $totalRows > 0 ? 'Nincs a szűrésnek megfelelő találat.' : 'Még nincs feltöltött adat.' ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
