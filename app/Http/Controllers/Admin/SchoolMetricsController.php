<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolMetric;
use App\Services\SchoolMetricsImporter;

class SchoolMetricsController extends Controller
{
    private const PREVIEW_SESSION_KEY = 'school_metrics_preview';

    public function index()
    {
        return $this->view('pages.admin.school-metrics.index', array_merge(
            $this->baseViewData(),
            ['title' => 'Iskola mutatók (VSM / ÁKÓ)', 'preview' => null]
        ), 'layouts.admin-layout');
    }

    /**
     * Felvitt adatok böngészése: szerver oldali szűrés + lapozás.
     */
    public function browse()
    {
        $search   = trim((string) ($_GET['q'] ?? ''));
        $category = trim((string) ($_GET['category'] ?? ''));
        $year     = (int) ($_GET['year'] ?? 0);
        $quarter  = (int) ($_GET['quarter'] ?? 0);

        $query = SchoolMetric::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('school_name', 'like', '%' . $search . '%')
                  ->orWhere('school_ext_id', 'like', '%' . $search . '%');
            });
        }
        if ($category !== '') {
            $query->where('category', $category);
        }
        if ($year >= 2000 && $year <= 2100) {
            $query->where('year', $year);
        }
        if ($quarter >= 1 && $quarter <= 4) {
            $query->where('quarter', $quarter);
        }

        // Csak a kitöltött szűrőket fűzzük a lapozó linkekhez
        $appends = array_filter([
            'q'        => $search !== '' ? $search : null,
            'category' => $category !== '' ? $category : null,
            'year'     => ($year >= 2000 && $year <= 2100) ? $year : null,
            'quarter'  => ($quarter >= 1 && $quarter <= 4) ? $quarter : null,
        ], static fn($v) => $v !== null);

        $metrics = $query
            ->orderBy('school_name')
            ->orderBy('category')
            ->orderBy('year')
            ->orderBy('quarter')
            ->paginate(50)
            ->appends($appends);

        // Szűrő legördülők feltöltése a ténylegesen jelen lévő értékekből
        $availableCategories = SchoolMetric::query()->select('category')->distinct()->orderBy('category')->pluck('category')->all();
        $availablePeriods = SchoolMetric::query()
            ->selectRaw('year, quarter')->distinct()
            ->orderByDesc('year')->orderByDesc('quarter')->get();

        return $this->view('pages.admin.school-metrics.browse', [
            'title'               => 'Felvitt mutatók böngészése',
            'metrics'             => $metrics,
            'filters'             => ['q' => $search, 'category' => $category, 'year' => $year, 'quarter' => $quarter],
            'availableCategories' => $availableCategories,
            'availablePeriods'    => $availablePeriods,
            'totalRows'           => SchoolMetric::query()->count(),
        ], 'layouts.admin-layout');
    }

    /**
     * A két teljes fájl feltöltése + előnézet. Semmit nem ír a DB-be.
     */
    public function preview()
    {
        $this->verifyCsrf();

        $vsm = $_FILES['vsm_file'] ?? null;
        $ako = $_FILES['ako_file'] ?? null;

        if (!$this->validUpload($vsm) || !$this->validUpload($ako)) {
            return $this->toast('danger', 'Mindkét fájl (VSM és ÁKÓ) feltöltése kötelező.')->redirect('/admin/iskola-mutatok');
        }

        $importer = new SchoolMetricsImporter();

        try {
            $result = $importer->preview($vsm['tmp_name'], $ako['tmp_name'], $vsm['name'], $ako['name']);
        } catch (\Throwable $e) {
            return $this->toast('danger', 'Hiba a feldolgozás során: ' . $e->getMessage())
                ->redirect('/admin/iskola-mutatok');
        }

        // Az előnézet adatait a sessionben tároljuk a megerősítésig
        $_SESSION[self::PREVIEW_SESSION_KEY] = ['rows' => $result['rows']];

        return $this->view('pages.admin.school-metrics.index', array_merge(
            $this->baseViewData(),
            [
                'title'   => 'Iskola mutatók — Előnézet',
                'preview' => [
                    'rows'       => $result['rows'],
                    'warnings'   => $result['warnings'],
                    'periods'    => $result['periods'],
                    'categories' => $result['categories'],
                ],
            ]
        ), 'layouts.admin-layout');
    }

    /**
     * Megerősítés: teljes tábla cseréje az új fájl tartalmára.
     */
    public function store()
    {
        $this->verifyCsrf();

        $data = $_SESSION[self::PREVIEW_SESSION_KEY] ?? null;
        if (!is_array($data) || empty($data['rows'])) {
            return $this->toast('warning', 'Nincs előnézeti adat. Töltsd fel újra a fájlokat.')
                ->redirect('/admin/iskola-mutatok');
        }

        $importer = new SchoolMetricsImporter();

        try {
            $count = $importer->store($data['rows']);
        } catch (\Throwable $e) {
            return $this->toast('danger', 'Mentési hiba: ' . $e->getMessage())
                ->redirect('/admin/iskola-mutatok');
        }

        unset($_SESSION[self::PREVIEW_SESSION_KEY]);

        return $this->toast('success', sprintf('%d sor sikeresen elmentve. A korábbi adatok lecserélve.', $count))
            ->redirect('/admin/iskola-mutatok');
    }

    /**
     * Áttekintés: mennyi adat van jelenleg, negyedév/kategória bontásban.
     */
    private function baseViewData(): array
    {
        $existing = SchoolMetric::query()
            ->selectRaw('year, quarter, category, COUNT(*) as cnt')
            ->groupBy('year', 'quarter', 'category')
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->orderBy('category')
            ->get();

        return [
            'totalRows' => SchoolMetric::query()->count(),
            'existing'  => $existing,
        ];
    }

    private function validUpload(?array $file): bool
    {
        return is_array($file)
            && ($file['error'] ?? \UPLOAD_ERR_NO_FILE) === \UPLOAD_ERR_OK
            && ($file['tmp_name'] ?? '') !== ''
            && is_uploaded_file($file['tmp_name']);
    }
}
