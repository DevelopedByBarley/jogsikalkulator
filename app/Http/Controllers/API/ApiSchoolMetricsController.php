<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\SchoolMetric;
use Core\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Publikus végpontok az autósiskola-mutatókhoz (kalkulátor eredmény blokk).
 *
 * Mindig a DB-ben elérhető LEGFRISSEBB negyedévvel dolgozunk
 * (SchoolMetric::latestPeriod()), így új Excel feltöltése után
 * a publikus oldal magától a friss adatot mutatja.
 */
class ApiSchoolMetricsController extends ApiController
{
    /** Élő kereső: iskolanévre illeszkedő találatok. */
    public function search(): JsonResponse
    {
        // Csak olvasunk: engedjük el a session zárat, hogy a gyors,
        // egymást követő keresőkérések ne torlódjanak egymásra.
        Session::close();

        $term = trim((string) ($_GET['q'] ?? ''));

        if (mb_strlen($term) < 2) {
            return $this->success([]);
        }

        $period = SchoolMetric::latestPeriod();
        if ($period === null) {
            return $this->success([]);
        }

        // Csak az utolsó negyedévben szereplő iskolák; egy iskola egyszer.
        $schools = SchoolMetric::query()
            ->selectRaw('MIN(id) as id, school_name, school_ext_id')
            ->where('year', $period['year'])
            ->where('quarter', $period['quarter'])
            ->where('school_name', 'like', '%' . $term . '%')
            ->groupBy('school_name', 'school_ext_id')
            ->orderBy('school_name')
            ->limit(15)
            ->get()
            ->map(static fn($s) => [
                'ext_id' => $s->school_ext_id,
                'name'   => $s->school_name,
            ])
            ->all();

        return $this->success($schools);
    }

    /** Egy iskola mutatói a kért kategóriában, a legfrissebb negyedévre. */
    public function show(): JsonResponse
    {
        Session::close();

        $extId    = trim((string) ($_GET['ext_id'] ?? ''));
        $category = trim((string) ($_GET['category'] ?? 'B'));

        if ($extId === '') {
            return $this->error('Hiányzó iskola azonosító.');
        }

        $fileCategory = SchoolMetric::mapCategory($category);
        if ($fileCategory === null) {
            return $this->error('Ehhez a kategóriához nem közölnek hatósági mutatót.');
        }

        $period = SchoolMetric::latestPeriod();
        if ($period === null) {
            return $this->notFound('Még nincs feltöltött adat.');
        }

        $metric = SchoolMetric::query()
            ->where('school_ext_id', $extId)
            ->where('category', $fileCategory)
            ->where('year', $period['year'])
            ->where('quarter', $period['quarter'])
            ->first();

        if ($metric === null) {
            return $this->notFound('Ehhez az iskolához nincs adat a választott kategóriában.');
        }

        return $this->success([
            'school_name' => $metric->school_name,
            'ext_id'      => $metric->school_ext_id,
            'category'    => $category,
            'period'      => [
                'year'    => $period['year'],
                'quarter' => $period['quarter'],
                'label'   => sprintf('%d. %d. negyedév', $period['year'], $period['quarter']),
            ],
            // value = szám vagy null; note = "X" / "-" ha nincs szám
            'vsm_theory'    => $this->cell($metric->vsm_theory, $metric->vsm_theory_raw),
            'vsm_traffic'   => $this->cell($metric->vsm_traffic, $metric->vsm_traffic_raw),
            'ako_practical' => $this->cell($metric->ako_practical, $metric->ako_practical_raw),
        ]);
    }

    /**
     * A nyers jelet beszédes szöveggé fordítjuk, hogy a felület
     * meg tudja különböztetni a "nincs adat"-ot a 0%-tól.
     *
     * @return array{value: ?float, note: ?string}
     */
    private function cell(?float $value, ?string $raw): array
    {
        if ($value !== null) {
            return ['value' => round($value, 2), 'note' => null];
        }

        $note = match ($raw) {
            'X'     => 'Nem indult képzés',
            '-'     => 'Nincs elég vizsga az adatközléshez',
            default => 'Nincs adat',
        };

        return ['value' => null, 'note' => $note];
    }
}
